<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

function user_login()
{

    $db = db(strtolower(session('section')), get_db(strtolower(session('section'))));
    $q = $db->where('no_id', session('no_id'))->get()->getRowArray();
    if (!$q) {
        gagal(base_url('home'), 'Data tidak ditemukan.');
    }

    return $q;
}
function db($tabel, $db = null)
{
    if ($db == null || $db == 'data') {
        $db = \Config\Database::connect();
    } else {
        $db = \Config\Database::connect(strtolower(str_replace(" ", "_", $db)));
    }
    $db = $db->table($tabel);

    return $db;
}

function get_db($tabel = null)
{
    $db = db('settings');
    $q = $db->get()->getRowArray();

    if ($tabel == null) {
        return $q['db'];
    } else {
        $exp = explode(",", $q['db']);

        foreach ($exp as $i) {
            $tables = get_tables($i);
            if (in_array($tabel, $tables)) {
                return $i;
            }
        }
    }
}

function get_cols($tabel, $db = null)
{

    if ($db == null || $db == 'data') {
        $db = \Config\Database::connect();
    } else {
        $db = \Config\Database::connect(strtolower(str_replace(" ", "_", $db)));
    }
    return $db->getFieldNames($tabel);
}

function get_tables($db = '')
{

    if ($db == '' || $db == 'data') {
        $db = \Config\Database::connect();
    } else {
        $db = \Config\Database::connect($db);
    }

    $q = $db->listTables();
    return $q;
}

function get_default_cetak($db, $tabel = null)
{
    $res = [
        ['db' => 'data', 'tabel' => 'user', 'col' => 'nama', 'id' => 'id'],
        ['db' => 'ekstra', 'tabel' => 'nilai', 'col' => 'nama', 'id' => 'id'],
        ['db' => 'indonesia', 'tabel' => 'kabupaten', 'col' => 'name', 'id' => 'id'],
        ['db' => 'karyawan', 'tabel' => 'karyawan', 'col' => 'nama', 'id' => 'no_id'],
        ['db' => 'karyawan', 'tabel' => 'recruitment', 'col' => 'nama', 'id' => 'no_id'],
        ['db' => 'karyawan', 'tabel' => 'sk', 'col' => 'nama', 'id' => 'id'],
        ['db' => 'news', 'tabel' => 'artikel', 'col' => 'penulis', 'id' => 'id'],
        ['db' => 'pemilu', 'tabel' => 'calon', 'col' => 'partai', 'id' => 'id'],
        ['db' => 'santri', 'tabel' => 'santri', 'col' => 'nama', 'id' => 'no_id'],
        ['db' => 'santri', 'tabel' => 'ppdb', 'col' => 'nama', 'id' => 'no_id'],
        ['db' => 'sertifikat', 'tabel' => 'piagam', 'col' => 'nama', 'id' => 'id'],
        ['db' => 'sertifikat', 'tabel' => 'pilangsari', 'col' => 'nama', 'id' => 'no'],
        ['db' => 'walisongo_api', 'tabel' => 'karyawan', 'col' => 'nama', 'id' => 'id']
    ];

    if ($tabel == null) {
        foreach ($res as $i) {
            if ($i['db'] == $db) {
                return $i;
            }
        }
    } else {
        foreach ($res as $i) {
            if ($i['db'] == $db && $i['tabel'] == $tabel) {
                return $i;
            }
        }
    }
}

function is_sertifikat($order = null)
{
    $db = db('settings');

    $q = $db->get()->getRowArray();

    if ($order == null) {
        return $q['is_sertifikat'];
    } else {
        $exp = explode(",", $q['is_sertifikat']);
        if (in_array($order, $exp)) {
            return 'yes';
        } else {
            return 'no';
        }
    }
}
function settings($order = null)
{
    $db = db('settings');

    $q = $db->get()->getRowArray();

    if ($order == null) {
        return $q;
    } else {
        return $q[$order];
    }
}

function key_jwt()
{
    $db = db('settings');

    $q = $db->get()->getRowArray();
    return $q['key_jwt'];
}

function encode_jwt($data)
{

    $jwt = JWT::encode($data, key_jwt(), 'HS256');

    return $jwt;
}

function decode_jwt($encode_jwt)
{
    try {

        $decoded = JWT::decode($encode_jwt, new Key(key_jwt(), 'HS256'));
        $arr = (array)$decoded;

        return $arr;
    } catch (\Exception $e) { // Also tried JwtException
        $data = [
            'status' => '400',
            'message' => $e->getMessage()
        ];

        echo json_encode($data);
        die;
    }
}

function remove_char($string)
{
    // return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

    return preg_replace('/[^\da-z ]/i', '', $string); //except space
}

function clear($text)
{
    $text = trim($text);
    $text = htmlspecialchars($text);
    return $text;
}



function upper_first($text)
{
    $text = clear($text);
    $exp = explode(" ", $text);

    $val = [];
    foreach ($exp as $i) {
        $lower = strtolower($i);
        $val[] = ucfirst($lower);
    }

    return implode(" ", $val);
}

function sukses($url, $pesan)
{
    session()->setFlashdata('sukses', $pesan);
    header("Location: " . $url);
    die;
}

function gagal($url, $pesan)
{
    session()->setFlashdata('gagal', "Gagal!. " . $pesan);
    header("Location: " . $url);
    die;
}

function sukses_js($pesan, $data = null, $data2 = null, $data3 = null, $data4 = null)
{
    $data = [
        'status' => '200',
        'message' => $pesan,
        'data' => $data,
        'data2' => $data2,
        'data3' => $data3,
        'data4' => $data4
    ];

    echo json_encode($data);
    die;
}

