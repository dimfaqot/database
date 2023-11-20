<?php


namespace App\Controllers\Root;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Santri extends BaseController
{
    function __construct()
    {
        helper('functions');
        if (!session('id')) {
            gagal(base_url('login'), 'Anda belum login.');
        }
        check_role();
    }

    public function index($tahun, $filter, $page, $sub, $col, $asc, $status, $gender)
    {

        $db = db(menu()['tabel'], get_db(menu()['tabel']));

        $limit = 0;
        $db->select('no_id,nama,gender,status,tahun_masuk,tahun_keluar,pondok,tgl_lahir,sub,hp_ayah,updated_at,deleted');

        if ($filter !== 'All') {
            $filt = 0;
            if ($filter == 'Deleted') {
                $filt = 1;
            }

            $db->where('deleted', $filt);
        }

        if ($tahun !== 'All') {
            $db->where('tahun_masuk', $tahun);
        }
        if ($sub !== 'All') {
            $db->where('sub', $sub);
        }
        if ($status !== 'All') {
            $db->where('status', $status);
        }
        if ($gender !== 'All') {
            $db->where('gender', $gender);
        }

        if ($page !== 'All') {
            $limit = $page * 50;
            $db->limit($limit);
        }

        $q = $db->get()->getResultArray();

        $db;
        if ($tahun !== 'All') {
            $db->where('tahun_masuk', $tahun);
        }
        if ($sub !== 'All') {
            $db->where('sub', $sub);
        }
        if ($status !== 'All') {
            $db->where('status', $status);
        }
        if ($gender !== 'All') {
            $db->where('gender', $gender);
        }
        if ($filter !== 'All') {
            $filt = 0;
            if ($filter == 'Deleted') {
                $filt = 1;
            }

            $db->where('deleted', $filt);
        }

        $total = $db->countAllResults();

        $res = [];
        foreach ($q as $i) {
            $i['umur'] = umur($i['tgl_lahir']);
            $i['pengabdian'] = ($i['tahun_keluar'] == 0 ? date('Y') : $i['tahun_keluar']) - $i['tahun_masuk'];

            $res[] = $i;
        }

        $short_by = ($asc == 'ASC' ? SORT_ASC : SORT_DESC);

        $keys = array_column($res, $col);
        array_multisort($keys, $short_by, $res);


        $data = [
            'status' => '200',
            'total_data' => $total,
            'data_ditampilkan' => ($limit == 0 ? $total : ($total < $limit ? $total : $limit)),
            'data' => $res
        ];

        return view('root/' . menu()['controller'] . '/' . menu()['controller'], ['judul' => menu()['menu'], 'data' => $data]);
    }

    public function add()
    {
        $tahun_masuk = clear($this->request->getVar('tahun_masuk'));
        $nama = upper_first(clear($this->request->getVar('nama')));
        $gender = clear($this->request->getVar('gender'));
        $sub = clear($this->request->getVar('sub'));
        $pondok = clear($this->request->getVar('pondok'));
        $hp_ayah = clear($this->request->getVar('hp_ayah'));
        $url = clear($this->request->getVar('url'));

        $db = db(menu()['tabel'], get_db(menu()['tabel']));
        $exp = explode("/", $url);
        $url = base_url(menu()['controller']) . '/' . $exp[4] . '/' . $exp[5] . '/' . $exp[6] . '/' . $sub . '/' . $exp[8] . '/' . $exp[9] . '/' . $exp[10] . '/' . $exp[11];

        $data = file_santri();
        $data['no_id'] = last_no_id_santri($tahun_masuk, $sub);
        $data['tahun_masuk'] = $tahun_masuk;
        $data['nama'] = $nama;
        $data['gender'] = $gender;
        $data['pendapatan'] = options('Pendapatan')[0]['value'];
        $data['infaq'] = options('Infaq')[0]['value'];
        $data['pondok'] = $pondok;
        $data['hp_ayah'] = $hp_ayah;
        $data['tempat_pendaftaran'] = 'Induk';
        $data['ket_pendaftaran'] = 'Menunggu';
        $data['sub'] = $sub;
        $data['tgl_lahir'] = time();
        $data['status'] = 'Aktif';
        $data['created_at'] = time();
        $data['updated_at'] = time();
        $data['petugas'] = session('nama');

        if ($db->insert($data)) {
            sukses($url, 'Data sukses ditambahkan.');
        } else {
            gagal($url, 'Data gagal ditambahkan.');
        }
    }


