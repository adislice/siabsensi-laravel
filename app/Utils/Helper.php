<?php

namespace App\Utils;

use Illuminate\Support\Facades\Storage;

class Helper
{
    public static function fileSize($file_path)
    {
        $bytes = Storage::disk('public')->size($file_path);
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}
