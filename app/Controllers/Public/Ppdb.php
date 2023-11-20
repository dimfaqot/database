<?php


namespace App\Controllers\Public;

use App\Controllers\BaseController;


class Ppdb extends BaseController
{

    public function index($sub = null, $gender = null): string
    {
        $tahun = tahun_santri('ppdb');
        $sub = ($sub == null ? 'SMP' : $sub);
        $gender = ($gender == null ? 'L' : $gender);

        $db = db('ppdb', 'santri');
        $db->select('no_id,nama,gender,sub,kabupaten');

        if ($tahun !== 'All') {
            $db->where('tahun_masuk', $tahun);
        }
        if ($sub !== 'All') {
            $db->where('sub', $sub);
        }

        if ($gender !== 'All') {
            $db->where('gender', $gender);
        }

        $q = $db->get()->getResultArray();

        return view('root/ppdb/landing', ['judul' => 'PPDB', 'data' => $q, 'sub' => ($sub == 'All' ? 'All' : $sub), 'gender' => ($gender == 'All' ? 'All' : $gender)]);
    }
}