function gagal_js($pesan)
{
    $data = [
        'status' => '400',
        'message' => "Gagal!. " . $pesan
    ];

    echo json_encode($data);
    die;
}

function menus()
{

    $db = db('menu');

    $q1[] = ['id' => 0, 'no_urut' => 0, 'section' => session('section'), 'role' => session('role'), 'menu' => 'Home', 'tabel' => 'user', 'controller' => 'home', 'icon' => "fa-solid fa-earth-asia", 'url' => 'home', 'actived' => 0];
    $q2 = $db->where('section', session('section'))->where('role', session('role'))->orderBy('no_urut', 'ASC')->get()->getResultArray();

    $res = array_merge($q1, $q2);

    return $res;
}

function menu($req = null)
{
    if ($req == null) {
        foreach (menus() as $i) {
            if ($i['controller'] == url()) {
                return $i;
            }
        }
    } else {
        foreach (menus() as $i) {
            if ($i['controller'] == $req) {
                return $i;
            }
        }
    }
}

function check_role()
{
    $db = db('menu');

    $q = $db->where('section', session('section'))->where('role', session('role'))->where('controller', url())->get()->getRowArray();

    if (!$q) {
        gagal(base_url('home'), 'You are not allowed.');
    }
}

function menu_landing()
{

    $db = \Config\Database::connect();
    $db = $db->table('menu');
    $q = $db->where('section', 'Landing')->where('role', 'Member')->orderBy('no_urut', 'ASC')->get()->getResultArray();

    return $q;
}

function url($req = 3)
{
    $url = service('uri');
    $res = $url->getPath();

    $req = $req - 1;
    $exp = explode("/", $res);


    if (array_key_exists($req, $exp)) {
        return $exp[$req];
    }

    return '';
}

function sosmed($order = null)
{
    $db = db('sosmed');
    $q = $db->orderBy('urutan', 'ASC')->get()->getResultArray();

    $res = [];

    foreach ($q as $k => $i) {
        $color = 'btn_main_inactive';
        if ($k % 2 == 0) {
            $color = 'btn_main';
        }
        $res[] = "<a target='_blank' href='" . $i['url'] . "' style='font-size: small;text-decoration:none; padding:6px 8px 6px 8px;' type='button' class='mb-1 " . $color . "'><i class='" . $i['icon'] . "'></i> " . $i['text'] . "</a></button>";
    }


    if ($order == null) {
        return $res;
    } else {
        return $q;
    }
}


function options($req = 'Role')
{

    $db = db('options');

    $q = $db->where('kategori', $req)->orderBy(($req == 'Pekerjaan' ? 'value' : 'no_urut'), 'ASC')->get()->getResultArray();
    return $q;
}
function default_password()
{
    $db = db('settings');

    $q = $db->get()->getRowArray();
    return password_hash($q['default_password'], PASSWORD_DEFAULT);
}

function info_pemilu()
{
    $db = db('settings');

    $q = $db->get()->getRowArray();
    return $q['hasil_pemilu'];
}


function bulan($req = null)
{
    $bulan = [
        ['romawi' => 'I', 'bulan' => 'Januari', 'angka' => '01', 'satuan' => 1],
        ['romawi' => 'II', 'bulan' => 'Februari', 'angka' => '02', 'satuan' => 2],
        ['romawi' => 'III', 'bulan' => 'Maret', 'angka' => '03', 'satuan' => 3],
        ['romawi' => 'IV', 'bulan' => 'April', 'angka' => '04', 'satuan' => 4],
        ['romawi' => 'V', 'bulan' => 'Mei', 'angka' => '05', 'satuan' => 5],
        ['romawi' => 'VI', 'bulan' => 'Juni', 'angka' => '06', 'satuan' => 6],
        ['romawi' => 'VII', 'bulan' => 'Juli', 'angka' => '07', 'satuan' => 7],
        ['romawi' => 'VIII', 'bulan' => 'Agustus', 'angka' => '08', 'satuan' => 8],
        ['romawi' => 'IX', 'bulan' => 'September', 'angka' => '09', 'satuan' => 9],
        ['romawi' => 'X', 'bulan' => 'Oktober', 'angka' => '10', 'satuan' => 10],
        ['romawi' => 'XI', 'bulan' => 'November', 'angka' => '11', 'satuan' => 11],
        ['romawi' => 'XII', 'bulan' => 'Desember', 'angka' => '12', 'satuan' => 12]
    ];

    $res = $bulan;
    foreach ($bulan as $i) {
        if ($i['bulan'] == $req) {
            $res = $i;
        } elseif ($i['angka'] == $req) {
            $res = $i;
        } elseif ($i['satuan'] == $req) {
            $res = $i;
        } elseif ($i['romawi'] == $req) {
            $res = $i;
        }
    }
    return $res;
}

function ttl($req)
{
    $tgl = date('d-m-Y', $req['tgl_lahir']);
    $exp = explode("-", $tgl);
    $ttl = $req['kota_lahir'] . ', ' . $exp[0] . ' ' . bulan($exp[1])['bulan'] . ' ' . $exp[2];

    if ($req['kota_lahir'] == '') {
        $ttl = $exp[0] . ' ' . bulan($exp[1])['bulan'] . ' ' . $exp[2];
    }

    return $ttl;
}

