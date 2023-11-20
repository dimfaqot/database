<?php

namespace App\Controllers\Anggotakelas;

use App\Controllers\BaseController;

class Anggotakelas extends BaseController
{
    function __construct()
    {
        helper('functions');
        if (!session('id')) {
            gagal(base_url('login'), 'Anda belum login.');
        }
        check_role();
    }

    public function index()
    {

        return view('anggotakelas/anggotakelas', ['judul' => 'Anggota Kelas', 'data' => []]);
    }
}
