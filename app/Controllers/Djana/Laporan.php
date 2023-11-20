<?php

namespace App\Controllers\Djana;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Laporan extends BaseController
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
        return view('djana/' . menu()['controller'], ['judul' => menu()['menu'], 'data' => get_laporan($tahun, $bulan)]);
    }

    public function data_belum()
    {
        sukses_js('Koneksi sukses', get_data_belum(menu()['controller']));
    }
    public function add()
    {

        $url = clear($this->request->getVar('url'));
        $tgl_order = strtotime(clear($this->request->getVar('tgl_order')));
        $deadline = clear($this->request->getVar('deadline'));
        $barang = upper_first(clear($this->request->getVar('barang')));
        $penerima_order = clear($this->request->getVar('penerima_order'));
        $pemesan = upper_first(clear($this->request->getVar('pemesan')));
        $catatan_order = upper_first(clear($this->request->getVar('catatan_order')));

        if ($deadline == '-') {
            $deadline = 0;
        } else {
            $exp = explode("/", $deadline);
            $deadline = strtotime($exp[2] . '-' . $exp[1] . '-' . $exp[0]);
        }

        $data = [
            'tgl_order' => $tgl_order,
            'deadline' => $deadline,
            'barang' => $barang,
            'penerima_order' => $penerima_order,
            'pemesan' => $pemesan,
            'catatan_order' => $catatan_order
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

        $db = db(menu()['tabel'], get_db(menu()['tabel']));
        $url = clear($this->request->getVar('url'));
        $q = $db->where('id', $id)->get()->getRowArray();
        if (!$q) {
            gagal($url, 'Id tidak ditemukan.');
        }


        $tgl_order = strtotime(clear($this->request->getVar('tgl_order')));
        $is_inv = (clear($this->request->getVar('is_inv')) == 'on' ? 1 : 0);
        $deadline = clear($this->request->getVar('deadline'));
        $tgl_dp = clear($this->request->getVar('tgl_dp'));
        $tgl_lunas = clear($this->request->getVar('tgl_lunas'));
        $tgl = clear($this->request->getVar('tgl'));
        $barang = upper_first(clear($this->request->getVar('barang')));
        $penerima_order = clear($this->request->getVar('penerima_order'));
        $pemesan = upper_first(clear($this->request->getVar('pemesan')));

        $catatan_order = upper_first(clear($this->request->getVar('catatan_order')));
        $catatan_dp = upper_first(clear($this->request->getVar('catatan_dp')));
        $catatan_lunas = upper_first(clear($this->request->getVar('catatan_lunas')));
        $catatan = upper_first(clear($this->request->getVar('catatan')));

        $jml_dp = rp_to_int(clear($this->request->getVar('jml_dp')));
        $jml_lunas = rp_to_int(clear($this->request->getVar('jml_lunas')));
        $jml = rp_to_int(clear($this->request->getVar('jml')));

        $pj_order = clear($this->request->getVar('pj_order'));
        $pj_dp = clear($this->request->getVar('pj_dp'));
        $pj_lunas = clear($this->request->getVar('pj_lunas'));
        $penerima = clear($this->request->getVar('penerima'));

        $deadline = check_tgl($q['deadline'], $deadline);
        $tgl_dp = check_tgl($q['tgl_dp'], $tgl_dp);
        $tgl_lunas = check_tgl($q['tgl_lunas'], $tgl_lunas);
        $tgl = check_tgl($q['tgl'], $tgl);

        $q['is_inv'] = $is_inv;
        $q['tgl_order'] = $tgl_order;
        $q['deadline'] = $deadline;
        $q['pj_order'] = $pj_order;
        $q['tgl_dp'] = $tgl_dp;
        $q['jml_dp'] = $jml_dp;
        $q['pj_dp'] = $pj_dp;
        $q['tgl_lunas'] = $tgl_lunas;
        $q['jml_lunas'] = $jml_lunas;
        $q['pj_lunas'] = $pj_lunas;
        $q['tgl'] = $tgl;
        $q['jml'] = $jml;
        $q['penerima'] = $penerima;
        $q['barang'] = $barang;
        $q['penerima_order'] = $penerima_order;
        $q['pemesan'] = $pemesan;
        $q['catatan_order'] = $catatan_order;
        $q['catatan_dp'] = $catatan_dp;
        $q['catatan_lunas'] = $catatan_lunas;
        $q['catatan'] = $catatan;
        $q['updated_at'] = time();

        $db->where('id', $id);
        if ($db->update($q)) {
            sukses($url, 'Data berhasil diupdate.');
        } else {
            gagal($url, 'Data gagal diupdate.');
        }
    }
    public function selesai()
    {

        $id = clear($this->request->getVar('id'));

        $db = db(menu()['tabel'], get_db(menu()['tabel']));
        $q = $db->where('id', $id)->get()->getRowArray();
        if (!$q) {
            gagal_js('Id tidak ditemukan!.');
        }

        $q['selesai'] = ($q['selesai'] == 0 ? 1 : 0);
        $q['updated_at'] = time();

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

    public function cetak($order, $jwt)
    {
        $cols = ['tgl', 'barang', 'keluar', 'masuk', 'laba'];
        $val = decode_jwt($jwt);

        $data = get_laporan($val['tahun'], $val['bulan']);

        $judul = 'LAPORAN DJANA TAHUN ' . ($val['tahun'] == 'All' ? 'SEMUA TAHUN ' : $val['tahun'] . ' ') . ($val['bulan'] == 'All' ? 'SEMUA BULAN.' : strtoupper(bulan($val['bulan'])['bulan']));


        if ($order == 'pdf') {
            $saldo_bulan_lalu = get_saldo_bulan_lalu($val['tahun'], $val['bulan']);
            $set = [
                'mode' => 'utf-8',
                'format' => [215, 330],
                'orientation' => 'P',
                'margin-left' => 20,
                'margin-right' => 20,
                'margin-top' => 0,
                'margin-bottom' => 0,
            ];

            $mpdf = new \Mpdf\Mpdf($set);
            $logo = '<img width="80px" src="' .  'berkas/djana/logo.png" alt="Logo Djana"/>';
            $html = view('djana/cetak_laporan', ['judul' => $judul, 'data' => $data, 'logo' => $logo, 'jwt' => $jwt, 'cols' => $cols, 'saldo_bulan_lalu' => $saldo_bulan_lalu]);
            $mpdf->AddPage();
            $mpdf->WriteHTML($html);


            $this->response->setHeader('Content-Type', 'application/pdf');
            $mpdf->Output($judul . '.pdf', 'I');
        }

        if ($order == 'excel') {
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
            foreach ($data['data'] as $i) {
                foreach ($cols as $k => $c) {
                    $huruf++;
                    if ($k < 26) {
                        $sheet->setCellValue(substr($huruf, -1) . $rows, $i[$c]);
                    } else {
                        $sheet->setCellValue('A' . substr($huruf, -1) . $rows, $i[$c]);
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
