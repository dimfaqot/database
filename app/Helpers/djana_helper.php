<?php

function get_laporan($tahun, $bulan)
{
    $db = db('laporan', get_db('laporan'));

    $tahuns = [];
    $qr = $db->get()->getResultArray();
    foreach ($qr as $i) {

        if (!in_array(date('Y', $i['tgl_laporan']), $tahuns)) {
            $tahuns[] = date('Y', $i['tgl_laporan']);
        }
    }

    if ($tahun == 'All' && $bulan == 'All') {
        $q = $db->orderBy('tgl', 'ASC')->get()->getResultArray();
        $res = [];
        foreach ($q as $i) {
            $i['tgl'] = date('d/m/Y', $i['tgl']);
        }
    }

    if ($tahun == "All" && $bulan !== "All") {

        $q = $db->orderBy('tgl', 'ASC')->get()->getResultArray();
        $res = [];

        foreach ($q as $i) {
            $i['tgl'] = date('d/m/Y', $i['tgl']);
            if (date('m', $i['tgl_laporan']) == bulan($bulan)['angka']) {
                $res[] = $i;
            }
        }
    }

    if ($tahun !== "All" && $bulan == "All") {

        $q = $db->orderBy('tgl', 'ASC')->get()->getResultArray();
        $res = [];

        foreach ($q as $i) {
            $i['tgl'] = date('d/m/Y', $i['tgl']);
            if (date('Y', $i['tgl_laporan']) == $tahun) {
                $res[] = $i;
            }
        }
    }

    if ($tahun !== "All" && $bulan !== "All") {

        $q = $db->orderBy('tgl', 'ASC')->get()->getResultArray();
        $res = [];

        foreach ($q as $i) {
            $i['tgl'] = date('d/m/Y', $i['tgl']);

            if (date('Y', $i['tgl_laporan']) == $tahun) {
                if (date('m', $i['tgl_laporan']) == bulan($bulan)['angka']) {
                    $res[] = $i;
                }
            }
        }
    }


    $value = [];
    $totalKeluar = 0;
    $totalMasuk = 0;


    foreach ($res as $i) {
        $totalKeluar += $i['keluar'];
        $totalMasuk += $i['masuk'];
        $laba = ($i['masuk'] - $i['keluar']);
        $i['laba'] = 'Rp. ' . number_format($laba, 0, ",", ".");

        $i['keluar'] = 'Rp. ' . number_format($i['keluar'], 0, ",", ".");
        $i['masuk'] = 'Rp. ' . number_format($i['masuk'], 0, ",", ".");

        $value[] = $i;
    }

    $totalLaba = $totalMasuk - $totalKeluar;
    $data = [
        'status' => '200',
        'tahun' => $tahuns,
        'totalMasuk' => 'Rp. ' . number_format($totalMasuk, 0, ",", "."),
        'totalKeluar' => 'Rp. ' . number_format($totalKeluar, 0, ",", "."),
        'totalLaba' => 'Rp. ' . number_format($totalLaba, 0, ",", "."),
        'laba' => $totalLaba,
        'disable' => (date('m') == bulan($bulan)['angka'] && date('Y') == $tahun ? 'true' : 'false'),
        'data' => $value
    ];

    return $data;
}