function sub($order = null)
{
    $res = [
        ['singkatan' => 'KB', 'kode' => "1", 'lengkap' => "KB Walisongo"],
        ['singkatan' => 'TK', 'kode' => "2", 'lengkap' => "TK Walisongo Karangmalang"],
        ['singkatan' => 'SDI', 'kode' => "3", 'lengkap' => "SD Integral Walisongo"],
        ['singkatan' => 'SMP', 'kode' => "4", 'lengkap' => "SMP Walisongo Karangmalang"],
        ['singkatan' => 'SMA', 'kode' => "5", 'lengkap' => "SMA Walisongo Karangmalang"],
        ['singkatan' => 'MMW', 'kode' => "6", 'lengkap' => "Madrasah Mu'allimin Walisongo Sragen"],
        ['singkatan' => 'TPQ', 'kode' => "7", 'lengkap' => "TPQ Walisongo Sragen"],
        ['singkatan' => 'Pondok', 'kode' => "8", 'lengkap' => "Pondok Pesantren Walisongo Walisongo Sragen"],
        ['singkatan' => 'Ekstra', 'kode' => "9", 'lengkap' => "Ekstrakurikuler"],
        ['singkatan' => 'Almuntaha', 'kode' => "9", 'lengkap' => "CV Al Muntaha Record"],
        ['singkatan' => 'Yayasan', 'kode' => "0", "lengkap" => 'Yayasan Pondok Pesantren Walisongo Sragen']
    ];

    if ($order == null) {
        return $res;
    } else {
        foreach ($res as $i) {
            if (in_array($order, $i)) {
                return $i;
            }
        }
    }
}

function umur($tgl_lahir)
{

    if ($tgl_lahir == '' || $tgl_lahir == 0 || !$tgl_lahir) {
        return '-';
    } else {
        $tgl_lahir = date('Y-m-d', $tgl_lahir);
        $now = new \DateTime('NOW');
        $diff = $now->diff(new \DateTime($tgl_lahir));
        return $diff->y;
    }
}


// Karyawan
function tahun_sk($tahun)
{
    if ($tahun == null) {
        $res = ['rapat' => '06 Juli ' . date('Y'), 'penetapan' => '07 Juli ' . date('Y'), 'ketua_ypp' => 'M. Afif Al Ayyubi, S.Ag', 'kop' => '2021.jpg'];
    } else {
        $res = $tahun;
    }
    return $res;
}

function last_no_id_kar($tahun_masuk, $sub)
{
    $db = db('karyawan', 'karyawan');

    $q = $db->where('sub', $sub)->where('tahun_masuk', $tahun_masuk)->orderBy('no_id', 'DESC')->get()->getRowArray();
    $th = substr($tahun_masuk, -2);
    $sb = sub($sub)['kode'];
    $no_id = '900' . $th . $sb . '001';

    if ($q) {
        $last = substr($q['no_id'], -3) + 1;

        if (strlen($last) == 1) {
            $no_id = '900' . $th . $sb . '00' . $last;
        }
        if (strlen($last) == 2) {
            $no_id = '900' . $th . $sb . '0' . $last;
        }
        if (strlen($last) == 3) {
            $no_id = $tahun_masuk . $sb . $last;
        }
    }

    for ($i = 0; $i < 90; $i++) {
        $isExist = $db->where('no_id', $no_id)->get()->getRowArray();

        if (!$isExist) {
            break;
        } else {
            $no_id++;
        }
    }
    return $no_id;
}
function last_no_id_rec($tahun_masuk, $sub)
{
    $db = db('recruitment', 'karyawan');

    $q = $db->where('sub', $sub)->where('tahun_masuk', $tahun_masuk)->orderBy('no_id', 'DESC')->get()->getRowArray();

    $sb = sub($sub)['kode'];
    $no_id = $tahun_masuk . $sb . '0001';

    if ($q) {
        $last = substr($q['no_id'], -4) + 1;

        if (strlen($last) == 1) {
            $no_id = $tahun_masuk . $sb . '000' . $last;
        }
        if (strlen($last) == 2) {
            $no_id = $tahun_masuk . $sb . '00' . $last;
        }
        if (strlen($last) == 3) {
            $no_id = $tahun_masuk . $sb . '0' . $last;
        }
        if (strlen($last) == 4) {
            $no_id = $tahun_masuk . $sb . $last;
        }
    }

    for ($i = 0; $i < 90; $i++) {
        $isExist = $db->where('no_id', $no_id)->get()->getRowArray();

        if (!$isExist) {
            break;
        } else {
            $no_id++;
        }
    }
    return $no_id;
}

function last_no_id_santri($tahun_masuk, $sub)
{
    $db = db('santri', get_db(menu()['tabel']));
    $q = $db->where('tahun_masuk', $tahun_masuk)->where('sub', $sub)->orderBy('no_id', 'DESC')->get()->getRowArray();
    $sb = sub($sub)['kode'];
    $no_id = substr($tahun_masuk, -2)  . $sb . '001';

    if ($q) {
        $last = substr($q['no_id'], -3) + 1;

        if (strlen($last) == 1) {
            $no_id = substr($tahun_masuk, -2) . $sb . '00' . $last;
        }
        if (strlen($last) == 2) {
            $no_id = substr($tahun_masuk, -2) . $sb . '0' . $last;
        }
        if (strlen($last) == 3) {
            $no_id = substr($tahun_masuk, -2) . $sb . $last;
        }
    }

    for ($i = 0; $i < 90; $i++) {
        $isExist = $db->where('no_id', $no_id)->get()->getRowArray();

        if (!$isExist) {
            break;
        } else {
            $no_id++;
        }
    }
    return $no_id;
}
function last_no_id_ppdb($tahun_masuk, $sub)
{
    $db = db('ppdb', get_db(menu()['tabel']));
    $q = $db->where('tahun_masuk', $tahun_masuk)->where('sub', $sub)->orderBy('no_id', 'DESC')->get()->getRowArray();
    $sb = sub($sub)['kode'];
    $no_id = substr($tahun_masuk, -2)  . $sb . '001';

    if ($q) {
        $last = substr($q['no_id'], -3) + 1;

        if (strlen($last) == 1) {
            $no_id = substr($tahun_masuk, -2) . $sb . '00' . $last;
        }
        if (strlen($last) == 2) {
            $no_id = substr($tahun_masuk, -2) . $sb . '0' . $last;
        }
        if (strlen($last) == 3) {
            $no_id = substr($tahun_masuk, -2) . $sb . $last;
        }
    }

    for ($i = 0; $i < 90; $i++) {
        $isExist = $db->where('no_id', $no_id)->get()->getRowArray();

        if (!$isExist) {
            break;
        } else {
            $no_id++;
        }
    }
    return $no_id;
}

