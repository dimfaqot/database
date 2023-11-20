<?php

namespace App\Controllers\Cari;

use App\Controllers\BaseController;

class Cari extends BaseController
{
    function __construct()
    {
        helper('functions');
        if (!session('id')) {
            gagal(base_url('login'), 'Anda belum login.');
        }
    }

    public function cari_nama_db()
    {
        $tabel = clear($this->request->getVar('tabel'));
        $val = $this->request->getVar('val');
        $gender = clear($this->request->getVar('gender'));

        $db = db($tabel, get_db($tabel));
        $db;
        if ($gender) {
            $db->where('gender', $gender);
        }
        $q = $db->like('nama', $val, 'both')->orderBy('nama', 'ASC')->limit(10)->get()->getResultArray();

        if ($tabel == 'karyawan') {
            $res = [];
            foreach ($q as $i) {
                $i['nama'] = nama_gelar($i);
            }
            $res[] = $i;
        }

        sukses_js('Koneksi sukses.', ($tabel == 'karyawan' ? $res : $q));
    }
}