function get_pesanan($tahun, $bulan)
{
    $db = db('pesanan', 'djana');
    $q = $db->orderBy('updated_at', 'DESC')->orderBy('barang', 'ASC')->get()->getResultArray();

    $data = [];
    $th = [];
    $masuk = 0;
    $keluar = 0;
    foreach ($q as $i) {
        $i['status'] = get_status($i);

        $i['icon'] = get_icon(get_status($i))['icon'];
        if ($i['jml_lunas'] > 0) {
            $keluar += $i['jml_lunas'];
        } else {
            $keluar += $i['jml_dp'];
        }
        $masuk += $i['jml'];


        if (!in_array(date('Y', $i['tgl_order']), $th)) {
            $th[] = date('Y', $i['tgl_order']);
        }
        if ($tahun == 'All' && $bulan == 'All') {
            $data[] = $i;
        } elseif ($tahun !== 'All' && $bulan !== 'All') {

            if (date('m', $i['tgl_order']) == $bulan && date('Y', $i['tgl_order']) == $tahun) {
                $data[] = $i;
            }
        } elseif ($tahun == 'All' && $bulan !== 'All') {
            if (date('m', $i['tgl_order']) == $bulan) {
                $data[] = $i;
            }
        } elseif ($tahun !== 'All' && $bulan == 'All') {
            if (date('Y', $i['tgl_order']) == $tahun) {
                $data[] = $i;
            }
        }
    }

    $res = [
        'data' => $data,
        'tahun' => $th,
        'keluar' => rupiah($keluar),
        'masuk' => rupiah($masuk),
        'saldo' => rupiah($masuk - $keluar),
        'belum' => $db->where('selesai', 0)->countAllResults()
    ];

    return $res;
}
function get_inventaris($tahun, $bulan)
{
    $db = db('pesanan', 'djana');
    $q = $db->where('is_inv', 1)->orderBy('tgl_order', 'DESC')->orderBy('barang', 'ASC')->get()->getResultArray();

    $data = [];
    $th = [];
    $keluar = 0;
    foreach ($q as $i) {
        $i['status'] = get_status($i);

        $i['icon'] = get_icon(get_status($i))['icon'];

        if (!in_array(date('Y', $i['tgl_order']), $th)) {
            $th[] = date('Y', $i['tgl_order']);
        }
        if ($tahun == 'All' && $bulan == 'All') {
            $data[] = $i;
            $keluar += $i['jml_lunas'];
        } elseif ($tahun !== 'All' && $bulan !== 'All') {

            if (date('m', $i['tgl_order']) == $bulan && date('Y', $i['tgl_order']) == $tahun) {
                $i['tgl_order'] = date('d/m/Y', $i['tgl_order']);
                $data[] = $i;
                $keluar += $i['jml_lunas'];
            }
        } elseif ($tahun == 'All' && $bulan !== 'All') {
            if (date('m', $i['tgl_order']) == $bulan) {
                $i['tgl_order'] = date('d/m/Y', $i['tgl_order']);
                $data[] = $i;
                $keluar += $i['jml_lunas'];
            }
        } elseif ($tahun !== 'All' && $bulan == 'All') {
            if (date('Y', $i['tgl_order']) == $tahun) {
                $i['tgl_order'] = date('d/m/Y', $i['tgl_order']);
                $data[] = $i;
                $keluar += $i['jml_lunas'];
            }
        }
    }

    $res = [
        'data' => $data,
        'tahun' => $th,
        'keluar' => rupiah($keluar),
    ];

    return $res;
}

