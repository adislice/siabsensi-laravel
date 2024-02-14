<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Absensi;
use App\Models\Jabatan;
use App\Models\Pegawai;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        

        Jabatan::create([
            'nama_jabatan' => 'Frontend Developer',
        ]);

        Jabatan::create([
            'nama_jabatan' => 'Backend Developer',
        ]);
        
        Pegawai::create([
            'nama_pegawai' => 'Rudy Zen',
            'nip' => '1',
            'jenis_kelamin' => 'laki-laki',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2000-01-01',
            'alamat' => 'Jl. Jend. Sudirman',
            'status' => 'aktif',
            'no_telp' => '08123456789',
            'id_jabatan' => 1,
            'password' => bcrypt('password'),
        ]);

        for ($i=0; $i < 50; $i++) { 
            Pegawai::create([
                'nama_pegawai' => fake()->name(),
                'nip' => fake()->ean8(),
                'jenis_kelamin' => fake()->randomElement(['laki-laki', 'perempuan']),
                'tempat_lahir' => fake()->city(),
                'tanggal_lahir' => fake()->date(),
                'alamat' => fake()->address(),
                'status' => fake()->randomElement(['aktif', 'nonaktif']),
                'no_telp' => fake()->phoneNumber(),
                'id_jabatan' => fake()->numberBetween(1, 2),
                'password' => bcrypt('password'),
            ]);
        }

        $startOfMonth = Carbon::createFromFormat('F Y', 'December 2023')->firstOfMonth();
        $today = Carbon::now()->subDays(2);
        $carbonPeriod = CarbonPeriod::create("01-12-2023", $today->format('d-m-Y'));

        $tgl = 1;
        
        foreach ($carbonPeriod as $date) {
            // $datee = Carbon::createFromFormat('d-m-Y', $tgl .'-12-2023');
            if($date->isWeekend()) {
                continue;
            }
            
            $id_pegawai = 1;
            while ($id_pegawai <= 10) {
                
                $tanggal = $date->format('Y-m-d');
                $status = fake()->randomElement(['cuti', 'hadir', 'alfa', 'izin']);
                $data_absensi = [
                    'id_pegawai' => $id_pegawai,
                    'tanggal' => $tanggal,
                    'status' => $status,
                    'latitude_masuk' => fake()->latitude(),
                    'longitude_masuk' => fake()->longitude(),
                ];
        
                if ($status == "hadir") {
                    $data_absensi['jam_masuk'] = '09:00:00';
                    $data_absensi['jam_pulang'] = '17:00:00';
                }
    
                Absensi::create($data_absensi);

                $id_pegawai = $id_pegawai + 1;
            }
            $tgl++;
            
        }

        \App\Models\Konfigurasi::create([
            'lokasi_absensi_latitude' => '-6.9096320',
            'lokasi_absensi_longitude' => '109.6952180',
            'radius_absensi' => 50.0,
            'jam_masuk_dari' => '08:00:00',
            'jam_masuk_sampai' => '09:00:00',
            'jam_pulang_dari' => '16:00:00',
            'jam_pulang_sampai' => '17:00:00',
            'jam_max_terlambat' => '10:00:00',
            'is_absensi_aktif' => true
        ]);

        \App\Models\Admin::create([
            'nama_admin' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
        ]);


    }
}
