<?php

namespace App\Controllers\Rebana;

use App\Controllers\BaseController;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Rebana extends BaseController
{
    function __construct()
    {
        helper('functions');
        if (!session('id')) {
            gagal(base_url('login'), 'Anda belum login.');
        }
        check_role();
    }
    public function index($tahun, $bulan): string
    {
        $db = db(menu()['tabel'], get_db(menu()['tabel']));
        $q = $db->orderBy('tgl', 'ASC')->get()->getResultArray();

        $data = [];
        $th = [];
        foreach ($q as $i) {
            if (!in_array(date('Y', $i['tgl']), $th)) {
                $th[] = date('Y', $i['tgl']);
            }
            if ($tahun == 'Semua' && $bulan == 'Semua') {
                $data[] = $i;
            } elseif ($tahun !== 'Semua' && $bulan !== 'Semua') {

                if (date('m', $i['tgl']) == $bulan && date('Y', $i['tgl']) == $tahun) {
                    $data[] = $i;
                }
            } elseif ($tahun == 'Semua' && $bulan !== 'Semua') {
                if (date('m', $i['tgl']) == $bulan) {
                    $data[] = $i;
                }
            } elseif ($tahun !== 'Semua' && $bulan == 'Semua') {
                if (date('Y', $i['tgl']) == $tahun) {
                    $data[] = $i;
                }
            }
        }

        return view('rebana/' . menu()['controller'], ['judul' => menu()['menu'], 'data' => $data, 'tahun' => $th, 'bulan' => $bulan]);
    }

    public function add()
    {

        $url = clear($this->request->getVar('url'));
        $tgl = strtotime(clear($this->request->getVar('tgl')));

        $pasaran = clear($this->request->getVar('pasaran'));
        $alamat = upper_first(clear($this->request->getVar('alamat')));
        $jam = clear($this->request->getVar('jam'));
        $acara = upper_first(clear($this->request->getVar('acara')));
        $panitia = upper_first(clear($this->request->getVar('panitia')));
        $telepon = clear($this->request->getVar('telepon'));
        $penjemputan = upper_first(clear($this->request->getVar('penjemputan')));
        $keterangan = upper_first(clear($this->request->getVar('keterangan')));

        $data = [
            'tgl' => $tgl,
            'pasaran' => $pasaran,
            'alamat' => $alamat,
            'jam' => $jam,
            'acara' => $acara,
            'panitia' => $panitia,
            'telepon' => $telepon,
            'penjemputan' => $penjemputan,
            'keterangan' => $keterangan
        ];

        $db = db(menu()['tabel'], get_db(menu()['tabel']));

        if ($db->insert($data)) {
            sukses($url, 'Data berhasil disimpan.');
        } else {
            gagal($url, 'Data gagal disimpan.');
        }
    }

    public function update()
    {

        $id = clear($this->request->getVar('id'));
        $url = clear($this->request->getVar('url'));
        $lagu = clear($this->request->getVar('lagu'));
        $db = db(menu()['tabel'], get_db(menu()['tabel']));

        $q = $db->where('id', $id)->get()->getRowArray();

        if (!$q) {
            gagal($url, 'Id tidak ditemukan.');
        }

        if (session('role') == 'Admin' || session('role') == 'Root') {
            $tgl = strtotime(upper_first(clear($this->request->getVar('tgl'))));
            $pasaran = clear($this->request->getVar('pasaran'));
            $alamat = upper_first(clear($this->request->getVar('alamat')));
            $jam = clear($this->request->getVar('jam'));
            $acara = upper_first(clear($this->request->getVar('acara')));
            $panitia = upper_first($this->request->getVar('panitia'));
            $telepon = clear($this->request->getVar('telepon'));
            $penjemputan = upper_first(clear($this->request->getVar('penjemputan')));
            $keterangan = upper_first(clear($this->request->getVar('keterangan')));

            $q['tgl'] = $tgl;
            $q['pasaran'] = $pasaran;
            $q['alamat'] = $alamat;
            $q['jam'] = $jam;
            $q['acara'] = $acara;
            $q['panitia'] = $panitia;
            $q['telepon'] = $telepon;
            $q['penjemputan'] = $penjemputan;
            $q['keterangan'] = $keterangan;
            $q['lagu'] = $lagu;
        } else {
            $q['lagu'] = $lagu;
        }

        $db->where('id', $id);
        if ($db->update($q)) {
            sukses($url, 'Data berhasil diupdate.');
        } else {
            gagal($url, 'Data gagal diupdate.');
        }
    }
    public function update_lagu()
    {

        $id = clear($this->request->getVar('id'));
        $values = json_decode(json_encode($this->request->getVar('values')), true);
        $lagu = clear($this->request->getVar('lagu'));


        $db = db(menu()['tabel'], get_db(menu()['tabel']));

        $q = $db->where('id', $id)->get()->getRowArray();

        if (!$q) {
            gagal_js('Id tidak ditemukan.');
        }


        $q['lagu'] = implode(",", $values);


        $db->where('id', $id);
        if ($db->update($q)) {
            sukses_js('Data berhasil diupdate.');
        } else {
            gagal_js('Data gagal diupdate.');
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
            sukses_js('Data berhasil dihapus.');
        } else {
            gagal_js('Data berhasil dihapus.');
        }
    }

    public function cetak($tahun, $bulan, $order)
    {
        $db = db(menu()['tabel'], get_db(menu()['tabel']));
        $q = $db->orderBy('tgl', 'ASC')->get()->getResultArray();

        $data = [];
        $bl_th = [];
        foreach ($q as $i) {
            if ($tahun == 'Semua' && $bulan == 'Semua') {
                $text = bulan(date('m', $i['tgl']))['bulan'] . '_' . date('Y', $i['tgl']);
                if (!in_array($text, $bl_th)) {
                    $bl_th[] = $text;
                }
                $i['bl_th'] = $text;
                $data[] = $i;
            } elseif ($tahun !== 'Semua' && $bulan !== 'Semua') {

                if (date('m', $i['tgl']) == $bulan && date('Y', $i['tgl']) == $tahun) {
                    $text = bulan(date('m', $i['tgl']))['bulan'] . '_' . date('Y', $i['tgl']);
                    if (!in_array($text, $bl_th)) {
                        $bl_th[] = $text;
                    }
                    $i['bl_th'] = $text;
                    $data[] = $i;
                }
            } elseif ($tahun == 'Semua' && $bulan !== 'Semua') {
                if (date('m', $i['tgl']) == $bulan) {
                    $text = bulan(date('m', $i['tgl']))['bulan'] . '_' . date('Y', $i['tgl']);
                    if (!in_array($text, $bl_th)) {
                        $bl_th[] = $text;
                    }
                    $i['bl_th'] = $text;
                    $data[] = $i;
                }
            } elseif ($tahun !== 'Semua' && $bulan == 'Semua') {
                if (date('Y', $i['tgl']) == $tahun) {
                    $text = bulan(date('m', $i['tgl']))['bulan'] . '_' . date('Y', $i['tgl']);
                    if (!in_array($text, $bl_th)) {
                        $bl_th[] = $text;
                    }
                    $i['bl_th'] = $text;
                    $data[] = $i;
                }
            }
        }

        $fix_data = [];
        $arr_bl_th = [];
        foreach ($bl_th as $i) {
            if (!in_array($i, $arr_bl_th)) {
                $arr_bl_th[] = $i;
                $temp_data = [];
                foreach ($data as $d) {
                    if ($d['bl_th'] == $i) {
                        $temp_data[] = $d;
                    }
                }
                $fix_data[] = ['bl_th' => $i, 'data' => $temp_data];
            }
        }
        if ($order == 'pdf') {
            $cols = ['id', 'tgl', 'pasaran', 'alamat', 'jam', 'acara', 'panitia', 'telepon', 'penjemputan', 'keterangan'];
            $set = [
                'mode' => 'utf-8',
                'format' => [215, 330],
                'orientation' => 'L'
            ];

            $mpdf = new \Mpdf\Mpdf($set);
            foreach ($fix_data as $i) {
                $i['logo'] = '<img width="80" src="berkas/menu/rebana.png" alt="Logo"/>';
                // dd($i);
                $html = view('rebana/cetak', ['data' => $i]);
                $mpdf->AddPage();
                $mpdf->WriteHTML($html);
            }
            $this->response->setHeader('Content-Type', 'application/pdf');
            $mpdf->Output('Jadwal_Rebana.pdf', 'I');
        } else {
            $cols = ['tgl', 'alamat', 'jam', 'acara', 'panitia', 'telepon', 'penjemputan', 'keterangan'];

            $filename = 'Jadwal_Rebana.xlsx';

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
                    $huruf++;
                    $val = $i[$c];
                    if ($c == 'tgl') {
                        $val = hari(date('l', $i['tgl']))['indo'] . ' ' . $i['pasaran'] . ', ' . date('d', $i['tgl']) . ' ' . bulan(date('m', $i['tgl']))['bulan'] . ' ' . date('Y', $i['tgl']);
                    }
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

    public function add_image()
    {
        $url = clear($this->request->getVar('url'));
        $folder = clear($this->request->getVar('folder'));
        add_image($_FILES['file'], $url, $folder);
    }
    public function delete_file()
    {
        $dir = clear($this->request->getVar('dir'));

        if (unlink($dir)) {
            sukses_js('File berhasil dihapus.');
        } else {
            gagal_js('File gagal dihapus.');
        }
    }
}
