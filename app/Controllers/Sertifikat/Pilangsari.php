<?php


namespace App\Controllers\Sertifikat;

use App\Controllers\BaseController;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Pilangsari extends BaseController
{


    function __construct()
    {
        helper('functions');
        if (!session('id')) {
            gagal(base_url('login'), 'Anda belum login.');
        }
        check_role();
    }

    public function index($kategori, $page, $col, $asc, $jenis)
    {

        $db = db('pilangsari', get_db('pilangsari'));

        $limit = 0;
        $db;

        if ($jenis == 'Kosong') {
            $res = $db->where('kategori', '')->where('pj', '')->get()->getResultArray();
        } else {
            if ($kategori !== 'All') {
                $db->where('kategori', upper_first(str_replace("_", " ", $kategori)));
            }
            if ($jenis !== 'All') {
                $db->where('jenis', $jenis);
            }
            if ($page !== 'All') {
                $limit = $page * 100;
                $db->limit($limit);
            }
            $res = $db->orderBy('updated_at', 'ASC')->get()->getResultArray();
        }

        $db;
        if ($jenis == 'Kosong') {
            $total = $db->where('kategori', '')->where('pj', '')->countAllResults();
        } else {
            if ($kategori !== 'All') {
                $db->where('kategori', upper_first(str_replace("_", " ", $kategori)));
            }
            if ($jenis !== 'All') {
                $db->where('jenis', $jenis);
            }

            $total = $db->countAllResults();
        }

        $lunas = $db->where('jenis', 'SSJ')->where('ket', 1)->countAllResults();
        $belum = $db->where('jenis', 'SSJ')->where('ket', 0)->countAllResults();
        $q_non_ssj = $db->where('jenis', 'NONSSJ')->get()->getResultArray();

        $non_ssj = 0;

        foreach ($q_non_ssj as $i) {
            $non_ssj += $i['jml_uang'];
        }

        $short_by = ($asc == 'ASC' ? SORT_ASC : SORT_DESC);

        $keys = array_column($res, $col);
        array_multisort($keys, $short_by, $res);


        $data = [
            'status' => '200',
            'total_data' => $total,
            'data_ditampilkan' => ($limit == 0 ? $total : ($total < $limit ? $total : $limit)),
            'lunas' => $lunas,
            'belum' => $belum,
            'seluruh_data' => $lunas + $belum,
            'data' => $res
        ];


        return view('sertifikat/' . menu()['controller'], ['judul' => menu()['menu'], 'data' => $data, 'non_ssj' => $non_ssj]);
    }

    public function laporan()
    {
        $db = db('pilangsari', get_db('pilangsari'));

        $data = [];

        $jenis = ['SSJ', 'NONSSJ', 'Kosong'];
        foreach ($jenis as $j) {
            $kategori = [];

            if ($j == 'Kosong') {
                $kategori = $db->where('jenis', 'SSJ')->where('kategori', "")->where('pj', '')->groupBy('kategori')->get()->getResultArray();
            } elseif ($j == 'SSJ') {
                $kategori = $db->where('jenis', $j)->whereNotIn('kategori', [''])->groupBy('kategori')->get()->getResultArray();
            } else {
                $kategori = $db->where('jenis', $j)->groupBy('kategori')->get()->getResultArray();
            }

            foreach ($kategori as $i) {
                $jml = 0;
                if ($j == 'Kosong') {
                    $jml = $db->where('jenis', 'SSJ')->where('kategori', "")->where('pj', '')->countAllResults();
                    $data[] = ['jenis' => $j, 'kategori' => $i['kategori'], 'jumlah' => $jml, 'total' => $jml * 350000, 'total_rp' => rupiah($jml * 350000)];
                } elseif ($j == 'NONSSJ') {
                    $q = $db->where('jenis', $j)->where('kategori', $i['kategori'])->get()->getResultArray();

                    $total = 0;

                    foreach ($q as $t) {
                        $total += $t['jml_uang'];
                    }
                    $data[] = ['jenis' => $j, 'kategori' => $i['kategori'], 'jumlah' => count($q), 'total' => $total, 'total_rp' => rupiah($total)];
                } else {
                    $jml_lunas = $db->where('jenis', $j)->where('kategori', $i['kategori'])->where('ket', 1)->whereNotIn('kategori', [''])->countAllResults();
                    $jml_belum = $db->where('jenis', $j)->where('kategori', $i['kategori'])->where('ket', 0)->whereNotIn('kategori', [''])->countAllResults();

                    $data[] = ['jenis' => $j, 'kategori' => $i['kategori'], 'jml_lunas' => $jml_lunas, 'jml_belum' => $jml_belum];
                }
            }
        }

        sukses_js('Koneksi sukses.', $data);
    }

    public function add()
    {
        $url = clear($this->request->getVar('url'));
        $kategori = clear($this->request->getVar('kategori'));
        $jenis = clear($this->request->getVar('jenis'));
        $pj = clear($this->request->getVar('pj'));
        $alamat = clear($this->request->getVar('alamat'));
        $nama = clear($this->request->getVar('nama'));
        $jml_uang = rp_to_int(clear($this->request->getVar('jml_uang')));


        if ($jenis !== 'NONSSJ') {
            gagal($url, 'Jenis harus NONSSJ.');
        }

        $db = db('pilangsari', get_db('pilangsari'));
        $no = 4000;

        $q = $db->where('jenis', 'NONSSJ')->orderBy('no', 'DESC')->get()->getRowArray();

        if ($q) {
            $no = $q['no'] + 1;
        }

        $data = [
            'no' => $no,
            'kategori' => $kategori,
            'jenis' => $jenis,
            'pj' => $pj,
            'alamat' => $alamat,
            'nama' => $nama,
            'jml_uang' => $jml_uang,
            'created_at' => time(),
            'updated_at' => time(),
            'petugas' => session('nama')
        ];

        if ($db->insert($data)) {
            sukses($url, 'Data sukses diinput');
        } else {
            gagal($url, 'Data gagal diinput');
        }
    }
    // public function add()
    // {
    //     $tahun = clear($this->request->getVar('tahun'));
    //     $jenis = str_replace("_", " ", clear($this->request->getVar('jenis')));
    //     $kategori = clear($this->request->getVar('kategori'));
    //     $nama = upper_first(clear($this->request->getVar('nama')));
    //     $pembawa = upper_first(clear($this->request->getVar('pembawa')));
    //     $alamat = upper_first(clear($this->request->getVar('alamat')));
    //     $url = clear($this->request->getVar('url'));

    //     $time = time();

    //     $data = [
    //         'tahun' => $tahun,
    //         'tgl' => $time,
    //         'no_surat' => last_no_jariyah($time, $jenis),
    //         'jenis' => $jenis,
    //         'kategori' => $kategori,
    //         'pembawa' => $pembawa,
    //         'nama' => $nama,
    //         'alamat' => $alamat,
    //         'ket' => 0,
    //         'created_at' => time(),
    //         'updated_at' => time(),
    //         'petugas' => session('nama')
    //     ];

    //     $db = db(menu()['tabel'], get_db(menu()['tabel']));

    //     if ($db->insert($data)) {
    //         $last_id = $db->get()->getLastRow()->{'id'};

    //         $q = $db->where('no', $last_id)->get()->getRowArray();
    //         $data = [$last_id];
    //         $link = base_url('public') . '/' . get_db(menu()['tabel']) . '/' . menu()['tabel'] . '/id/' . encode_jwt($data);

    //         $q['qr_code'] = get_qr_code($link);

    //         $db->where('no', $last_id);
    //         if ($db->update($q)) {
    //             sukses($url, 'Data berhasil dimasukkan.');
    //         } else {
    //             gagal($url, 'Qc code gagal dibuat');
    //         }
    //     } else {
    //         sukses($url, 'Data gagal dimasukkan.');
    //     }
    // }
    public function update()
    {
        $id = clear($this->request->getVar('id'));
        $no = clear($this->request->getVar('no'));
        $pj = clear($this->request->getVar('pj'));
        $nama = clear($this->request->getVar('nama'));
        $kategori = clear($this->request->getVar('kategori'));
        $alamat = clear($this->request->getVar('alamat'));
        $ket = clear($this->request->getVar('ket'));
        $url = clear($this->request->getVar('url'));


        $db = db(menu()['tabel'], get_db(menu()['tabel']));

        $q = $db->where('no', $id)->get()->getRowArray();

        if (!$q) {
            gagal($url, 'Id tidak ditemukan.');
        }

        $exist = $db->whereNotIn('id', [$id])->where('no', $no)->get()->getRowArray();
        if ($exist) {
            gagal($url, 'No. surat sudah ada.');
        }


        $q['pj'] = $pj;
        $q['nama'] = $nama;
        $q['no'] = $no;
        $q['kategori'] = $kategori;
        $q['alamat'] = $alamat;
        $q['ket'] = $ket;
        $q['updated_at'] = time();
        $q['petugas'] = session('nama');


        $db->where('no', $id);
        if ($db->update($q)) {
            sukses($url, 'Data berhasil diupdate.');
        } else {
            sukses($url, 'Data gagal diupdate.');
        }
    }

    public function add_blur()
    {
        $col = clear($this->request->getVar('col'));
        $key = clear($this->request->getVar('key'));
        $tabel = clear($this->request->getVar('tabel'));
        $db = clear($this->request->getVar('db'));
        $val = clear($this->request->getVar('val'));


        $db = db($tabel, $db);


        $data = [
            'kategori' => $key,
            'value' => $val
        ];

        if ($tabel == 'options') {
            $q = $db->orderBy('no_urut', 'DESC')->get()->getRowArray();
            $data['no_urut'] = $q['no_urut'] + 1;
        }


        if ($db->insert($data)) {
            sukses_js('Data berhasil diinput.');
        } else {
            sukses_js('Data gagal diinput.');
        }
    }

    public function update_blur()
    {
        $id = clear($this->request->getVar('id'));
        $col = clear($this->request->getVar('col'));
        $db = clear($this->request->getVar('db'));
        $tabel = clear($this->request->getVar('tabel'));
        $val = ($col == 'pj' || $col == 'nama' ? $this->request->getVar('val') : clear($this->request->getVar('val')));


        $db = db($tabel, $db);

        $q = $db->where(($tabel == 'pilangsari' ? 'no' : 'id'), $id)->get()->getRowArray();

        if (!$q) {
            gagal_js('Id tidak ditemukan.');
        }

        $q[$col] = ($col == 'jml_uang' ? rp_to_int($val) : $val);

        $db->where(($tabel == 'pilangsari' ? 'no' : 'id'), $id);
        if ($db->update($q)) {
            sukses_js('Data berhasil diupdate.');
        } else {
            sukses_js('Data gagal diupdate.');
        }
    }
    public function update_ket()
    {
        $id = clear($this->request->getVar('id'));


        $db = db('pilangsari', get_db('pilangsari'));

        $q = $db->where('no', $id)->get()->getRowArray();

        if (!$q) {
            gagal_js('Id tidak ditemukan.');
        }

        $q['ket'] = ($q['ket'] == 0 ? 1 : 0);

        $db->where('no', $id);
        if ($db->update($q)) {
            sukses_js('Data berhasil diupdate.');
        } else {
            sukses_js('Data gagal diupdate.');
        }
    }
    public function update_kategori()
    {
        $id = clear($this->request->getVar('id'));
        $val = clear($this->request->getVar('val'));


        $db = db('pilangsari', get_db('pilangsari'));

        $q = $db->where('no', $id)->get()->getRowArray();

        if (!$q) {
            gagal_js('Id tidak ditemukan.');
        }

        $q['kategori'] = $val;

        $db->where('no', $id);
        if ($db->update($q)) {
            sukses_js('Data berhasil diupdate.');
        } else {
            sukses_js('Data gagal diupdate.');
        }
    }

    public function cetak_data($jenis, $kategori, $order, $format)
    {

        if ($kategori == 'All') {
            gagal(base_url(menu()['controller']) . '/Karyawan/1/updated_at/ASC', 'Kategori tidak boleh ALl');
        }

        $judul = 'Data SSJ Pilangsari ' . ($order == 'all' ? '' : ($order == 'non' ? 'NONSSJ' : ($order == 'belum' ? 'BELUM LUNAS' : $order)));
        $cols = get_fields('pilangsari', 'sertifikat');
        $db = db('pilangsari', 'sertifikat');
        $db;

        if ($order == 'non') {
            $db->where('jenis', 'NONSSJ');
        } else {

            if ($jenis == 'SSJ') {
                $db->where('kategori', $kategori);
                if ($order !== 'all') {
                    $db->where('ket', ($order == 'lunas' ? 1 : 0));
                }
            }

            if ($jenis == 'Kosong') {
                $db->where('kategori', '')->where('pj', '');
            }
        }


        $q = $db->orderBy('no', 'ASC')->orderBy('kategori', 'ASC')->orderBy('pj', 'ASC')->orderBy('nama', 'ASC')->orderBy('ket', 'DESC')->get()->getResultArray();

        if ($format == 'pdf') {
            $set = [
                'mode' => 'utf-8',
                'format' => [215, 330],
                'orientation' => 'P',
                'margin-left' => 20,
                'margin-right' => 20,
                'margin-top' => -0,
                'margin-bottom' => 0
            ];

            $mpdf = new \Mpdf\Mpdf($set);




            $db->where('kategori', $kategori);
            if ($order !== 'all') {
                $db->where('ket', 1);
            }
            $lunas = $db->countAllResults();

            $db->where('kategori', $kategori);
            if ($order !== 'all') {
                $db->where('ket', 0);
            }
            $belum = $db->countAllResults();

            $html = view('cetak/data_pilangsari', ['judul' => $judul, 'data' => $q, 'cols' => $cols, 'lunas' => $lunas, 'belum' => $belum, 'order' => $order]);
            $mpdf->AddPage();
            $mpdf->WriteHTML($html);

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
            foreach ($q as $i) {
                foreach ($cols as $k => $c) {
                    $val = $i[$c];

                    if ($c == 'qr_code' && $i['qr_code'] !== '') {
                        $val = base_url() . $i['link_qr_code'];
                    }
                    if ($c == 'tgl') {
                        $val = date('d/m/Y', $val);
                    }
                    if ($c == 'ket') {
                        $val = ($i['ket'] == 1 ? 'Lunas' : 'Belum');
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
    public function cetak($order, $jwt)
    {
        $decode_jwt = decode_jwt($jwt);

        $db = db(menu()['tabel'], get_db(menu()['tabel']));


        $data = [];
        foreach ($decode_jwt as $i) {

            $q = $db->where('no', $i)->get()->getRowArray();

            $q['link_qr_code'] = $q['qr_code'];
            $q['qr_code'] = '<img width="100px" src="' .  $q['qr_code'] . '" alt="QR CODE"/>';
            $q['img'] = 'berkas/sertifikat/Pilangsari.jpg';
            $data[] = $q;
        }

        $judul = 'Data SSJ' . menu()['menu'];
        if (count($data) == 1) {
            $judul = 'SSJ ' . $data[0]['nama'];
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

        $q = $db->where('no', $id)->get()->getRowArray();

        if (!$q) {
            gagal_js('Id tidak ditemukan.');
        }
        if ($q['jenis'] !== 'NONSSJ') {
            gagal_js('Hanya NONSSJ yang bisa dihapus.');
        }


        $db->where('no', $id);
        if ($db->delete()) {
            sukses_js('Data berhasil didelete.');
        } else {
            gagal_js('Data gagal didelete.');
        }
    }
}