function last_no_piagam($time)
{
    $db = db('piagam', get_db('piagam'));

    $tahun = date('Y', $time);

    $no = '0001';
    $romawi = bulan(date('m', $time))['romawi'];

    $q = $db->where('tahun', $tahun)->orderBy('created_at', 'DESC')->get()->getRowArray();

    if ($q) {
        $exp = explode("/", $q['no_surat']);
        $no_urut = $exp[0] + 1;

        if (strlen($no_urut) == 1) {
            $no = '000' . $no_urut;
        }
        if (strlen($no_urut) == 2) {
            $no = '00' . $no_urut;
        }
        if (strlen($no_urut) == 3) {
            $no = '0' . $no_urut;
        }
        if (strlen($no_urut) == 4) {
            $no = $no_urut;
        }
    }

    return $no . '/SR/YPP-WS/PG/' . $romawi . '/' . date('Y', $time);
}


function last_no_ekstra($time, $ekstra, $tahun)
{

    $db = db('nilai', 'ekstra');

    $q = $db->where('singkatan', $ekstra)->orderBy('tgl', 'DESC')->get()->getResultArray();

    $no = '001/' . $ekstra . '/' . bulan(date('m', $time))['romawi'] . '/' . date('Y', $time);

    if ($q) {
        $kode = '';

        foreach ($q as $i) {
            if (date('Y', $i['tgl']) == $tahun) {
                $kode = $i['kode'];
            }
        }

        $exp = explode("/", $kode);
        $next = $exp[0] + 1;

        if (strlen($next) == 1) {
            $next = '00' . $next;
        }
        if (strlen($next) == 2) {
            $next = '0' . $next;
        }

        $no = $next . '/' . $ekstra . '/' . bulan(date('m', $time))['romawi'] . '/' . date('Y', $time);
    }

    return $no;
}


// sk
function last_sk($penetapan)
{
    $exp = explode(" ", $penetapan);
    $bulan = bulan($exp[1])['romawi'];
    $ypp = 'LPI-SW';
    if ($exp[2] > 2013) {
        $ypp = 'YPP-WS';
    }

    $db = db('sk', 'karyawan');

    for ($i = 1; $i < 100; $i++) {
        $no = '00' . $i++;
        if (strlen($i++) == 2) {
            $no = '0' . $i++;
        }
        if (strlen($i++) == 3) {
            $no = $i++;
        }
        $no_sk = $no . '/SK/' . $ypp . '/A/' . $bulan . '/' . $exp[2];

        $q = $db->where('no_sk', $no_sk)->get()->getRowArray();

        if (!$q) {
            return $no_sk;
        }
    }
}


function pendidikan_sk($req)
{
    if ($req['jurusan_s3'] !== '') {
        return $req['jurusan_s3'];
    } elseif ($req['jurusan_s2'] !== '') {
        return $req['jurusan_s2'];
    } elseif ($req['jurusan_s1'] !== '') {
        return $req['jurusan_s1'];
    } elseif ($req['pendidikan_terakhir'] !== '') {
        return $req['pendidikan_terakhir'];
    } else {
        return '';
    }
}

function nama_gelar($req)
{
    $nama = $req['nama'];

    if ($req['gelar_s3'] !== '') {
        $nama = $req['gelar_s3'] . '. ' . $req['nama'];
        if ($req['gelar_s2'] !== '' && $req['gelar_s1'] !== '') {
            $nama .= ", " . $req['gelar_s1'] . ', ' . $req['gelar_s2'] . '.';
        } elseif ($req['gelar_s2'] == '' && $req['gelar_s1'] !== '') {
            $nama = $req['nama'] . ", " . $req['gelar_s1'] . '.';
        } elseif ($req['gelar_s2'] !== '' && $req['gelar_s1'] == '') {
            $nama = $req['nama'] . ", " . $req['gelar_s2'] . '.';
        }
    } elseif ($req['gelar_s2'] !== '') {
        $nama = $req['nama'] . ', ' . $req['gelar_s2'] . '.';
        if ($req['gelar_s1'] !== '') {
            $nama = $req['nama'] . ", " . $req['gelar_s1'] . ', ' . $req['gelar_s2'] . '.';
        }
    } elseif ($req['gelar_s1'] !== '') {
        $nama = $req['nama'] . ', ' . $req['gelar_s1'] . '.';
    }

    return $nama;
}

function alamat_lengkap($req)
{
    $alamat = '';
    if ($req['alamat'] !== '') {
        $alamat .= $req['alamat'];
    }
    if ($req['kelurahan'] !== '') {
        $alamat .= ' Kel. ' . $req['kelurahan'];
    }
    if ($req['kecamatan'] !== '') {
        $alamat .= ' Kec. ' . $req['kecamatan'];
    }
    if ($req['kabupaten'] !== '') {
        $alamat .= ' Kab. ' . $req['kabupaten'];
    }
    if ($req['provinsi'] !== '') {
        $alamat .= ' Prov. ' . $req['provinsi'];
    }
    if ($req['kode_pos'] !== '') {
        $alamat .= ' ' . $req['kode_pos'];
    }
    return $alamat;
}

