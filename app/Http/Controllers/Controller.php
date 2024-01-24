<?php

namespace App\Http\Controllers;

use App\Models\Konfigurasi;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    function validation_error($errors)
    {
        $err = array();

        foreach ($errors->toArray() as $error) {
            foreach ($error as $sub_error) {
                array_push($err, $sub_error);
            }
        }

        $error_msg = implode("\n", $err);
        return $error_msg;
    }

    function getKonfigurasi($nama) {
        $konfigurasi = Konfigurasi::get($nama)->first();
        return $konfigurasi[$nama];
    }

    function generateUid() {
        return bin2hex(random_bytes(10));
    }
}
