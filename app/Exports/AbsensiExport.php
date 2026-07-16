<?php

namespace App\Exports;

use App\Models\Absensi;
use App\Models\Pegawai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AbsensiExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $tanggalMulai;
    protected $tanggalSelesai;
    protected $rowNumber = 0;

    public function __construct(string $tanggalMulai, string $tanggalSelesai)
    {
        $this->tanggalMulai = $tanggalMulai;
        $this->tanggalSelesai = $tanggalSelesai;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Absensi::join('pegawai', 'absensi.id_pegawai', '=', 'pegawai.id_pegawai')
            ->whereBetween('absensi.tanggal', [$this->tanggalMulai, $this->tanggalSelesai])
            ->select(
                'pegawai.nama_pegawai',
                'absensi.tanggal',
                'absensi.jam_masuk',
                'absensi.jam_pulang',
                'absensi.status'
            )
            ->orderBy('absensi.tanggal')
            ->orderBy('pegawai.nama_pegawai')
            ->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama Pegawai',
            'Tanggal',
            'Jam Masuk',
            'Jam Pulang',
            'Status',
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        $this->rowNumber++;

        $statusMap = [
            'hadir' => 'Hadir',
            'alfa'  => 'Alfa',
            'izin'  => 'Izin',
            'cuti'  => 'Cuti',
        ];

        return [
            $this->rowNumber,
            $row->nama_pegawai,
            \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y'),
            $row->jam_masuk ?? '-',
            $row->jam_pulang ?? '-',
            $statusMap[$row->status] ?? $row->status ?? '-',
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Data Absensi';
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        // Auto-size columns
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [
            // Style the header row
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }
}