    public function detail($tahun, $filter, $page, $sub, $col, $asc, $status, $gender, $no_id, $sub_menu)
    {

        $db = db(menu()['tabel'], get_db(menu()['tabel']));
        $exist = $db->where('no_id', $no_id)->get()->getRowArray();

        if (!$exist) {
            gagal(base_url(menu()['controller']) . '/' . $tahun . '/' . $filter . '/' . $page . '/' . $sub . '/' . $col . '/' . $asc . '/' . $status . '/' . $gender, 'Id tidak ditemukan.');
        }

        $select = 'no_id,nisn,no_induk,nik,nama,gender,email,hp,kota_lahir,tgl_lahir';

        if ($sub_menu == 'Alamat') {
            $select = 'nama,no_id,alamat,provinsi,kabupaten,kecamatan,kelurahan,kode_pos';
        }
        if ($sub_menu == 'Riwayat') {
            $select = 'nama,no_id,sekolah_asal,alamat_sekolah_asal,tempat_pendaftaran,ket_pendaftaran,tahun_masuk,sub,pondok,status,tahun_keluar';
        }

        if ($sub_menu == 'Perwalian') {
            $select = 'nama,no_id,pendapatan,infaq,no_kk,nama_ayah,nik_ayah,pekerjaan_ayah,hp_ayah,nama_ibu,nik_ibu,pekerjaan_ibu,hp_ibu,nama_wali,hp_wali,alamat_wali';
        }

        if ($sub_menu == 'Keluarga') {
            $select = 'nama,no_id,keluarga';
        }
        if ($sub_menu == 'Ekonomi') {
            $select = 'nama,no_id,ekonomi';
        }

        if ($sub_menu == 'Kesehatan') {
            $select = 'nama,no_id,kesehatan';
        }
        if ($sub_menu == 'Karakter') {
            $select = 'nama,no_id,karakter';
        }
        if ($sub_menu == 'Catatan') {
            $select = 'nama,no_id,catatan';
        }

        if ($sub_menu == 'Berkas') {
            $select = 'nama,no_id,' . implode(",", array_keys(file_santri()));
        }

        $q = $db->select($select)->where('no_id', $no_id)->get()->getRowArray();

        if ($sub_menu == 'Profile') {
            $q['tgl_lahir'] = date('Y-m-d', $q['tgl_lahir']);
        }

        return view('root/' . menu()['controller'] . '/detail_' . menu()['controller'], ['judul' => $sub_menu . ' ' . $q['nama'], 'data' => $q, 'cols' => explode(",", $select)]);
    }