function get_nota($tahun, $bulan, $no_nota = null)
{
    $db = db('nota', 'djana');
    if ($no_nota == null) {
        $th = [];
        $q = $db->groupBy('no_nota')->get()->getResultArray();

        $data = [];
        foreach ($q as $i) {
            $t = '20' . substr($i['no_nota'], 0, 2);
            $b = substr($i['no_nota'], 2, 2);

            if (!in_array($t, $th)) {
                $th[] = $t;
            }
            if ($tahun == 'All' && $bulan == 'All') {
                $data[] = $i;
            } elseif ($tahun !== 'All' && $bulan !== 'All') {
                if ($b == $bulan && $t == $tahun) {
                    $data[] = $i;
                }
            } elseif ($tahun == 'All' && $bulan !== 'All') {
                if ($b == $bulan) {
                    $data[] = $i;
                }
            } elseif ($tahun !== 'All' && $bulan == 'All') {
                if ($t == $tahun) {
                    $data[] = $i;
                }
            }
        }


        $res = [];
        foreach ($data as $i) {
            $q = $db->where('no_nota', $i['no_nota'])->orderBy('tgl', 'ASC')->orderBy('barang', 'ASC')->orderBy('jml', 'ASC')->get()->getResultArray();
            $total = 0;
            $detail = [];
            foreach ($q as $n) {
                $total += $n['jml'];
                $detail[] = ['id' => $n['id'], 'barang_id' => $n['barang_id'], 'barang' => $n['barang'], 'harga' => $n['jml'] / $n['qty'], 'qty' => $n['qty'], 'jml' => $n['jml']];
            }
            $profile = ['no_nota' => $i['no_nota'], 'tgl' => $i['tgl'], 'pembeli' => $i['pembeli'], 'teller' => $i['teller'], 'total' => $total];

            $res[] = ['profile' => $profile, 'detail' => $detail];
        }

        $value = ['tahun' => $th, 'data' => $res];
    } else {
        $data = $db->where('no_nota', $no_nota)->orderBy('tgl', 'ASC')->orderBy('barang', 'ASC')->orderBy('jml', 'ASC')->get()->getResultArray();
        $total = 0;
        $detail = [];
        foreach ($data as $n) {
            $total += $n['jml'];
            $detail[] = ['id' => $n['id'], 'barang_id' => $n['barang_id'], 'barang' => $n['barang'], 'harga' => $n['jml'] / $n['qty'], 'qty' => $n['qty'], 'jml' => $n['jml']];
        }
        $profile = $db->where('no_nota', $no_nota)->orderBy('tgl', 'ASC')->get()->getRowArray();
        $profile['total'] = $total;
        $value = ['profile' => $profile, 'detail' => $detail];
    }


    return $value;
}

function get_data_belum($order)
{
    if ($order == 'pesanan') {
        $db = db('pesanan', 'djana');
        $q = $db->where('selesai', 0)->orderBy('tgl_order', 'ASC')->orderBy('barang', 'ASC')->get()->getResultArray();
    }

    if ($order == 'tugasku') {
        $db = db('pesanan', 'djana');
        $d = $db->where('selesai', 0)->orderBy('tgl_order', 'ASC')->orderBy('barang', 'ASC')->get()->getResultArray();
        $q = [];
        foreach ($d as $i) {
            if ($i['penerima_order'] == session('username') || $i['pj_order'] == session('username') || $i['pj_dp'] == session('username') || $i['pj_lunas'] == session('username') || $i['penerima'] == session('username')) {
                $q[] = $i;
            }
        }
    }

    $data = [];
    foreach ($q as $i) {
        $i['status'] = get_status($i);
        $i['icon'] = get_icon(get_status($i))['icon'];
        $i['tgl_order'] = date('d/m/Y', $i['tgl_order']);
        $data[] = $i;
    }
    return $data;
}

function get_icon($status = null, $order = null)
{
    $res = [
        ['status' => 'Waiting', 'icon' => '<i class="fa-solid fa-spinner" ' . ($order == null ? 'style="color: #a20636;"' : '') . '></i>'],
        ['status' => 'Progress', 'icon' => '<i class="fa-solid fa-person-digging" ' . ($order == null ? 'style="color: #a22224;"' : '') . '></i>'],
        ['status' => 'Dp', 'icon' => '<i class="fa-solid fa-sack-xmark" ' . ($order == null ? 'style="color: #9d3610;"' : '') . '></i>'],
        ['status' => 'Penagihan', 'icon' => '<i class="fa-solid fa-hand-holding-dollar" ' . ($order == null ? 'style="color: #944600;"' : '') . '></i>'],
        ['status' => 'Konfirmasi Bendahara', 'icon' => '<i class="fa-solid fa-handshake-angle" ' . ($order == null ? 'style="color: #7a6200;"' : '') . '></i>'],
        ['status' => 'Selesai', 'icon' => '<i class="fa-solid fa-circle-check" ' . ($order == null ? 'style="color: #08873b;"' : '') . '></i>'],
    ];

    if ($status == null) {
        return $res;
    } else {
        foreach ($res as $i) {
            if ($i['status'] == $status) {
                return $i;
            }
        }
    }
}


