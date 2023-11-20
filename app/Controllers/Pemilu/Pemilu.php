<?php


namespace App\Controllers\Pemilu;

use App\Controllers\BaseController;

class Pemilu extends BaseController
{
    function __construct()
    {
        helper('functions');
        if (!session('id')) {
            gagal(base_url('login'), 'Anda belum login.');
        }
    }
    public function index(): string
    {

        $pondok = (session('gender') == 'L' ? 'Putra' : 'Putri');


        $db = db('pemilih', 'pemilu');

        if (session('role') == 'Admin' || session('role') == 'Root') {
            $pemilih = $db->where('pondok', $pondok)->where('absen', 1)->get()->getRowArray();
            if (!$pemilih) {
                gagal('kategori', 'Absen belum dipilih.');
            }
        } else {
            $pemilih = $db->where('no_id', session('no_id'))->get()->getRowArray();
        }


        $data = data_partai($pemilih);



        return view('pemilu/pemilu', ['judul' => $pemilih['nama'], 'pemilih' => $pemilih, 'partai' => $data]);
    }
}