    public function update()
    {

        $sub_menu = clear($this->request->getVar('sub_menu'));
        $cols = clear($this->request->getVar('cols'));
        $url = clear($this->request->getVar('url'));
        $id = clear($this->request->getVar('id'));
        $db = db(menu()['tabel'], get_db(menu()['tabel']));
        $q = $db->where('no_id', $id)->get()->getRowArray();
        if (!$q) {
            gagal($url, 'Id tidak ditemukan.');
        }

        $url .= '/' . $id . '/' . $sub_menu;


        if ($sub_menu == 'Berkas') {

            $file = $_FILES['file'];

            upload($file, $q, $cols, $url);
        }

        $arr_cols = explode(",", $cols);

        foreach ($arr_cols as $i) {

            if ($sub_menu !== 'Profile') {
                if ($i == 'nama' || $i == 'no_id') {
                    continue;
                }
            }
            if ($i == 'no_id') {
                $val = clear($this->request->getVar($i));
                $x = $db->whereNotIn('no_id', [$id])->where('no_id', $val)->get()->getRowArray();
                if ($x) {
                    gagal($url, 'No. id sudah ada.');
                }
                $q[$i] = ($val == '' || $val == '' ? $q[$i] : $val);
            }
            if ($i == 'kota_lahir' || $i == 'alamat' || $i == 'kelurahan' || $i == 'kecamatan' || $i == 'kabupaten' || $i == 'provinsi' || $i == 'kampus_s1' || $i == 'fakultas_s1' || $i == 'jurusan_s1' || $i == 'kampus_s2' || $i == 'fakultas_s2' || $i == 'jurusan_s2' || $i == 'kampus_s3' || $i == 'fakultas_s3' || $i == 'jurusan_s3') {
                $q[$i] = (upper_first(clear($this->request->getVar($i))) == '' ? $q[$i] : upper_first(clear($this->request->getVar($i))));
            } elseif ($i == 'nama') {
                $q[$i] = (upper_first($this->request->getVar($i))) == '' ? $q[$i] : upper_first($this->request->getVar($i));
            } elseif ($i == 'email') {
                $q[$i] = (strtolower(clear($this->request->getVar($i))) == '' ? $q[$i] : strtolower(clear($this->request->getVar($i))));
            } elseif ($i == 'hp') {
                if (strlen(clear($this->request->getVar($i))) < 10 && clear($this->request->getVar($i) !== '')) {
                    gagal($url, 'No. Hp tidak valid.');
                }
                $q[$i] = (clear($this->request->getVar($i)) == '' ? $q[$i] : clear($this->request->getVar($i)));
            } elseif ($i == 'ipk_s1' || $i == 'ipk_s2' || $i == 'ipk_s3') {
                if (clear($this->request->getVar($i)) > 4.00) {
                    gagal($url, 'Ipk maksimal 4.00.');
                }
                $q[$i] = (clear($this->request->getVar($i)) == '' ? $q[$i] : clear($this->request->getVar($i)));
            } elseif ($i == 'gelar_s1' || $i == 'gelar_s2' || $i == 'gelar_s3') {

                $q[$i] = trim(trim(trim($this->request->getVar($i), '.'), ','), '.');
            } elseif ($i == 'kode_pos') {
                if (strlen(clear($this->request->getVar($i))) !== 5 && clear($this->request->getVar($i) > 0)) {
                    gagal($url, 'Kode pos tidak valid.');
                }
                $q[$i] = (clear($this->request->getVar($i)) == '' ? $q[$i] : clear($this->request->getVar($i)));
            } elseif ($i == 'tahun_masuk') {
                if (strlen(clear($this->request->getVar($i))) !== 4) {
                    gagal($url, 'Tahun tidak valid.');
                }
                $q[$i] = (clear($this->request->getVar($i)) == '' ? $q[$i] : clear($this->request->getVar($i)));
            } elseif ($i == 'catatan' || $i == 'ekonomi' || $i == 'kesehatan' || $i == 'karakter' || $i == 'keluarga') {
                $q[$i] = $this->request->getVar($i);
            } elseif ($i == 'tgl_lahir') {
                $q[$i] = (strtotime(clear($this->request->getVar($i))) == '' ? $q[$i] : strtotime(clear($this->request->getVar($i))));
            } else {
                $q[$i] = (clear($this->request->getVar($i))) == '' ? $q[$i] : clear($this->request->getVar($i));
            }
        }
        $q['updated_at'] = time();
        $q['petugas'] = session('nama');


        $db->where('no_id', $id);
        if ($db->update($q)) {
            sukses($url, 'Data sukses diupdate.');
        } else {
            gagal($url, 'Data gagal diupdate.');
        }
    }

    public function remove()
    {
        $id = $this->request->getVar('id');

        $db = db(menu()['tabel'], get_db(menu()['tabel']));

        $q = $db->where('no_id', $id)->get()->getRowArray();

        if (!$q) {
            gagal_js('Id tidak ditemukan.');
        }


        $q['deleted'] = 1;
        $db->where('no_id', $id);
        if ($db->update($q)) {
            sukses_js('Data berhasil diremove.');
        } else {
            gagal_js('Data gagal diremove.');
        }
    }
    public function restore()
    {
        $id = $this->request->getVar('id');

        $db = db(menu()['tabel'], get_db(menu()['tabel']));

        $q = $db->where('no_id', $id)->get()->getRowArray();

        if (!$q) {
            gagal_js('Id tidak ditemukan.');
        }


        $q['deleted'] = 0;
        $db->where('no_id', $id);
        if ($db->update($q)) {
            sukses_js('Data berhasil direstore.');
        } else {
            gagal_js('Data gagal direstore.');
        }
    }
    public function delete()
    {
        $id = $this->request->getVar('id');

        $db = db(menu()['tabel'], get_db(menu()['tabel']));

        $q = $db->where('no_id', $id)->get()->getRowArray();

        if (!$q) {
            gagal_js('Id tidak ditemukan.');
        }

        $db->where('no_id', $id);
        if ($db->delete()) {
            $keys = array_keys(file_santri());
            foreach ($keys as $i) {
                if ($q[$i] !== 'file_not_found.jpg') {
                    $dir = 'berkas/' . menu()['controller'] . '/';
                    unlink($dir . $q[$i]);
                }
            }
            sukses_js('Data berhasil didelete.');
        } else {
            gagal_js('Data gagal didelete.');
        }
    }

