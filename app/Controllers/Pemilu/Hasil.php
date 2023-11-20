<?php


namespace App\Controllers\Pemilu;

use App\Controllers\BaseController;

class Hasil extends BaseController
{
    function __construct()
    {
        helper('functions');
        if (!session('id')) {
            gagal(base_url('login'), 'Anda belum login.');
        }
        check_role();
    }
    public function index($tahun): string
    {
        $data = hasil_pemilu($tahun);

        return view('pemilu/hasil', ['judul' => 'Hasil Pemilu', 'data' => $data, 'tahun' => $tahun]);
    }
}