function get_ttd($nama)
{
    $ttd = '';

    $exp = explode(" ", str_replace(".", " ", str_replace(",", " ", strtolower($nama))));

    foreach ($exp as $i) {
        if (file_exists('berkas/ttd/' . $i . '.png')) {
            $ttd = $i . '.png';
            break;
        }
    }

    return strtolower($ttd);
}

function ck_editor()
{
    $res = ['Catatan', 'Keluarga', 'Ekonomi', 'Kesehatan', 'Karakter', 'calon', 'artikel', 'informasi'];

    return $res;
}

function upload($file, $q, $col, $url, $controller = null)
{
    if ($controller == null) {
        $controller = menu()['controller'];
    }

    $tabel = menu()['tabel'];

    $col_where = 'no_id';

    if (get_db($tabel) == 'pemilu') {
        $controller = 'pemilu';
        $col_where = 'id';
    }

    if ($file['error'] == 4) {
        gagal($url, 'File belum dipilih.');
    }

    $randomname = $col . '_' . str_replace(" ", "_", $q['nama']) . '_' . time();

    if ($file['error'] == 0) {
        $size = $file['size'];

        if ($size > 2000000) {
            gagal($url, 'Ukuran file maksimal 2 MB.');
        }
        if ($col == 'cv' || $col == 'sp' || $col == 'kontrak') {
            $ext = ['pdf'];
        } elseif ($col == 'logo') {
            $ext = ['png'];
        } else {
            $ext = ['jpg', 'jpeg', 'png'];
        }
        $exp = explode(".", $file['name']);
        $exe = strtolower(end($exp));

        if (array_search($exe, $ext) === false) {
            gagal($url, 'Gagal!. Format file harus ' . implode(", ", $ext) . '.');
        }

        $dir = 'berkas/' . $controller . '/';

        $upload = $dir . str_replace("'", "-", $randomname) . '.' . $exe;

        if (!move_uploaded_file($file['tmp_name'], $upload)) {
            gagal($url, 'File gagal diupload.');
        } else {
            if ($q[$col] !== 'file_not_found.jpg') {
                if (!unlink($dir . $q[$col])) {
                    gagal($url, 'File lama gagal dihapus.');
                }
            }

            $q[$col] = $randomname . '.' . $exe;
            $q['updated_at'] = time();
            $q['petugas'] = session('nama');

            if ($controller == 'pemilu') {
                unset($q['nama']);
                unset($q['updated_at']);
            }
            if ($controller == 'calon') {
                unset($q['updated_at']);
            }
            $db = db($tabel, get_db($tabel));

            $db->where($col_where, $q[$col_where]);
            if ($db->update($q)) {
                sukses($url, 'File sukses diupload.');
            } else {
                gagal($url, 'Db gagal diupdate.');
            }
        }
    }
}
function upload_add($file, $data, $col, $url)
{

    $controller = menu()['controller'];
    $tabel = menu()['tabel'];
    $nama = strtolower($data['singkatan_partai']);

    if (get_db($tabel) == 'pemilu') {
        $controller = 'pemilu';
    }

    if ($file['error'] == 4) {
        gagal($url, 'File belum dipilih.');
    }

    $randomname = $col . '_' . str_replace(" ", "_", $nama) . '_' . time();

    if ($file['error'] == 0) {
        $size = $file['size'];

        if ($size > 2000000) {
            gagal($url, 'Ukuran file maksimal 2 MB.');
        }
        if ($col == 'cv' || $col == 'sp' || $col == 'kontrak') {
            $ext = ['pdf'];
        } elseif ($col == 'logo') {
            $ext = ['png'];
        } else {
            $ext = ['jpg', 'jpeg', 'png'];
        }
        $exp = explode(".", $file['name']);
        $exe = strtolower(end($exp));

        if (array_search($exe, $ext) === false) {
            gagal($url, 'Gagal!. Format file harus ' . implode(", ", $ext) . '.');
        }

        $dir = 'berkas/' . $controller . '/';

        $upload = $dir . str_replace("'", "-", $randomname) . '.' . $exe;

        $data['logo_partai'] = $randomname . '.' . $exe;

        $db = db($tabel, get_db($tabel));
        if ($db->insert($data)) {
            if (!move_uploaded_file($file['tmp_name'], $upload)) {
                gagal($url, 'File gagal diupload.');
            } else {

                sukses($url, 'Data sukses diinput.');
            }
        } else {
            gagal($url, 'Data gagal diinput.');
        }
    }
}

function upload_flyer($file, $data, $col, $url)
{

    $controller = menu()['controller'];
    $tabel = menu()['tabel'];
    $nama = strtolower($data['singkatan_partai']);


    if (get_db($tabel) == 'pemilu') {
        $controller = 'pemilu';
    }

    if ($file['error'] == 4) {
        gagal($url, 'File belum dipilih.');
    }

    $randomname = $col . '_' . str_replace(" ", "_", $nama) . '_' . time();

    if ($file['error'] == 0) {
        $size = $file['size'];

        if ($size > 2000000) {
            gagal($url, 'Ukuran file maksimal 2 MB.');
        }
        if ($col == 'cv' || $col == 'sp' || $col == 'kontrak') {
            $ext = ['pdf'];
        } elseif ($col == 'logo') {
            $ext = ['png'];
        } else {
            $ext = ['jpg', 'jpeg', 'png'];
        }
        $exp = explode(".", $file['name']);
        $exe = strtolower(end($exp));

        if (array_search($exe, $ext) === false) {
            gagal($url, 'Gagal!. Format file harus ' . implode(", ", $ext) . '.');
        }

        $dir = 'berkas/' . $controller . '/';

        $upload = $dir . str_replace("'", "-", $randomname) . '.' . $exe;

        $db = db($tabel, get_db($tabel));
        $q = $db->where('singkatan_partai', $data['singkatan_partai'])->where('pondok', $data['pondok'])->get()->getResultArray();

        foreach ($q as $k => $i) {
            if ($k == 0) {
                unlink($dir . $i['flyer']);
            }
            $i['flyer'] = $randomname . '.' . $exe;
            $db->where('id', $i['id']);
            $db->update($i);
        }

        if (!move_uploaded_file($file['tmp_name'], $upload)) {
            gagal($url, 'File gagal diupload.');
        } else {

            sukses($url, 'Data sukses diupdate.');
        }
    }
}

