<?php


namespace App\Controllers\Public;

use App\Controllers\BaseController;


class Recruitment extends BaseController
{

    public function index($sub = null, $pekerjaan = null): string
    {
        $tahun = date('Y');
        $pekerjaan = ($pekerjaan == null ? 'Guru Kelas' : str_replace("-", " ", $pekerjaan));
        $sub = ($sub == null ? 'SMP' : $sub);

        $db = db('recruitment', 'karyawan');
        $db->select('no_id,nama,sub,bidang_pekerjaan,kabupaten');

        if ($pekerjaan !== 'All') {
            $db->where('bidang_pekerjaan', $pekerjaan);
        }
        if ($sub !== 'All') {
            $db->where('sub', $sub);
        }

        $q = $db->get()->getResultArray();

        return view('root/recruitment/landing', ['judul' => 'Recruitment', 'data' => $q, 'tahun' => $tahun,  'sub' => ($sub == 'All' ? 'All' : $sub), 'pekerjaan' => ($pekerjaan == 'All' ? 'All' : str_replace(" ", "-", $pekerjaan))]);
    }
}
