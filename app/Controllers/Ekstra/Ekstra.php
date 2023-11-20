<?php


namespace App\Controllers\Ekstra;

use App\Controllers\BaseController;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Ekstra extends BaseController
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
        $db = db('ekstra', get_db('ekstra'));
        $q = $db->orderBy('ekstra', 'ASC')->get()->getResultArray();

        return view('ekstra/' . menu()['controller'], ['judul' => menu()['menu'], 'data' => $q]);
    }

    public function add()
    {
        $ekstra = upper_first(clear($this->request->getVar('ekstra')));
        $singkatan = strtoupper(clear($this->request->getVar('singkatan')));
        $kepala = clear($this->request->getVar('kepala'));

        $data = [
            'ekstra' => $ekstra,
            'singkatan' => $singkatan,
            'kepala' => $kepala
        ];

        $db = db(menu()['tabel'], get_db(menu()['tabel']));

        if ($db->insert($data)) {
            sukses(base_url(menu()['controller']), 'Data berhasil dimasukkan.');
        } else {
            sukses(base_url(menu()['controller']), 'Data gagal dimasukkan.');
        }
    }

    public function update()
    {
        $id = clear($this->request->getVar('id'));
        $ekstra = upper_first(clear($this->request->getVar('ekstra')));
        $singkatan = strtoupper(clear($this->request->getVar('singkatan')));
        $kepala = $this->request->getVar('kepala');

        $url = base_url(menu()['controller']);

        $db = db(menu()['tabel'], menu()['tabel']);

        $q = $db->where('id', $id)->get()->getRowArray();

        if (!$q) {
            gagal($url, 'Id tidak ditemukan.');
        }

        $q['ekstra'] = $ekstra;
        $q['singkatan'] = $singkatan;
        $q['kepala'] = $kepala;


        $db->where('id', $id);
        if ($db->update($q)) {
            sukses($url, 'Data berhasil diupdate.');
        } else {
            sukses($url, 'Data gagal diupdate.');
        }
    }


    public function cetak($order, $jwt)
    {
        $decode_jwt = decode_jwt($jwt);

        $db = db('nilai', get_db('nilai'));

        $data = [];
        foreach ($decode_jwt as $i) {

            $q = $db->where('kode', $i)->get()->getResultArray();
            $img1 = 'berkas/ekstra/sertifikat1.jpg';
            $img2 = 'berkas/ekstra/sertifikat2.jpg';

            if ($q) {
                $q[0]['link_qr_code'] = $q[0]['qr_code'];
                $q[0]['qr_code'] = '<img width="80px" src="' .  $q[0]['qr_code'] . '" alt="QR CODE"/>';
            }
            $data[] = ['bg_img' => $img1, 'data' => $q, 'profile' => ($q ? $q[0] : [])];
            $data[] = ['bg_img' => $img2, 'data' => $q, 'profile' => ($q ? $q[0] : [])];
        }

        $judul = 'Data Sertifikat Ekstra';
        if (count($decode_jwt) == 1) {
            $judul = 'Sertifikat Ekstra ' . $data[0]['profile']['ekstra'] . ' ' . $data[0]['profile']['nama'];
        }

        if ($order == 'pdf' || $order == 'single') {
            $set = [
                'mode' => 'utf-8',
                'format' => 'A4',
                'orientation' => 'P',
                'margin-left' => 20,
                'margin-right' => 20,
                'margin-top' => -0,
                'margin-bottom' => 0
            ];

            $mpdf = new \Mpdf\Mpdf($set);
            $mpdf->useSubstitutions = false;

            foreach ($data as $k => $i) {
                $html = view('cetak/' . menu()['controller'], ['judul' => $judul, 'data' => $i, 'k' => $k]);
                $mpdf->AddPage();

                $img = 'berkas/ekstra/sertifikat' . ($k % 2 == 0 ? '1' : '2') . '.jpg';
                $mpdf->SetDefaultBodyCSS('background', "url(" . $img . ")");
                $mpdf->SetDefaultBodyCSS('background-image-resize', 6);
                $mpdf->WriteHTML($html);
                $html = view('cetak/' . menu()['controller'], ['judul' => $judul, 'data' => $i]);
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

        $db = db(menu()['tabel'], menu()['tabel']);

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