function file_karyawan()
{
    $data = [
        'profile' => 'file_not_found.jpg',
        'ijazah_s1' => 'file_not_found.jpg',
        'nilai_s1' => 'file_not_found.jpg',
        'ijazah_s2' => 'file_not_found.jpg',
        'nilai_s2' => 'file_not_found.jpg',
        'ijazah_s3' => 'file_not_found.jpg',
        'nilai_s3' => 'file_not_found.jpg',
        'ktp' => 'file_not_found.jpg',
        'kk' => 'file_not_found.jpg',
        'wawancara' => 'file_not_found.jpg',
        'bpjs_kes' => 'file_not_found.jpg',
        'bpjs_ket' => 'file_not_found.jpg',
        'ijazah_pendidikan_terakhir' => 'file_not_found.jpg',
        'nilai_pendidikan_terakhir' => 'file_not_found.jpg',
        'cv' => 'file_not_found.jpg',
        'kontrak' => 'file_not_found.jpg',
        'sp' => 'file_not_found.jpg'
    ];
    return $data;
}

function file_santri()
{
    $data = [
        'sp' => 'file_not_found.jpg',
        'profile' => 'file_not_found.jpg',
        'akta_lahir' => 'file_not_found.jpg',
        'ktp' => 'file_not_found.jpg',
        'ktp_ayah' => 'file_not_found.jpg',
        'ktp_ibu' => 'file_not_found.jpg',
        'kk' => 'file_not_found.jpg',
        'bpjs_kes' => 'file_not_found.jpg',
        'ijazah_sd' => 'file_not_found.jpg',
        'ijazah_smp' => 'file_not_found.jpg',
        'bukti_pendaftaran' => 'file_not_found.jpg',
        'wawancara' => 'file_not_found.jpg',
        'psikotes' => 'file_not_found.jpg',
        'questioner' => 'file_not_found.jpg',
        'sertifikat' => 'file_not_found.jpg',
        'listrik' => 'file_not_found.jpg',
        'pdam' => 'file_not_found.jpg',
        'gaji' => 'file_not_found.jpg',
        'photo_1' => 'file_not_found.jpg',
        'photo_2' => 'file_not_found.jpg',
        'photo_3' => 'file_not_found.jpg',
        'photo_4' => 'file_not_found.jpg',
        'photo_5' => 'file_not_found.jpg',
        'photo_6' => 'file_not_found.jpg',
        'photo_7' => 'file_not_found.jpg',
        'photo_8' => 'file_not_found.jpg',
        'photo_9' => 'file_not_found.jpg',
        'photo_10' => 'file_not_found.jpg'
    ];
    return $data;
}

function panduan()
{
    $db = db('settings');
    $q = $db->get()->getRowArray();
    return $q['panduan'];
}

function rupiah($uang)
{
    return 'Rp. ' . number_format($uang, 0, ",", ".");
}

// santri 

function tahun_santri($order)
{
    if ($order == 'santri') {
        if (date('l') < 7) {
            return date('Y') - 1;
        } else {
            return date('Y');
        }
    }
    if ($order == 'ppdb') {
        if (date('l') < 7) {
            return date('Y');
        } else {
            return date('Y') + 1;
        }
    }
}
function tahun_group($tabel, $order)
{
    // order=tahun masuk/tahun keluar
    $db = db($tabel, get_db($tabel));

    $res = $db->select('tahun_' . $order)->groupBy('tahun_' . $order)->orderBy('tahun_' . $order, 'DESC')->get()->getResultArray();

    return $res;
}

function get_fields($tabel, $order = null)
{
    $fields = get_cols($tabel, get_db($tabel));
    if (get_db($tabel) == 'sertifikat') {
        return $fields;
    }

    // $col_file = array_keys(${'file' . get_db($tabel)});
    $fun = 'file_' . get_db($tabel);
    $arr_keys_file = array_keys($fun());
    $arr_keys_tabel = get_cols($tabel, get_db($tabel));

    $res = [];

    foreach ($arr_keys_tabel as $i) {
        if ($i !== 'created_at' && $i !== 'updated_at' && $i !== 'deleted' && $i !== 'petugas') {
            if (in_array($i, $arr_keys_file)) {
                $res[] = ['tipe' => 'file', 'col' => $i];
            } else {
                $res[] = ['tipe' => 'teks', 'col' => $i];
            }
        }
    }

    if ($order == null) {
        return $res;
    } else {
        $data = [];

        foreach ($res as $i) {
            if ($i['tipe'] == $order) {
                $data[] = $i['col'];
            }
        }

        return $data;
    }
}

function template_wa()
{
    $db = db('settings');

    $q = $db->get()->getRowArray();
    return $q;
}


