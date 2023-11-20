<?php


function menu_anggota_kelas()
{
    $db = db('menu');

    $q = $db->where('section', session('section'))->where('role', session('role'))->whereIn('controller', ['tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas', 'duabelas'])->orderBy('no_urut', 'ASC')->get()->getResultArray();
    return $q;
}
function menu_kelas()
{
    foreach (menu_anggota_kelas() as $i) {
        if ((url(4) == '' ? 'tujuh' : url(4)) == $i['controller']) {
            return $i;
        }
    }
}

function anggota_kelas($tahun = null)
{
    $db = db((url(4) == '' ? 'tujuh' : url(4)), get_db((url(4) == '' ? 'tujuh' : url(4))));
    $q = $db->where('tahun', ($tahun == null ? date('Y') : $tahun))->get()->getResultArray();

    $dbu = db('santri', get_db('santri'));
    $data = [];
    foreach ($q as $i) {
        $x = $dbu->where('no_id', $i['no_id'])->get()->getRowArray();

        if ($q) {
            $data[] = ['profile' => $x, 'data' => $i];
        }
    }

    return $data;
}
