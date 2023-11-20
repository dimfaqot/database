<?php


namespace App\Controllers\Sertifikat;

use App\Controllers\BaseController;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Piagam extends BaseController
{


    function __construct()
    {
        helper('functions');
        if (!session('id')) {
            gagal(base_url('login'), 'Anda belum login.');
        }
        check_role();
    }

    public function index($jenis, $tahun)
    {

        $db = db(menu()['tabel'], get_db(menu()['tabel']));

        $db;
        if ($jenis !== 'All') {
            $db->where('jenis', $jenis);
        }
        if ($tahun !== 'All') {
            $db->where('tahun', $tahun);
        }
        $q = $db->orderBy('updated_at', 'DESC')->get()->getResultArray();


        $db = db('tahun');
        $tahuns = $db->groupBy('tahun')->orderBy('tahun', 'DESC')->get()->getResultArray();
        return view('sertifikat/' . menu()['controller'], ['judul' => menu()['menu'], 'data' => $q, 'tahuns' => $tahuns]);
    }

    public function add()
    {
        $jenis = clear($this->request->getVar('jenis'));
        $lomba = upper_first(clear($this->request->getVar('lomba')));
        $no_id = clear($this->request->getVar('no_id'));
        $url = clear($this->request->getVar('url'));
        $tahun = clear($this->request->getVar('tahun'));
        $sebagai = upper_first(clear($this->request->getVar('sebagai')));
        $capaian = upper_first(clear($this->request->getVar('capaian')));

        $db = db('karyawan', 'karyawan');
        $q = $db->where('no_id', $no_id)->get()->getRowArray();

        if (!$q) {
            gagal($url, "No. id karyawan tidak ditemukan.");
        }

        $time = time();

        $data = [
            'tahun' => $tahun,
            'tgl' => $time,
            'no_surat' => last_no_piagam($time),
            'jenis' => $jenis,
            'capaian' => $capaian,
            'sebagai' => $sebagai,
            'lomba' => $lomba,
            'sub' => $q['sub'],
            'nama' => nama_gelar($q),
            'created_at' => time(),
            'updated_at' => time()

        ];

        $db = db(menu()['tabel'], get_db(menu()['tabel']));

        if ($db->insert($data)) {
            sukses($url, 'Data sukses dimasukkan.');
        } else {
            gagal($url, 'Data gagal dimasukkan.');
        }
    }
    public function update()
    {
        $id = clear($this->request->getVar('id'));
        $tgl = strtotime(clear($this->request->getVar('tgl')));
        $no_surat = clear($this->request->getVar('no_surat'));
        $tahun = clear($this->request->getVar('tahun'));
        $nama = $this->request->getVar('nama');
        $jenis = clear($this->request->getVar('jenis'));
        $sub = clear($this->request->getVar('sub'));
        $lomba = clear($this->request->getVar('lomba'));
        $sebagai = clear($this->request->getVar('sebagai'));
        $url = clear($this->request->getVar('url'));
        $capaian = clear($this->request->getVar('capaian'));


        $db = db(menu()['tabel'], get_db(menu()['tabel']));

        $q = $db->where('id', $id)->get()->getRowArray();

        if (!$q) {
            gagal($url, 'Id tidak ditemukan.');
        }

        $exist = $db->whereNotIn('id', [$id])->where('no_surat', $no_surat)->get()->getRowArray();
        if ($exist) {
            gagal($url, 'No. surat sudah ada.');
        }

        if ($q['no_surat'] !== $no_surat) {
            $q['no_surat'] = $no_surat;
        }

        if ($q['tgl'] !== $tgl) {
            if (date('m', $q['tgl']) !== date('m', $tgl)) {

                $q['no_surat'] = last_no_piagam($tgl);
            }
        }


        $q['tahun'] = $tahun;
        $q['nama'] = $nama;
        $q['tgl'] = $tgl;
        $q['jenis'] = $jenis;
        $q['sub'] = $sub;
        $q['lomba'] = $lomba;
        $q['sebagai'] = $sebagai;
        $q['capaian'] = $capaian;
        $q['updated_at'] = time();


        $db->where('id', $id);
        if ($db->update($q)) {
            sukses($url, 'Data berhasil diupdate.');
        } else {
            sukses($url, 'Data gagal diupdate.');
        }
    }

    public function update_blur()
    {
        $id = clear($this->request->getVar('id'));
        $col = clear($this->request->getVar('col'));
        $val = clear($this->request->getVar('val'));


        $db = db('tahun');

        $q = $db->where('tahun', $id)->get()->getRowArray();

        if (!$q) {
            gagal_js('Id tidak ditemukan.');
        }
        $q[$col] = $val;
        $q['petugas'] = session('petugas');

        $db->where('tahun', $id);
        if ($db->update($q)) {
            sukses_js('Data berhasil diupdate.');
        } else {
            sukses_js('Data gagal diupdate.');
        }
    }
    public function cetak($order, $ttd, $jwt)
    {
        $ttd = false;

        if ($ttd == '2') {
            $ttd = true;
        }

        $decode_jwt = decode_jwt($jwt);

        $db = db(menu()['tabel'], get_db(menu()['tabel']));


        $data = [];
        foreach ($decode_jwt as $i) {

            $q = $db->where('id', $i)->get()->getRowArray();


            $th = db('tahun');
            $t = $th->where('tahun', $q['tahun'])->get()->getRowArray();

            $q['is_ttd'] = $ttd;
            $q['ketua_ypp'] = $t['ketua_ypp'];
            $q['ttd_ketua_ypp'] = '<img width="110px" src="' .  'berkas/ttd/' . get_ttd($t['ketua_ypp']) . '" alt="Ttd"/>';
            if ($q['sub'] == 'Pondok') {
                $exp = explode(",", $q['nama']);
                $dbg = db('karyawan', get_db('karyawan'));
                $g = $dbg->where('nama', $exp[0])->get()->getRowArray();

                $pondok = ($g['gender'] == "L" ? 'putra' : 'putri');
                $kep = $t['kepala_' . strtolower($q['sub']) . '_' . $pondok];

                $q['kepala'] = $kep;
                $q['ttd_kepala'] = '<img width="110px" src="' .  'berkas/ttd/' . get_ttd($kep) . '" alt="Ttd"/>';
            } else {
                if ($q['sub'] == 'Yayasan') {
                    $q['kepala'] = $t['ketua_ypp'];
                    $q['ttd_kepala'] = '<img width="110px" src="' .  'berkas/ttd/' . get_ttd($t['ketua_ypp']) . '" alt="Ttd"/>';
                } else {
                    $q['kepala'] = $t['kepala_' . strtolower($q['sub'])];
                    $q['ttd_kepala'] = '<img width="110px" src="' .  'berkas/ttd/' . get_ttd($t['kepala_' . strtolower($q['sub'])]) . '" alt="Ttd"/>';
                }
            }


            $q['cover'] = '<img src="' .  'berkas/' . menu()['controller'] . '/' . $q['jenis'] . '.jpg" alt="Piagam"/>';
            $q['img'] = 'berkas/sertifikat/' . $q['jenis'] . '.jpg';
            $data[] = $q;
        }

        $judul = 'Data Piagam';
        if (count($data) == 1) {
            $judul = 'Piagam ' . $data[0]['nama'];
        }


        if ($order == 'pdf' || $order == 'single') {
            $set = [
                'mode' => 'utf-8',
                'format' => 'A4',
                'orientation' => 'L',
                'margin-left' => 20,
                'margin-right' => 20,
                'margin-top' => -0,
                'margin-bottom' => 0
            ];


            $mpdf = new \Mpdf\Mpdf($set);
            $mpdf->useSubstitutions = false;

            foreach ($data as $i) {
                $html = view('cetak/' . menu()['controller'], ['judul' => $judul, 'data' => $i]);

                $mpdf->AddPage();

                $mpdf->SetDefaultBodyCSS('background', "url(" . $i['img'] . ")");
                $mpdf->SetDefaultBodyCSS('background-image-resize', 6);
                $mpdf->WriteHTML($html);
            }


            $this->response->setHeader('Content-Type', 'application/pdf');
            $mpdf->Output($judul . '.pdf', 'I');
        } else {
            $cols = get_fields(menu()['tabel']);

            $filename = $judul . '.xlsx';

            $spreadsheet = new Spreadsheet();

            $sheet = $spreadsheet->getActiveSheet();

            $huruf = 'Z';

            foreach ($cols as $k => $c) {
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
                foreach ($cols as $k => $c) {
                    $val = $i[$c];

                    if ($c == 'qr_code') {
                        $val = base_url() . $i['link_qr_code'];
                    }
                    if ($c == 'tgl') {
                        $val = date('d/m/Y', $val);
                    }
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
            header('Content-Disposition: attachment;filename=' . $filename);
            header('Cache-Control: maxe-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');

            exit;
        }
    }

    public function delete()
    {
        $id = $this->request->getVar('id');

        $db = db(menu()['tabel'], get_db(menu()['tabel']));

        $q = $db->where('id', $id)->get()->getRowArray();

        if (!$q) {
            gagal_js('Id tidak ditemukan.');
        }


        $db->where('id', $id);
        if ($db->delete()) {
            sukses_js('Data berhasil didelete.');
        } else {
            gagal_js('Data gagal didelete.');
        }
    }
}
