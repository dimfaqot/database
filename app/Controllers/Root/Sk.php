<?php


namespace App\Controllers\Root;

use App\Controllers\BaseController;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Sk extends BaseController
{

    function __construct()
    {
        helper('functions');
        if (!session('id')) {
            gagal(base_url('login'), 'Anda belum login.');
        }
        check_role();
    }

    public function index($sub, $tahun, $col, $asc)
    {
        $sub = str_replace("_", " ", $sub);
        $db = db('tahun');
        $tahun_sk = $db->select('tahun,rapat,penetapan,ketua_ypp,kop')->get()->getResultArray();

        $db = db('sk', 'karyawan');

        $db;
        if ($sub !== 'All') {
            $db->where('sub', $sub);
        }
        if ($tahun !== 'All') {
            $db->where('tahun', $tahun);
        }

        $res = $db->orderBy('updated_at', 'DESC')->get()->getResultArray();


        $short_by = ($asc == 'ASC' ? SORT_ASC : SORT_DESC);

        $keys = array_column($res, $col);
        array_multisort($keys, $short_by, $res);

        $tahuns = $db->groupBy('tahun')->orderBy('tahun', 'DESC')->get()->getResultArray();

        $subs = $db->groupBy('sub')->orderBy('sub', 'ASC')->get()->getResultArray();


        return view('root/' .  menu()['controller'] . '/sk', ['judul' => menu()['menu'] . ' ' . $sub, 'data' => $res, 'tahun' => $tahun_sk, 'tahuns' => $tahuns, 'subs' => $subs]);
    }

    //  add data ada di home method add_data_from_db


    public function detail($sub, $tahun, $col, $asc, $id)
    {

        $db = db(menu()['tabel'], 'karyawan');
        $q = $db->where('id', $id)->get()->getRowArray();
        if (!$q) {
            gagal(base_url(menu()['controller']) . '/' . $sub . '/' . $tahun . '/' . $col . '/'  . $asc, 'Id tidak ditemukan.');
        }

        $all_data = $db->where('no_id', $q['no_id'])->orderBy('tahun', 'ASC')->get()->getResultArray();

        return view('root/' . menu()['controller'] . '/detail_' . menu()['controller'], ['judul' => $q['nama'], 'data' => $q, 'all_data' => $all_data]);
    }


    public function copy()
    {

        $tahun = clear($this->request->getVar('tahun'));
        $id = clear($this->request->getVar('id'));
        $url = clear($this->request->getVar('url'));

        $db = db('sk', 'karyawan');
        $q = $db->where('id', $id)->get()->getRowArray(); //sk

        if (!$q) {
            gagal($url, 'Id tidak ditemukan.');
        }

        $th = db('tahun');
        $thn = $th->where('tahun', $tahun)->get()->getRowArray(); //tahun

        if ($thn) {
            $q['no_sk'] = last_sk($thn['penetapan']);
        } else {
            $tahun_from_sk = $db->where('tahun', $tahun)->get()->getRowArray();
            if ($tahun_from_sk) {
                $q['no_sk'] = last_sk($tahun_from_sk['penetapan']);
            } else {
                $q['no_sk'] = '';
            }
        }

        $q['tahun'] = $tahun;
        $q['created_at'] = time();
        $q['updated_at'] = time();
        $q['petugas'] = session('nama');


        unset($q['id']);

        if ($db->insert($q)) {
            sukses($url, 'Sk berhasil dicopy.');
        } else {
            gagal($url, 'Sk gagal dicopy.');
        }
    }
    public function update_no_sk()
    {
        $id = clear($this->request->getVar('id'));
        $value = clear($this->request->getVar('value'));

        $db = db('sk', 'karyawan');

        $q = $db->where('id', $id)->get()->getRowArray();

        if (!$q) {
            gagal_js('Id tidak ditemukan.');
        }

        $exist = $db->whereNotIn('id', [$id])->where('no_sk', $value)->get()->getRowArray();

        if ($exist) {
            gagal_js('No Sk suda ada.');
        }

        $q['no_sk'] = $value;
        $q['updated_at'] = time();
        $q['petugas'] = session('nama');

        $db->where('id', $id);
        if ($db->update($q)) {
            sukses_js('No. Sk sukses diupdate.');
        } else {
            gagal_js('No. Sk gagal diupdate.');
        }
    }
    public function update()
    {
        $id = clear($this->request->getVar('id'));
        $url = clear($this->request->getVar('url'));
        $tahun = clear($this->request->getVar('tahun'));
        $no_sk = strtoupper(clear($this->request->getVar('no_sk')));
        $no_id = clear($this->request->getVar('no_id'));
        $nama = clear($this->request->getVar('nama'));
        $ttl = upper_first(clear($this->request->getVar('ttl')));
        $pendidikan = clear($this->request->getVar('pendidikan'));
        $sub = clear($this->request->getVar('sub'));
        $jabatan = upper_first(clear($this->request->getVar('jabatan')));
        $tugas = upper_first(clear($this->request->getVar('tugas')));
        $diangkat = upper_first(clear($this->request->getVar('diangkat')));
        $rapat = upper_first(clear($this->request->getVar('rapat')));
        $penetapan = upper_first(clear($this->request->getVar('penetapan')));
        $jenis = upper_first(clear($this->request->getVar('jenis')));
        $ketua_ypp = clear($this->request->getVar('ketua_ypp'));
        $kop = strtolower(clear($this->request->getVar('kop')));


        $db = db('sk', 'karyawan');

        $q = $db->where('id', $id)->get()->getRowArray();
        if (!$q) {
            gagal(base_url(menu()['controller']) . '/' . $url, 'Id tidak ditemukan.');
        }

        $url = base_url(menu()['controller']) . '/dtl/' . $url . '/' . $id;

        $exist = $db->where('no_sk', $no_sk)->whereNotIn('id', [$id])->get()->getRowArray();

        if ($exist) {
            gagal($url, 'No. Sk sudah ada. ' . $exist['nama']);
        }

        $q['tahun'] = $tahun;
        $q['no_sk'] = $no_sk;
        $q['no_id'] = $no_id;
        $q['nama'] = $nama;
        $q['ttl'] = $ttl;
        $q['pendidikan'] = $pendidikan;
        $q['sub'] = $sub;
        $q['jabatan'] = $jabatan;
        $q['tugas'] = $tugas;
        $q['diangkat'] = $diangkat;
        $q['rapat'] = $rapat;
        $q['penetapan'] = $penetapan;
        $q['jenis'] = $jenis;
        $q['ketua_ypp'] = $ketua_ypp;
        $q['kop'] = $kop;
        $q['updated_at'] = time();
        $q['petugas'] = session('nama');

        $db->where('id', $id);
        if ($db->update($q)) {
            sukses($url, 'Data sukses diupdate.');
        } else {
            gagal($url, 'Data gagal diupdate.');
        }
    }


    public function delete()
    {
        $id = $this->request->getVar('id');

        $db = db(menu()['tabel'], 'karyawan');

        $q = $db->where('id', $id)->get()->getRowArray();

        if (!$q) {
            gagal_js('Id tidak ditemukan.');
        }

        $db->where('id', $id);
        if ($db->delete()) {
            sukses_js('Data berhasil dihapus.');
        } else {
            gagal_js('Data gagal dihapus.');
        }
    }

    public function cetak($order, $ttd, $jwt)
    {
        $ttd = ($ttd == 1 ? false : ($ttd == 2 ? true : ''));

        $cols = get_fields(menu()['tabel']);

        $set = [
            'mode' => 'utf-8',
            'format' => [215, 330],
            'orientation' => 'P',
            'margin-left' => 20,
            'margin-right' => 20,
            'margin-top' => -20,
            'margin-bottom' => 0,
        ];

        $mpdf = new \Mpdf\Mpdf($set);


        $decode_jwt = decode_jwt($jwt);

        $data = [];

        $db = db('sk', 'karyawan');

        if ($order == 'detailpdf' || $order == 'detailexcel') {
            $data = $db->where('no_id', $decode_jwt[0])->orderBy('tahun', 'ASC')->get()->getResultArray();
        } else {
            foreach ($decode_jwt as $i) {
                $q = $db->where('id', $i)->get()->getRowArray();

                if ($q) {
                    $data[] = $q;
                }
            }
        }

        $judul = 'Data Sk';
        if (count($data) == 1) {
            $judul = 'Sk ' . $data[0]['nama'];
        }
        if ($order == 'detailpdf' || $order == 'detailexcel') {
            $judul = 'Sk ' . $data[0]['nama'];
        }

        if ($order == 'pdf' || $order == 'single' || $order == 'detailpdf') {

            foreach ($data as $i) {
                $i['is_ttd'] = $ttd;
                $i['kop'] = '<img src="' .  'berkas/kop/' . $i['kop'] . '" alt="Kop"/>';
                $i['ttd'] = '<img width="100px" src="' .  'berkas/ttd/' . get_ttd($i['ketua_ypp']) . '" alt="Ttd"/>';
                $html = view('cetak/sk', ['judul' => $judul, 'data' => $i]);
                $mpdf->AddPage();
                $mpdf->WriteHTML($html);
            }

            $this->response->setHeader('Content-Type', 'application/pdf');
            $mpdf->Output($judul . '.pdf', 'I');
        } else {

            $filename = $judul . '.xlsx';

            $spreadsheet = new Spreadsheet();

            $sheet = $spreadsheet->getActiveSheet();

            $huruf = 'Z';

            foreach ($cols as $k => $c) {
                $huruf++;
                if ($k < 26) {
                    $sheet->setCellValue(substr($huruf, -1) . '1', upper_first(str_replace("_", " ", $c['col'])));
                } else {
                    $sheet->setCellValue('A' . substr($huruf, -1) . '1', upper_first(str_replace("_", " ", $c['col'])));
                }
            }

            $rows = 2;
            $huruf = 'Z';
            foreach ($data as $i) {
                foreach ($cols as $c) {
                    if ($c['tipe'] == 'file') {
                        $i[$c['col']] = base_url() . 'berkas/' . menu()['controller'] . '/' . $i[$c['col']];
                    }
                }
                foreach ($cols as $k => $c) {
                    $huruf++;
                    if ($k < 26) {
                        $sheet->setCellValue(substr($huruf, -1) . $rows, $i[$c['col']]);
                    } else {
                        $sheet->setCellValue('A' . substr($huruf, -1) . $rows, $i[$c['col']]);
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
}