function get_qr_code($url)
{

    $qr_code = QrCode::create($url);
    $writer = new PngWriter;
    $result = $writer->write($qr_code);
    $name = "berkas/qr_code/" . time() . ".png";
    $result->saveToFile($name);

    return $name;
}

// pemilu

function logo_partai()
{
    $db = db('partai', 'pemilu');
    $q = $db->get()->getResultArray();

    $res = [];

    foreach ($q as $i) {
        $res[] = $i['logo_partai'];
    }

    return implode(",", $res);
}

function partai()
{
    $db = db('partai', 'pemilu');
    $q = $db->get()->getResultArray();

    return $q;
}

function last_vote($order = null)
{
    $db = db('pemilih', 'pemilu');
    $q = $db->whereNotIn('tgl', [0])->orderBy('tgl', 'DESC')->get()->getRowArray();

    if ($order == null) {
        if ($q) {
            return $q['tgl'] + 86400;
        } else {
            return time() + (86400 * 3);
        }
    }

    if ($order == 'started') {
        if ($q) {
            return $q;
        } else {
            return null;
        }
    }
}


function no_pilangsari($no)
{
    $res = $no;
    if (strlen($no) == 1) {
        $res = '000' . $no;
    } elseif (strlen($no) == 2) {
        $res = '00' . $no;
    } elseif (strlen($no) == 3) {
        $res = '0' . $no;
    }

    return $res;
}


function rp_to_int($uang)
{
    $uang = str_replace("Rp. ", "", $uang);
    $uang = str_replace(".", "", $uang);
    return $uang;
}

function data_partai($pemilih)
{
    $db = db('calon', get_db('calon'));
    $q = $db->where('tahun', date('Y'))->orderBy('no_urut_partai', 'ASC')->orderBy('status_calon', 'ASC')->get()->getResultArray();
    $pondok = $db->groupBy('pondok')->get()->getResultArray();
    $no_urut_partai = $db->groupBy('no_urut_partai')->get()->getResultArray();
    $data = [];


    if ($pemilih['kategori'] == 'Ndalem' || $pemilih['kategori'] == 'Dewan' || $pemilih['kategori'] == 'Karyawan') {
        if ($pemilih['voted'] == 0) {
            foreach ($pondok as $p) {
                $temp = ['pondok' => $p['pondok'], 'data' => []];
                foreach ($q as $i) {
                    if ($p['pondok'] == $i['pondok']) {
                        foreach ($no_urut_partai as $n) {
                            if ($i['no_urut_partai'] == $n['no_urut_partai']) {
                                $temp['data'][$n['no_urut_partai']][] = $i;
                            }
                        }
                    }
                }
                $data[] = $temp;
            }
        } elseif ($pemilih['voted'] == 1) {
            foreach ($pondok as $p) {
                $temp = ['pondok' => $p['pondok'], 'data' => []];
                if ($p['pondok'] == 'Putri') {
                    foreach ($q as $i) {
                        if ($i['pondok'] == 'Putri') {
                            foreach ($no_urut_partai as $n) {
                                if ($i['no_urut_partai'] == $n['no_urut_partai']) {
                                    $temp['data'][$n['no_urut_partai']][] = $i;
                                }
                            }
                        }
                    }
                }
                $data[] = $temp;
            }
        } elseif ($pemilih['voted'] == 2) {
            foreach ($pondok as $p) {
                $temp = ['pondok' => $p['pondok'], 'data' => []];
                if ($p['pondok'] == 'Putra') {
                    foreach ($q as $i) {
                        if ($i['pondok'] == 'Putra') {
                            foreach ($no_urut_partai as $n) {
                                if ($i['no_urut_partai'] == $n['no_urut_partai']) {
                                    $temp['data'][$n['no_urut_partai']][] = $i;
                                }
                            }
                        }
                    }
                }
                $data[] = $temp;
            }
        } elseif ($pemilih['voted'] == 3) {
            foreach ($pondok as $p) {
                $temp = ['pondok' => $p['pondok'], 'data' => []];
                $data[] = $temp;
            }
        }
    } else {
        if ($pemilih['voted'] == 0) {

            $temp = ['pondok' => $pemilih['pondok'], 'data' => []];
            foreach ($q as $i) {
                if ($i['pondok'] == $pemilih['pondok']) {
                    foreach ($no_urut_partai as $n) {
                        if ($i['no_urut_partai'] == $n['no_urut_partai']) {
                            $temp['data'][$n['no_urut_partai']][] = $i;
                        }
                    }
                }
            }
            $data[] = $temp;
        } elseif ($pemilih['voted'] == 3) {
            $temp = ['pondok' => $pemilih['pondok'], 'data' => []];

            $data[] = $temp;
        }
    }

    return $data;
}

function capres_cawapres($tahun, $pondok, $no_urut, $order = null)
{
    $db = db('calon', get_db('calon'));
    $q = $db->where('tahun', $tahun)->where('pondok', $pondok)->where('no_urut_partai', $no_urut)->orderBy('status_calon', 'ASC')->get()->getResultArray();

    if ($order == 'nama') {
        $nama = [];
        foreach ($q as $i) {
            $nama[] = $i['nama'];
        }

        return implode("/", $nama);
    }
    if ($order == 'capres') {

        $nama = [];
        foreach ($q as $i) {
            if ($i['status_calon'] == 'Capres') {
                $nama = $i;
            }
        }

        return $nama;
    }
}

function bobot_suara($kategori, $url)
{
    $db = db('kategori', get_db('kategori'));
    $q = $db->where('kategori', $kategori)->get()->getRowArray();
    if (!$q) {
        gagal($url, 'Kategori tidak ditemukan.');
    }
    return $q['suara'];
}