function get_status($req)
{
    $status = 'Waiting';
    if ($req['pj_order'] !== '') {
        $status = 'Progress';
    }
    if ($req['pj_dp'] !== '' && $req['pj_lunas'] !== '') {
        $status = 'Penagihan';
    } elseif ($req['pj_dp'] !== '' && $req['pj_lunas'] == '') {
        $status = 'Dp';
    } elseif ($req['pj_dp'] == '' && $req['pj_lunas'] !== '') {
        $status = 'Penagihan';
    }
    if ($req['penerima'] !== '' && $req['jml'] > 0) {
        $status = 'Konfirmasi Bendahara';
    }

    if ($req['selesai'] == 1) {

        $status = 'Selesai';
    }


    return $status;
}


function get_nama($id)
{

    $res = [
        ['id' => 1, 'nama' => 'dimfaqot'],
        ['id' => 2, 'nama' => 'agus'],
        ['id' => 3, 'nama' => 'fajar'],
        ['id' => 4, 'nama' => 'ihsanuddin'],
        ['id' => 5, 'nama' => 'ibnu'],
        ['id' => 6, 'nama' => 'dimas'],
        ['id' => 7, 'nama' => 'habib'],
        ['id' => 8, 'nama' => 'owais'],
        ['id' => 9, 'nama' => 'alvin'],
        ['id' => 10, 'nama' => 'ismail'],
        ['id' => 11, 'nama' => 'hanif']
    ];


    foreach ($res as $i) {
        if ($id == $i['id']) {
            return $i['nama'];
        }
    }
}
// \+++++++++++++++++++++++++++++++++++++++++++++++++++++
function change_id_to_nama()
{

    $db = db('pesanan', 'djana');

    $q = $db->get()->getResultArray();
    foreach ($q as $i) {
        $i['penerima_order'] = get_nama($i['penerima_order']);
        $i['pj_order'] = get_nama($i['pj_order']);
        $i['pj_dp'] = get_nama($i['pj_dp']);
        $i['pj_lunas'] = get_nama($i['pj_lunas']);
        $i['penerima'] = get_nama($i['penerima']);
        $db->where('id', $i['id']);
        $db->update($i);
    }
}

function is_inv()
{
    $db = db('pesanan', 'djana');
    $q = $db->get()->getResultArray();

    foreach ($q as $i) {
        $exp = explode(" ", strtolower($i['catatan_order']));

        if (in_array('inv', $exp)) {
            $i['is_inv'] = 1;
        }
        if (in_array('inventaris', $exp)) {
            $i['is_inv'] = 1;
        }

        if ($i['is_inv'] == 1) {
            $db->where('id', $i['id']);

            $db->update($i);
        }
    }
}
function get_kondisi_inv()
{
    $db = db('pesanan', 'djana');
    $q = $db->where('is_inv', 1)->get()->getResultArray();

    foreach ($q as $i) {
        $d = db('inv', 'djana');
        $x = $d->where('barang_id', $i['id'])->get()->getRowArray();

        $kondisi = 'Baik';
        if ($x) {
            $kondisi = $x['kondisi'];
        }

        $i['kondisi'] = $kondisi;
        $db->where('id', $i['id']);
        $db->update($i);
    }
}

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

function get_users_djana()
{
    $db = db('user', 'data');
    $q = $db->where('section', 'Djana')->get()->getResultArray();
    $res = ['dimfaqot'];
    foreach ($q as $i) {
        $res[] = $i['username'];
    }

    return $res;
}

