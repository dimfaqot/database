<?php

namespace App\Controllers\Djana;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Inventaris extends BaseController
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
        return view('djana/' . menu()['controller'], ['judul' => menu()['menu'], 'data' => get_inventaris($tahun, $bulan)]);
    }

    public function update_kondisi()
    {

        $id = clear($this->request->getVar('id'));
        $val = clear($this->request->getVar('val'));
        $db = db('pesanan', get_db('pesanan'));

        $q = $db->where('id', $id)->get()->getRowArray();
        if (!$q) {
            gagal_js('Id tidak ditemukan.');
        }
        $q['kondisi'] = $val;

        $db->where('id', $id);
        if ($db->update($q)) {
            sukses_js('Data sukses diupdate.');
        } else {
            gagal_js('Data gagal diupdate.');
        }
    }

    public function cetak($order, $jwt)
    {
        $cols = ['tgl_lunas', 'barang', 'kondisi', 'harga'];
        $val = decode_jwt($jwt);

        $data = get_inventaris($val['tahun'], $val['bulan']);

        $judul = 'DATA INVENTARIS DJANA ' . ($val['tahun'] == 'All' ? 'SEMUA TAHUN ' : $val['tahun'] . ' ') . ($val['bulan'] == 'All' ? 'SEMUA BULAN.' : strtoupper(bulan($val['bulan'])['bulan']));


        if ($order == 'pdf') {
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
            $html = view('djana/cetak_inventaris', ['judul' => $judul, 'data' => $data['data'], 'logo' => $logo, 'jwt' => $jwt, 'cols' => $cols, 'total' => $data['keluar']]);
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
                    $sheet->setCellValue(substr($huruf, -1) . '1', upper_first(str_replace("_", " ", ($c == 'tgl_lunas' ? 'tgl' : $c))));
                } else {
                    $sheet->setCellValue('A' . substr($huruf, -1) . '1', upper_first(str_replace("_", " ", ($c == 'tgl_lunas' ? 'tgl' : $c))));
                }
            }

            $rows = 2;
            $huruf = 'Z';
            foreach ($data['data'] as $i) {
                foreach ($cols as $k => $c) {
                    $huruf++;
                    if ($k < 26) {
                        $sheet->setCellValue(substr($huruf, -1) . $rows, $i[($c == 'harga' ? 'jml_lunas' : $c)]);
                    } else {
                        $sheet->setCellValue('A' . substr($huruf, -1) . $rows, $i[($c == 'harga' ? 'jml_lunas' : $c)]);
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