    public function cetak($tahun, $filter, $page, $sub, $col, $asc, $status, $gender, $order)
    {
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

        $db = db(menu()['tabel'], get_db(menu()['tabel']));



        if ($tahun == 'single') {
            $q = $db->where('no_id', $filter)->get()->getResultArray();
            if (count($q) == 0) {
                gagal(base_url(menu()['controller']) . '/' . tahun_santri(menu()['controller']) . '/Existing/1/' . $sub . '/' . $col . '/' . $asc . '/' . $status . '/' . $gender, 'Id tidak ditemukan.');
            }
            foreach ($q as $i) {
                $i['img_profile'] = '<img width="200px" src="' .  'berkas/' . menu()['controller'] . '/' . $i['profile'] . '" alt="Profile"/>';
                $html = view('cetak/profile', ['judul' => $i['nama'], 'data' => $i, 'cols' => $cols]);
                $mpdf->AddPage();
                $mpdf->WriteHTML($html);
            }
            $this->response->setHeader('Content-Type', 'application/pdf');
            $mpdf->Output($i['nama'] . '.pdf', 'I');

            die;
        }


        $limit = 0;
        $db;
        if ($page !== 'All') {
            $limit = $page * 50;
            $db->limit($limit);
        }
        if ($filter !== 'All') {
            $filt = 0;
            if ($filter == 'Deleted') {
                $filt = 1;
            }

            $db->where('deleted', $filt);
        }

        if ($tahun !== 'All') {
            $db->where('tahun_masuk', $tahun);
        }
        if ($sub !== 'All') {
            $db->where('sub', $sub);
        }
        if ($status !== 'All') {
            $db->where('status', $status);
        }
        if ($gender !== 'All') {
            $db->where('gender', $gender);
        }

        $q = $db->get()->getResultArray();


        $res = [];
        foreach ($q as $i) {
            $i['umur'] = umur($i['tgl_lahir']);
            $i['pengabdian'] = ($i['tahun_keluar'] == 0 ? date('Y') : $i['tahun_keluar']) - $i['tahun_masuk'];

            $res[] = $i;
        }


        $short_by = ($asc == 'ASC' ? SORT_ASC : SORT_DESC);

        $keys = array_column($res, $col);
        array_multisort($keys, $short_by, $res);




        if ($order == 'pdf') {

            foreach ($res as $i) {
                // foreach ($cols as $c) {
                //     if ($c['tipe'] == 'file') {
                //         $i[$c['col']] = '<img src="' .  'berkas/' . menu()['controller'] . '/' . $i[$c['col']] . '" alt="' . upper_first(str_replace("_", " ", $c['col'])) . '"/>';
                //     }
                // }

                $i['img_profile'] = '<img width="200px" src="' .  'berkas/' . menu()['controller'] . '/' . $i['profile'] . '" alt="Profile"/>';
                $html = view('cetak/profile', ['judul' => 'Daftar ' . upper_first(menu()['controller']), 'data' => $i, 'cols' => $cols]);
                $mpdf->AddPage();
                $mpdf->WriteHTML($html);
            }
            $this->response->setHeader('Content-Type', 'application/pdf');
            $mpdf->Output('Data ' . menu()['controller'] . '.pdf', 'I');
        } else {

            $filename = 'Data ' . menu()['controller'] . '.xlsx';

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
            foreach ($res as $i) {
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
