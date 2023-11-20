<?php

namespace App\Controllers\Djana;

use App\Controllers\BaseController;

class tugasku extends BaseController
{
    function __construct()
    {
        helper('functions');
        if (!session('id')) {
            gagal(base_url('login'), 'Anda belum login.');
        }
        check_role();
    }
    public function index($tahun, $bulan, $order): string
    {
        return view('djana/' . menu()['controller'], ['judul' => menu()['menu'], 'data' => get_tugasku($tahun, $bulan, $order)]);
    }
    public function data_belum()
    {
        sukses_js('Koneksi sukses', get_data_belum(menu()['controller']));
    }
}