function get_all_members_djana()
{
    $db = db('pesanan', 'djana');
    $q = $db->get()->getResultArray();

    $members = [];

    foreach ($q as $i) {
        if (!in_array($i['penerima_order'], $members)) {
            if ($i['penerima_order'] !== '0') {
                $members[] = $i['penerima_order'];
            }
        }
        if (!in_array($i['pj_order'], $members)) {
            if ($i['pj_order'] !== '0') {
                $members[] = $i['pj_order'];
            }
        }
        if (!in_array($i['pj_dp'], $members)) {
            if ($i['pj_dp'] !== '0') {
                $members[] = $i['pj_dp'];
            }
        }
        if (!in_array($i['pj_lunas'], $members)) {
            if ($i['pj_lunas'] !== '0') {
                $members[] = $i['pj_lunas'];
            }
        }
        if (!in_array($i['penerima'], $members)) {
            if ($i['penerima'] !== '0') {
                $members[] = $i['penerima'];
            }
        }
    }

    return $members;
}

function check_tgl($data, $val)
{
    $res = '-';
    if ($data == 0) {
        if ($val == '-') {
            $res = 0;
        } else {
            $exp = explode("/", $val);
            $res = strtotime($exp[2] . '-' . $exp[1] . '-' . $exp[0]);
        }
    } else {
        $res = strtotime($val);
    }

    return $res;
}



function get_tugasku($tahun, $bulan, $order)
{

    $db = db('pesanan', 'djana');
    $q = $db->orderBy('tgl_order', 'DESC')->orderBy('barang', 'ASC')->get()->getResultArray();

    if ($tahun == 'All' && $bulan == 'All') {
        $q = $db->orderBy('selesai', 'ASC')->orderBy('tgl_order', 'DESC')->get()->getResultArray();
        $res = [];
        foreach ($q as $i) {
            $res[] = $i;
        }
    }

    if ($tahun == "All" && $bulan !== "All") {

        $q = $db->orderBy('selesai', 'ASC')->orderBy('tgl_order', 'DESC')->get()->getResultArray();
        $res = [];

        foreach ($q as $i) {

            $bl = date("m", $i['tgl_order']);

            if ($bl == bulan($bulan)['angka']) {
                $res[] = $i;
            }
        }
    }

    if ($tahun !== "All" && $bulan == "All") {

        $q = $db->orderBy('selesai', 'ASC')->orderBy('tgl_order', 'DESC')->get()->getResultArray();
        $res = [];

        foreach ($q as $i) {
            $th = date("Y", $i['tgl_order']);
            if ($th == $tahun) {
                $res[] = $i;
            }
        }
    }

    if ($tahun !== "All" && $bulan !== "All") {

        $q = $db->orderBy('selesai', 'ASC')->orderBy('tgl_order', 'DESC')->get()->getResultArray();
        $res = [];

        foreach ($q as $i) {
            $bl = date('m', $i['tgl_order']);
            $th = date('Y', $i['tgl_order']);

            if ($th == $tahun) {
                if ($bl == bulan($bulan)['angka']) {
                    $res[] = $i;
                }
            }
        }
    }


    $value = [];




    foreach ($res as $i) {
        $i['status'] = get_status($i);

        $i['icon'] = get_icon(get_status($i))['icon'];

        $order = str_replace("-", " ", $order);
        if ($order == 'Penerima Pesanan' && $i['penerima_order'] == session('username')) {
            $value[] = $i;
        }
        if ($order == 'Pj Order' && $i['pj_order'] == session('username')) {
            $value[] = $i;
        }
        if ($order == 'Pj Dp' && $i['pj_dp'] == session('username')) {
            $value[] = $i;
        }
        if ($order == 'Pj Lunas' && $i['pj_lunas'] == session('username')) {
            $value[] = $i;
        }
        if ($order == 'Penerima Uang Masuk' && $i['penerima'] == session('username')) {
            $value[] = $i;
        }
        if ($order == 'All') {
            if ($i['penerima'] == session('username') || $i['pj_lunas'] == session('username') || $i['pj_dp'] == session('username') || $i['pj_order'] == session('username') || $i['penerima_order'] == session('username')) {
                $value[] = $i;
            }
        }
    }

    $tahun = [];

    foreach ($value as $i) {
        if (!in_array(date('Y', $i['tgl_order']), $tahun)) {
            $tahun[] = date('Y', $i['tgl_order']);
        }
    }

    $q = $db->where('selesai', 0)->get()->getResultArray();

    $jmlBelum = 0;

    foreach ($q as $i) {
        if ($i['penerima_order'] == session('username') || $i['pj_order'] == session('username') || $i['pj_dp'] == session('username') || $i['pj_lunas'] == session('username') || $i['penerima'] == session('username')) {
            $jmlBelum++;
        }
    }


    $data = [
        'data' => $value,
        'belum' => $jmlBelum,
        'tahun' => $tahun
    ];

    return $data;
}


