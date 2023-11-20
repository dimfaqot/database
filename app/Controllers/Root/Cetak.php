<?php


namespace App\Controllers\Root;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Cetak extends BaseController
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
        // $db = db('provinsi', 'indonesia');
        // $q = $db->get()->getResultArray();
        // foreach ($q as $i) {
        //     $i['name'] = upper_first($i['name']);

        //     $db->where('id', $i['id']);
        //     $db->update($i);
        // }
        $data = explode(",", get_db());

        return view('root/cetak', ['judul' => 'Cetak', 'data' => $data]);
    }
    public function db()
    {
        $db = clear($this->request->getVar('db'));

        $data = get_tables($db);
        sukses_js('Koneksi sukses', $data, get_default_cetak($db)['tabel']);
    }
    public function col()
    {
        $table = clear($this->request->getVar('table'));
        $db = clear($this->request->getVar('db'));

        $data = get_cols($table, $db);
        sukses_js('Koneksi sukses', $data, get_default_cetak($db, $table)['col'], get_default_cetak($db, $table)['id']);
    }

    public function filter()
    {
        $table = clear($this->request->getVar('table'));
        $data = [];
        if ($table == 'karyawan' || $table == 'recruitment' || $table == 'santri' || $table == 'ppdb') {
            $data = [
                [
                    'filter' => 'alamat',
                    'detail' => [
                        ['order' => 'provinsi', 'data' => get_daerah('provinsi')],
                        ['order' => 'kabupaten', 'data' => get_daerah('kabupaten')],
                        ['order' => 'kecamatan', 'data' => get_daerah('kecamatan')],
                        ['order' => 'kelurahan', 'data' => get_daerah('kelurahan')],
                    ]
                ],
                [
                    'filter' => 'sub',
                    'detail' => sub()
                ],
                [
                    'filter' => 'status',
                    'detail' => options('Status')
                ],
                [
                    'filter' => 'gender',
                    'detail' => ['L', 'P']
                ],
                [
                    'filter' => 'ikut_bpjs_kes',
                    'detail' => ['Ikut', 'Tidak']
                ],
                [
                    'filter' => 'umur',
                    'detail' => ['semua', 'filter']
                ],
                [
                    'filter' => ($table == 'santri' || $table == 'ppdb' ? 'durasi' : 'pengabdian'),
                    'detail' => ['semua', 'filter']
                ]
            ];

            if ($table == 'karyawan' || $table == 'recruitment') {
                $data[] =   [
                    'filter' => 'ikut_bpjs_ket',
                    'detail' => ['Ikut', 'Tidak']
                ];
            }
        }
        if ($table == 'sk') {
            $db = db('sk', 'karyawan');
            $q = $db->groupBy('sub')->orderBy('sub', 'ASC')->get()->getResultArray();
            $data = [
                [
                    'filter' => 'sub',
                    'detail' => $q
                ],
                [
                    'filter' => 'tahun',
                    'detail' => ['semua', 'filter']
                ]
            ];
        }
        if ($table == 'piagam') {
            $data = [
                [
                    'filter' => 'jenis',
                    'detail' => ['Dinas', 'Swasta']
                ],
                [
                    'filter' => 'sub',
                    'detail' => sub()
                ],
                [
                    'filter' => 'tahun',
                    'detail' => ['semua', 'filter']
                ]
            ];
        }
        if ($table == 'pilangsari') {
            $db = db('pilangsari', 'sertifikat');
            $q = $db->groupBy('kategori')->orderBy('kategori', 'ASC')->get()->getResultArray();
            $data = [
                [
                    'filter' => 'jenis',
                    'detail' => ['SSJ', 'NONSSJ', 'Kosong']
                ],
                [
                    'filter' => 'kategori',
                    'detail' => $q
                ]
            ];
        }
        if ($table == 'calon') {
            $data = [
                [
                    'filter' => 'tahun',
                    'detail' => ['semua', 'filter']
                ],
                [
                    'filter' => 'pondok',
                    'detail' => ['Putra', 'Putri']
                ]
            ];
        }
        sukses_js('Koneksi sukses', $data, get_default_cetak(get_db($table), $table)['id']);
    }


    public function get_data()
    {
        $nama_gelar = clear($this->request->getVar('nama_gelar'));
        $dbs = clear($this->request->getVar('db'));
        $tabel = clear($this->request->getVar('tabel'));
        $cols = json_decode(json_encode($this->request->getVar('cols')), true);
        $filter = json_decode(json_encode($this->request->getVar('filter')), true);
        $filters = json_decode(json_encode($this->request->getVar('filters')), true);

        if (!in_array(get_default_cetak($dbs, $tabel)['id'], $cols)) {
            $cols[] = get_default_cetak($dbs, $tabel)['id'];
        }

        $db = db($tabel, $dbs);
        $db;

        $daerah = ['provinsi', 'kabupaten', 'kecamatan', 'kelurahan'];
        foreach ($daerah as $i) {
            $val = clear($this->request->getVar($i));
            if ($val && $val !== '') {
                $db->where($i, $val);
            }
        }

        // where_in
        foreach ($filter as $i) {
            foreach ($filters as $f) {
                if ($i == $f['filter']) {

                    if (!is_array_in_array($f['data'])) {
                        if (count($f['data']) > 0) {
                            $val = $f['data'];
                            if (count($f['data']) == 1) {
                                if ($val[0] == 'Ikut' || $val[0] == 'Tidak') {
                                    $val = (in_array('Ikut', $f['data']) ? ['1'] : ['0']);
                                }
                            }
                            if (count($f['data']) == 2) {
                                if (in_array('Ikut', $f['data']) && in_array('Tidak', $f['data'])) {
                                    $val = ['0', '1'];
                                }
                            }

                            $db->whereIn($i, $val);
                        }
                    }
                }
            }
        }

        $q = $db->get()->getResultArray();


        $data = [];

        // tambah umur, pengabdian, durasi, alamat lengkap, dan nama lengkap
        foreach ($q as $i) {


            if ($nama_gelar == "1" && array_key_exists('nama', $i)) {
                $i['nama'] = nama_gelar($i);
            }
            if (in_array('alamat', $cols) && in_array('kelurahan', $cols) && in_array('kecamatan', $cols)) {
                $i['alamat_lengkap'] = alamat_lengkap($i);
                if (!in_array('alamat_lengkap', $cols)) {
                    $cols[] = 'alamat_lengkap';
                }
            }
            if (in_array('kota_lahir', $cols) || in_array('tgl_lahir', $cols)) {
                $i['ttl'] = ttl($i);
                if (!in_array('ttl', $cols)) {
                    $cols[] = 'ttl';
                }
            }

            if (array_key_exists('tahun_masuk', $i)) {
                if ($tabel == 'karyawan' || $tabel == 'recruitment') {
                    if (!in_array('pengabdian', $cols)) {
                        $cols[] = 'pengabdian';
                    }
                    $i['pengabdian'] = date('Y') - $i['tahun_masuk'];
                }
                if ($tabel == 'santri' || $tabel == 'ppdb') {
                    if (!in_array('durasi', $cols)) {
                        $cols[] = 'durasi';
                    }
                    $i['durasi'] = date('Y') - $i['tahun_masuk'];
                }
            }
            if (array_key_exists('tgl_lahir', $i)) {
                if (!in_array('umur', $cols)) {
                    $cols[] = 'umur';
                }
                $i['umur'] =  umur($i['tgl_lahir']);

                $i['tgl_lahir'] = date('d/m/Y', $i['tgl_lahir']);
            }

            if (array_key_exists('ikut_bpjs_ket', $i)) {
                $i['ikut_bpjs_ket'] = ($i['ikut_bpjs_ket'] == 1 ? 'Ikut' : 'Tidak');
            }
            if (array_key_exists('ikut_bpjs_kes', $i)) {
                $i['ikut_bpjs_kes'] = ($i['ikut_bpjs_kes'] == 1 ? 'Ikut' : 'Tidak');
            }

            $data[] = $i;
        }



        $res = [];

        // filter data
        foreach ($data as $i) {

            $k = 0;

            foreach ($filters as $f) {
                if (is_array_in_array($f['data'])) {
                    $val = $f['data'][0];
                    if (array_key_exists('value', $val)) {
                        if ($val['value'] !== 'semua') {

                            if ($val['dari'] !== '' && $val['sampai'] !== '') {
                                if ($i[$f['filter']] < $val['dari'] || $i[$f['filter']] > $val['sampai']) {
                                    $k = 1;
                                }
                            } else {
                                if (($key = array_search($f['filter'], $cols)) !== false) {
                                    unset($cols[$key]);
                                }
                            }
                        }
                    } else {
                        if (($key = array_search($f['filter'], $cols)) !== false) {
                            unset($cols[$key]);
                        }
                    }
                }
            }




            if ($k == 1) {
                continue;
            }

            $res[] = $i;
        }

        // reset index cols after unset
        $new_cols = [];
        foreach ($cols as $i) {
            $new_cols[] = $i;
        }

        $values = [];

        // filter cols
        foreach ($res as $i) {
            $val = [];
            foreach ($new_cols as $c) {
                $val[$c] = $i[$c];
            }

            $values[] = $val;
        }

        $col = get_default_cetak($dbs, $tabel)['col'];
        $last = ['cols' => $new_cols, 'data' => $values, 'col' => $col, 'is_sertifikat' => is_sertifikat($tabel)];

        sukses_js('Ok', $last, get_default_cetak($dbs, $tabel)['id']);
    }

    public function cetak($order, $jwt)
    {
        $decode_jwt = decode_jwt($jwt);

        $datas = json_decode(json_encode($decode_jwt['datas']), true);
        $tabel = $decode_jwt['tabel'];
        $cols = $decode_jwt['cols'];

        $remove = false;
        if (array_key_exists('remove', $decode_jwt)) {
            $remove = $decode_jwt['remove'];
        }
        $db = get_db($tabel);
        $judul = 'Data ' . upper_first(str_replace("_", " ", $tabel));
        $view = ($tabel == 'sertifikat' ? 'ekstra' : $tabel);

        $orientation = 'L';
        if ($tabel == 'pilangsari' || $tabel == 'sertifikat') {
            $orientation = 'P';
        }
        if ($order == 'pdf' && count($cols) < 5) {
            $orientation = 'P';
        }

        $ttd = false;

        if ($decode_jwt['ttd'] == '2') {
            $ttd = true;
        }

        if ($order == 'pdf' && count($datas) == 1) {
            $orientation = 'P';
        }

        if (array_key_exists('headers', $decode_jwt)) {
            $headers = json_decode(json_encode($decode_jwt['headers']), true);
            $judul = $headers['judul'];
            if ($headers['jml_kolom'] + count($cols) < 5) {
                $orientation = 'P';
            }
        }

        if ($tabel == 'sk' || $order == 'pdf') {
            $set = [
                'mode' => 'utf-8',
                'format' => [215, 330],
                'orientation' => ($tabel == 'sk' ? 'P' : $orientation),
                'margin-left' => 20,
                'margin-right' => 20,
                'margin-top' => -20,
                'margin-bottom' => 0,
            ];
        } else {
            $set = [
                'mode' => 'utf-8',
                'format' => 'A4',
                'orientation' => $orientation,
                'margin-left' => 20,
                'margin-right' => 20,
                'margin-top' => -0,
                'margin-bottom' => 0
            ];
        }

        $id = get_default_cetak($db, $tabel)['id'];

        $nama = get_default_cetak($db, $tabel)['col'];
        $mpdf = new \Mpdf\Mpdf($set);

        $db = db($tabel, get_db($tabel));

        $data = [];

        if (count($datas) == 1) {
            $judul = upper_first(str_replace("_", " ", $tabel)) . ' ' . $datas[0][$nama];
        }

        foreach ($datas as $i) {
            $q = $db->where($id, $i[$id])->get()->getRowArray();
            if ($q) {
                $data[] = $q;
            }
        }

        if ($order == 'sertifikat') {
            if ($tabel !== 'sk') {
                $mpdf->useSubstitutions = false;
            }

            foreach ($data as $i) {

                if ($tabel == 'sk') {

                    $i['is_ttd'] = $ttd;
                    $i['ttd'] = '<img width="100px" src="' .  'berkas/ttd/' . get_ttd($i['ketua_ypp']) . '" alt="Ttd"/>';
                    $i['kop'] = '<img src="' .  'berkas/kop/' . $i['kop'] . '" alt="Kop"/>';
                }

                if ($tabel == 'piagam') {
                    $th = db('tahun');
                    $t = $th->where('tahun', $i['tahun'])->get()->getRowArray();
                    $i['is_ttd'] = $ttd;
                    $i['ketua_ypp'] = $t['ketua_ypp'];
                    $i['ttd_ketua_ypp'] = '<img width="110px" src="' .  'berkas/ttd/' . get_ttd($t['ketua_ypp']) . '" alt="Ttd"/>';
                    if ($i['sub'] == 'Pondok') {
                        $exp = explode(",", $i['nama']);
                        $dbg = db('karyawan', get_db('karyawan'));
                        $g = $dbg->where('nama', $exp[0])->get()->getRowArray();

                        $pondok = ($g['gender'] == "L" ? 'putra' : 'putri');
                        $kep = $t['kepala_' . strtolower($i['sub']) . '_' . $pondok];

                        $i['kepala'] = $kep;
                        $i['ttd_kepala'] = '<img width="110px" src="' .  'berkas/ttd/' . get_ttd($kep) . '" alt="Ttd"/>';
                    } else {
                        $i['kepala'] = $t['kepala_' . strtolower($i['sub'])];
                        $i['ttd_kepala'] = '<img width="110px" src="' .  'berkas/ttd/' . get_ttd($t['kepala_' . strtolower($i['sub'])]) . '" alt="Ttd"/>';
                    }

                    $i['link_qr_code'] = $i['qr_code'];
                    $i['qr_code'] = '<img width="100px" src="' .  $i['qr_code'] . '" alt="QR CODE"/>';

                    $i['cover'] = '<img src="' .  'berkas/' . menu()['controller'] . '/' . $i['jenis'] . '.jpg" alt="Piagam"/>';
                    $i['img'] = 'berkas/sertifikat/' . $i['jenis'] . '.jpg';
                }

                if ($tabel == 'pilangsari') {
                    $i['link_qr_code'] = $i['qr_code'];
                    $i['qr_code'] = '<img width="100px" src="' .  $i['qr_code'] . '" alt="QR CODE"/>';
                    $i['img'] = 'berkas/sertifikat/Pilangsari.jpg';
                }


                $html = view('cetak/' . $view, ['judul' => $judul, 'data' => $i]);
                $mpdf->AddPage();
                if ($tabel !== 'sk') {
                    $mpdf->SetDefaultBodyCSS('background', "url(" . $i['img'] . ")");
                    $mpdf->SetDefaultBodyCSS('background-image-resize', 6);
                }
                $mpdf->WriteHTML($html);
            }

            $this->response->setHeader('Content-Type', 'application/pdf');
            $mpdf->Output($judul . '.pdf', 'I');
        }

        if ($order == 'pdf') {
            $data = [];
            foreach ($datas as $i) {
                if (!$remove && $i[$id]) {
                    unset($i[$id]);
                    if (($key = array_search($id, $cols)) !== false) {
                        unset($cols[$key]);
                    }
                }
                $data[] = $i;
            }
            // reset index cols after unset
            $new_cols = [];
            foreach ($cols as $i) {
                $new_cols[] = $i;
            }
            $html = view('cetak/cetak', ['judul' => $judul, 'data' => $data, 'cols' => $new_cols]);
            $mpdf->AddPage();
            $mpdf->WriteHTML($html);

            $this->response->setHeader('Content-Type', 'application/pdf');

            $mpdf->Output($judul . '.pdf', 'I');
        }

        if ($order == 'custome') {
            $data = [];
            foreach ($datas as $i) {
                if (!$remove && $i[$id]) {
                    unset($i[$id]);
                    if (($key = array_search($id, $cols)) !== false) {
                        unset($cols[$key]);
                    }
                }
                $data[] = $i;
            }
            // reset index cols after unset
            $new_cols = [];
            foreach ($cols as $i) {
                $new_cols[] = $i;
            }
            $html = view('cetak/custome', ['judul' => $judul, 'data' => $data, 'cols' => $new_cols, 'headers' => $headers]);
            $mpdf->AddPage();
            $mpdf->WriteHTML($html);

            $this->response->setHeader('Content-Type', 'application/pdf');

            $mpdf->Output($judul . '.pdf', 'I');
        }

        if ($order == 'excel') {
            $data = [];
            foreach ($datas as $i) {
                if (!$remove && $i[$id]) {
                    unset($i[$id]);
                    if (($key = array_search($id, $cols)) !== false) {
                        unset($cols[$key]);
                    }
                }
                $data[] = $i;
            }
            // reset index cols after unset
            $new_cols = [];
            foreach ($cols as $i) {
                $new_cols[] = $i;
            }

            $spreadsheet = new Spreadsheet();

            $sheet = $spreadsheet->getActiveSheet();

            $huruf = 'Z';

            foreach ($new_cols as $k => $c) {
                $huruf++;
                if ($k < 26) {
                    $sheet->setCellValue(substr($huruf, -1) . '1', upper_first(str_replace("_", " ", $c)));
                } else {
                    $sheet->setCellValue('A' . substr($huruf, -1) . '1', upper_first(str_replace("_", " ", $c)));
                }
            }

            $rows = 2;
            $huruf = 'Z';
            foreach ($data as $i) {
                foreach ($new_cols as $k => $c) {
                    $val = $i[$c];
                    $huruf++;
                    if ($k < 26) {
                        $sheet->setCellValue(substr($huruf, -1) . $rows, $val);
                    } else {
                        $sheet->setCellValue('A' . substr($huruf, -1) . $rows, $val);
                    }
                }
                $huruf = 'Z';
                $rows++;
            }
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename=' . $judul . '.xlsx');
            header('Cache-Control: maxe-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');

            exit;
        }
    }
}
