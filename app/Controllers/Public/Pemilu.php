<?php


namespace App\Controllers\Public;

use App\Controllers\BaseController;

class Pemilu extends BaseController
{

    public function index(): string
    {
        $data = hasil_pemilu(date('Y'));

        return view('pemilu/landing', ['judul' => 'Hasil Pemilu', 'data' => $data]);
    }
}