function get_words($sentence, $count = 2)
{
    $exp = explode(".", $sentence);
    $arr = [];

    foreach ($exp as $k => $i) {
        if ($k < $count) {
            $arr[] = $i;
        }
    }

    return implode(". ", $arr);
}

function get_news($label = 'All')
{

    $db = db('artikel', 'news');

    $db;
    if ($label !== 'All' && $label !== 'Trending') {
        $db->where('label', $label);
    }

    $data = $db->orderBy(($label == 'Trending' ? 'views' : 'tgl'), 'DESC')->get()->getResultArray();

    return $data;
}

function hasil_pemilu($tahun)
{
    $db = db('calon', get_db('calon'));


    $db;
    if ($tahun !== 'All') {
        $db->where('tahun', $tahun);
    }
    $tahuns = $db->groupBy('tahun')->orderBy('tahun', 'DESC')->get()->getResultArray();

    $db;
    if ($tahun !== 'All') {
        $db->where('tahun', $tahun);
    }
    $partai = $db->groupBy('singkatan_partai')->orderBy('no_urut_partai', 'ASC')->get()->getResultArray();

    $pondok = ['Putra', 'Putri'];
    $data = [];

    foreach ($tahuns as $i) {
        $pon = [];

        foreach ($pondok as $pdk) {
            $par = [];
            foreach ($partai as $p) {
                $capres = $db->where('tahun', $i['tahun'])->where('pondok', $pdk)->where('singkatan_partai', $p['singkatan_partai'])->where('status_calon', 'Capres')->get()->getRowArray();
                $cawapres = $db->where('tahun', $i['tahun'])->where('pondok', $pdk)->where('singkatan_partai', $p['singkatan_partai'])->where('status_calon', 'Cawapres')->get()->getRowArray();
                $par[] = ['capres' => $capres, 'cawapres' => $cawapres, 'suara' => $cawapres['suara'], 'flyer' => $cawapres['flyer'], 'partai' => $capres['partai'], 'singkatan_partai' => $capres['singkatan_partai'], 'no_partai' => $capres['no_urut_partai'], 'visi_misi' => $cawapres['visi_misi']];
            }

            $pon[] = ['pondok' => $pdk, 'data' => $par];
        }
        $data[] = ['tahun' => $i['tahun'], 'detail' => $pon];
    }

    return $data;
}

function labels_news()
{
    $db = db('artikel', 'news');
    $labels = $db->groupBy('label')->orderBy('label', 'ASC')->get()->getResultArray();

    return $labels;
}

function get_daerah($order)
{
    $db = db($order, 'indonesia');

    $q = $db->orderBy('name', 'ASC')->get()->getResultArray();

    return $q;
}

function is_array_in_array($req)
{
    $res = false;
    if (array_key_exists(0, $req)) {
        if (is_array($req[0])) {
            $res = true;
        }
    }

    return $res;
}

// rebana

function hari($req)
{
    $hari = [
        ['inggris' => 'Monday', 'indo' => 'Senin'],
        ['inggris' => 'Tuesday', 'indo' => 'Selasa'],
        ['inggris' => 'Wednesday', 'indo' => 'Rabu'],
        ['inggris' => 'Thursday', 'indo' => 'Kamis'],
        ['inggris' => 'Friday', 'indo' => 'Jumat'],
        ['inggris' => 'Saturday', 'indo' => 'Sabtu'],
        ['inggris' => 'Sunday', 'indo' => 'Ahad']
    ];

    $res = [];
    foreach ($hari as $i) {
        if ($i['inggris'] == $req) {
            $res = $i;
        } elseif ($i['indo'] == $req) {
            $res = $i;
        }
    }

    return $res;
}


function pasaran()
{
    $res = ['Pon', 'Wage', 'Kliwon', 'Legi', 'Pahing'];

    return $res;
}


function get_files($dir, $ext = ['jpg', 'jpeg', 'png'])
{
    $dir_name = "berkas/" . $dir . "/";
    $images = glob($dir_name . "*.*");

    $val = [];
    foreach ($images as $i) {

        $exp = explode(".", $i);
        $format = strtolower(end($exp));
        if (in_array($format, $ext)) {
            $val[] = $i;
        }
    }

    return $val;
}

function day_in_month()
{
    return cal_days_in_month(CAL_GREGORIAN, date('n'), date('Y'));
}

function add_image($file, $url, $folder)
{
    if ($file['error'] == 4) {
        gagal($url, 'Gambar belum dipilih.');
    } else {
        if ($file['error'] == 0) {
            $size = $file['size'];

            if ($size > 2000000) {
                gagal($url, 'Gagal!. Ukuran maksimal file 2MB.');
            }

            $ext = ['png', 'jpg', 'jpeg'];

            $exp = explode(".", $file['name']);
            $exe = strtolower(end($exp));

            if (array_search($exe, $ext) === false) {
                gagal($url, 'Gagal!. Format file harus ' . implode(", ", $ext) . '.');
            }

            $nama = (menu()['controller'] == 'ppdb' ? 'ppdb' : (menu()['controller'] == 'recruitment' ? 'recruitment' : $folder)) . '-' . time() . '.' . $exe;

            $gambar = 'berkas/' . $folder . '/' . $nama;

            if (!move_uploaded_file($file['tmp_name'], $gambar)) {
                gagal($url, 'File gagal diupload.');
            }

            sukses($url, 'File berhasil diupload.');
        } else {
            gagal($url, 'Something wrong.');
        }
    }
}

function get_informasi()
{
    $db = db('informasi', 'data');

    $q = $db->where('section', session('section'))->where('role', session('role'))->where('gender', session('gender'))->get()->getRowArray();

    return $q;
}