function get_saldo_bulan_lalu($tahun, $bulan)
{
    $text = '';
    $th = $tahun;
    $bl = $bulan;



    if ($tahun == 'All' && $bulan == 'All') {
        $text = 'Saldo Keseluruhan';
    }
    if ($tahun !== 'All' && $bulan !== 'All') {

        $bl = $bulan - 1;
        if ($bulan == 1) {
            $th = $tahun - 1;
            $bl = 12;
        }
        $bl = (strlen($bl) == 1 ? '0' . $bl : $bl);
        $text = 'Saldo Bulan ' . bulan($bl)['bulan'];
    }

    if ($tahun !== 'All' && $bulan == 'All') {
        $text = 'Saldo Tahun ' . $tahun;
    }

    if ($tahun == 'All' && $bulan !== 'All') {

        $text = 'Saldo Seluruh Bulan ' . bulan($bulan)['bulan'];
    }

    $res = ['text' => $text, 'saldo' => get_laporan($th, $bl)['laba']];
    return $res;
}

function get_statistik($tahun, $bulan, $order)
{
    $db = db('pesanan', 'djana');

    $value = [];




    foreach (get_all_members_djana() as $u) {
        // 1
        if ($order == 'All' && $tahun == 'All' && $bulan == 'All') {
            $nama = upper_first($u);
            $penerima_order = $db->where('penerima_order', $u)->where('selesai', 1)->countAllResults();
            $pj_order = $db->where('pj_order', $u)->where('selesai', 1)->countAllResults();
            $pj_dp = $db->where('pj_dp', $u)->where('selesai', 1)->countAllResults();
            $pj_lunas = $db->where('pj_lunas', $u)->where('selesai', 1)->countAllResults();
            $penerima = $db->where('penerima', $u)->where('selesai', 1)->countAllResults();

            $value[] = ['y' => $penerima_order + $pj_order + $pj_dp + $pj_lunas + $penerima, 'label' => $nama];
        }

        // 2
        if ($order == 'All' && $tahun == 'All' && $bulan !== 'All') {
            $nama = upper_first($u);

            $q = $db->where('selesai', 1)->get()->getResultArray();

            $penerima_order = 0;
            $pj_order = 0;
            $pj_dp = 0;
            $pj_lunas = 0;
            $penerima = 0;
            foreach ($q as $p) {
                if ($bulan == date('m', $p['tgl_order'])) {
                    if ($p['penerima_order'] == $u) {
                        $penerima_order++;
                    }
                    if ($p['pj_order'] == $u) {
                        $pj_order++;
                    }
                    if ($p['pj_lunas'] == $u) {
                        $pj_lunas++;
                    }
                    if ($p['penerima'] == $u) {
                        $penerima++;
                    }
                }
            }

            $value[] = ['y' => $penerima_order + $pj_order + $pj_dp + $pj_lunas + $penerima, 'label' => $nama];
        }

        // 3
        if ($order == 'All' && $tahun !== 'All' && $bulan == 'All') {
            $nama = upper_first($u);

            $q = $db->where('selesai', 1)->get()->getResultArray();

            $penerima_order = 0;
            $pj_order = 0;
            $pj_dp = 0;
            $pj_lunas = 0;
            $penerima = 0;
            foreach ($q as $p) {
                if ($tahun == date('Y', $p['tgl_order'])) {
                    if ($p['penerima_order'] == $u) {
                        $penerima_order++;
                    }
                    if ($p['pj_order'] == $u) {
                        $pj_order++;
                    }
                    if ($p['pj_lunas'] == $u) {
                        $pj_lunas++;
                    }
                    if ($p['penerima'] == $u) {
                        $penerima++;
                    }
                }
            }

            $value[] = ['y' => $penerima_order + $pj_order + $pj_dp + $pj_lunas + $penerima, 'label' => $nama];
        }

        // 4
        if ($order !== 'All' && $tahun == 'All' && $bulan == 'All') {
            $nama = upper_first($u);

            $q = $db->where($order, $u)->where('selesai', 1)->countAllResults();

            $value[] = ['y' => $q, 'label' => $nama];
        }

        // 5
        if ($order == 'All' && $tahun !== 'All' && $bulan !== 'All') {
            $nama = upper_first($u);

            $q = $db->where('selesai', 1)->get()->getResultArray();

            $penerima_order = 0;
            $pj_order = 0;
            $pj_dp = 0;
            $pj_lunas = 0;
            $penerima = 0;
            foreach ($q as $p) {
                if ($bulan == date('m', $p['tgl_order']) && $tahun == date('Y', $p['tgl_order'])) {
                    if ($p['penerima_order'] == $u) {
                        $penerima_order++;
                    }
                    if ($p['pj_order'] == $u) {
                        $pj_order++;
                    }
                    if ($p['pj_lunas'] == $u) {
                        $pj_lunas++;
                    }
                    if ($p['penerima'] == $u) {
                        $penerima++;
                    }
                }
            }
            $value[] = ['y' => $penerima_order + $pj_order + $pj_dp + $pj_lunas + $penerima, 'label' => $nama];
        }

        // 6
        if ($order !== 'All' && $tahun == 'All' && $bulan !== 'All') {
            $nama = upper_first($u);

            $q = $db->where($order, $u)->where('selesai', 1)->get()->getResultArray();

            $val = 0;
            foreach ($q as $p) {
                if ($bulan == date('m', $p['tgl_order'])) {
                    $val++;
                }
            }

            $value[] = ['y' => $val, 'label' => $nama];
        }

        // 7
        if ($order !== 'All' && $tahun !== 'All' && $bulan == 'All') {
            $nama = upper_first($u);

            $q = $db->where($order, $u)->where('selesai', 1)->get()->getResultArray();

            $val = 0;
            foreach ($q as $p) {
                if ($tahun == date('Y', $p['tgl_order'])) {
                    $val++;
                }
            }

            $value[] = ['y' => $val, 'label' => $nama];
        }

        // 8
        if ($order !== 'All' && $tahun !== 'All' && $bulan !== 'All') {
            $nama = upper_first($u);

            $q = $db->where($order, $u)->where('selesai', 1)->get()->getResultArray();

            $val = 0;
            foreach ($q as $p) {
                if ($bulan == date('m', $p['tgl_order']) && $tahun == date('Y', $p['tgl_order'])) {
                    $val++;
                }
            }

            $value[] = ['y' => $val, 'label' => $nama];
        }
    }

    return $value;
}

function last_no_nota($time)
{
    $y = substr(date('Y', $time), 2);
    $m = date('m', $time);
    $d = date('d', $time);
    $no = '001';

    $no_nota = $y . $m . $d . $no;

    $db = db('nota', 'djana');
    $q = $db->where('no_nota', $no_nota)->get()->getRowArray();

    if ($q) {
        for ($i = 1; $i < 100; $i++) {
            $n = (strlen($i == '1' ? '00' . $i : (strlen($i == 2 ? '0' . $i : $i))));
            $no_nota = $y . $m . $d . $n;
            $q = $db->where('no_nota', $no_nota)->get()->getRowArray();
            if (!$q) {
                return $no_nota;
            }
        }
    }
    return $no_nota;
}
