<?php


namespace App\Controllers\News;

use App\Controllers\BaseController;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Home extends BaseController
{
    function __construct()
    {
        helper('functions');
        if (!session('id')) {
            gagal(base_url('login'), 'Anda belum login.');
        }
    }

    public function index()
    {


        // $db = db('karyawan', 'walisongo_api');

        // $q = $db->orderBy('nama', 'ASC')->where('status', 'Aktif')->get()->getResultArray();


        // $cols = ['nama', 'ttl', 'alamat', 'pengabdian', 'umur'];

        // $data = [];

        // foreach ($q as $i) {

        //     $exp = explode("-", $i['tgl_lahir']);

        //     if (count($exp) == 3) {
        //         $bl = bulan($exp[1])['bulan'];
        //         $i['ttl'] = ($i['kota_lahir'] == '' ? '' : $i['kota_lahir'] . ', ') . $exp[2] . ' ' . $bl . ' ' . $exp[0];
        //     } else {
        //         $i['ttl'] = '';
        //     }

        //     $i['alamat'] = ($i['alamat'] == '' ? '' : $i['alamat'] . ' ') . ($i['kelurahan'] == '' ? '' : $i['kelurahan'] . ', ') . ($i['kecamatan'] == '' ? '' : $i['kecamatan'] . ', ') . ($i['kabupaten'] == '' ? '' : $i['kabupaten'] . ', ') . ($i['provinsi'] == '' ? '' : $i['provinsi'] . ', ') . ($i['kode_pos'] == '' ? '' : $i['kode_pos']);
        //     $i['umur'] = umur(strtotime($i['tgl_lahir']));
        //     $i['pengabdian'] = ($i['tahun_masuk'] == '' ? '' : date('Y') - (int)$i['tahun_masuk']);

        //     $data[] = $i;
        // }


        // $filename = 'Data Karyawan.xlsx';

        // $spreadsheet = new Spreadsheet();

        // $sheet = $spreadsheet->getActiveSheet();

        // $huruf = 'Z';

        // foreach ($cols as $k => $c) {
        //     $huruf++;
        //     if ($k < 26) {
        //         $sheet->setCellValue(substr($huruf, -1) . '1', upper_first(str_replace("_", " ", $c)));
        //     } else {
        //         $sheet->setCellValue('A' . substr($huruf, -1) . '1', upper_first(str_replace("_", " ", $c)));
        //     }
        // }

        // $rows = 2;
        // $huruf = 'Z';
        // foreach ($data as $i) {

        //     foreach ($cols as $k => $c) {
        //         $huruf++;
        //         if ($k < 26) {
        //             $sheet->setCellValue(substr($huruf, -1) . $rows, $i[$c]);
        //         } else {
        //             $sheet->setCellValue('A' . substr($huruf, -1) . $rows, $i[$c]);
        //         }
        //     }
        //     $huruf = 'Z';
        //     $rows++;
        // }
        // header('Content-Type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment;filename=' . $filename);
        // header('Cache-Control: maxe-age=0');

        // $writer = new Xlsx($spreadsheet);
        // $writer->save('php://output');

        // exit;
        // $db = db('pilangsari', get_db('pilangsari'));

        // $q = $db->where('kategori', 'UMUM & TPQ')->get()->getResultArray();

        // foreach ($q as $i) {
        //     $i['kategori'] = 'Umum';

        //     $db->where('no', $i['no']);
        //     $db->update($i);
        // }
        // for ($i = 1; $i < 3111; $i++) {
        //     $q = $db->where('no', $i)->get()->getResultArray();
        //     if (!$q) {
        //         $data = [
        //             'no' => $i,
        //             'jenis' => 'SSJ',
        //             'ket' => 0,
        //             'created_at' => time(),
        //             'updated_at' => time(),
        //             'petugas' => 'Djanasquad'
        //         ];

        //         $db->insert($data);
        //     }
        // }

        // $db = db('sk', 'karyawan');
        // $tahun = $db->groupBy('tahun')->orderBy('tahun', 'ASC')->get()->getResultArray();

        // foreach ($tahun as $i) {
        //     if ($i['tahun'] < 2024) {
        //         $q = $db->where('tahun', $i['tahun'])->get()->getRowArray();

        //         $data = [
        //             'tahun' => $q['tahun'],
        //             'rapat' => $q['rapat'],
        //             'penetapan' => $q['penetapan'],
        //             'ketua_ypp' => $q['ketua_ypp'],
        //             'kop' => $q['kop'],
        //             'petugas' => session('nama')
        //         ];

        //         $dbt = db('tahuns');
        //         $dbt->insert($data);
        //     }
        // }

        // $fileName = 'data_ssj.csv';
        // $file = fopen($fileName, "r");
        // $datas = [];
        // while (!feof($file)) {
        //     $datas[] = fgetcsv($file);
        // }
        // fclose($file);


        // $false = [];
        // $fix = [];

        // $not_full = [];

        // foreach ($datas as $k => $i) {

        //     if ($k > 0) {
        //         if ($i !== false) {
        //             $exp = explode(";", $i[0]);

        //             if (count($exp) == 5) {
        //                 $no = $exp[0];
        //                 if (strlen($exp[0]) == 1) {
        //                     $no = '000' . $exp[0];
        //                 } elseif (strlen($exp[0]) == 2) {
        //                     $no = '00' . $exp[0];
        //                 } elseif (strlen($exp[0]) == 3) {
        //                     $no = '0' . $exp[0];
        //                 } elseif (strlen($exp[0]) == 4) {
        //                     $no =  $exp[0];
        //                 }
        //                 $fix[] = ['no' => $no, 'pj' => $exp[1], 'nama' => $exp[2], 'alamat' => '', 'kategori' => $exp[3], 'ket' => $exp[4]];
        //             } else {
        //                 $not_full[] = $i;
        //             }
        //         } else {
        //             $false[] = $i;
        //         }
        //     }
        // }

        // $short_by = SORT_ASC;
        // $keys = array_column($fix, 'no');
        // array_multisort($keys, $short_by, $fix);

        // $db = db('pilangsari', 'sertifikat');
        // foreach ($fix as $i) {
        //     $db->insert($i);
        // }

        // $db = db('pilangsari', 'sertifikat');

        // $q = $db->get()->getResultArray();

        // foreach ($q as $i) {
        //     $i['created_at'] = time();
        //     $i['updated_at'] = time();
        //     $i['petugas'] = 'Djanasquad';

        //     $db->where('no', $i['no']);
        //     $db->update($i);
        // }



        return view('news/' . menu()['controller'], ['judul' => 'Home']);
    }

    public function ganti_password()
    {

        $password_saat_ini = clear($this->request->getVar('password_saat_ini'));
        $password_baru = clear($this->request->getVar('password_baru'));
        $ulangi_password_baru = clear($this->request->getVar('ulangi_password_baru'));

        $db = db('user');

        $q = $db->where('id', session('id'))->get()->getRowArray();

        if (!$q) {
            gagal(base_url('home'), 'Id tidak ditemukan.');
        }

        if (!password_verify($password_saat_ini, $q['password'])) {
            gagal(base_url('home'), 'Password saat ini salah.');
        }

        if ($password_baru !== $ulangi_password_baru) {
            gagal(base_url('home'), 'Password baru dan ulangi password baru tidak sama.');
        }

        $q['password'] = password_hash($password_baru, PASSWORD_DEFAULT);
        $q['updated_at'] = time();
        $q['petugas'] = session('nama');

        $db->where('id', session('id'));

        if ($db->update($q)) {
            sukses(base_url('home'), 'Password berhasil diganti.');
        } else {
            gagal(base_url('home'), 'Password gagal diganti.');
        }
    }

    public function logout()
    {
        session()->remove('id');
        session()->remove('username');
        session()->remove('no_id');
        session()->remove('section');
        session()->remove('role');
        session()->remove('gender');
        session()->remove('nama');

        sukses(base_url('login'), 'Logout sukses!.');
    }



    public function search_by_text()
    {
        $tabel_db = clear($this->request->getVar('tabel_db'));
        $col = clear($this->request->getVar('col'));
        $text = clear($this->request->getVar('text'));


        $db = db($tabel_db, get_db($tabel_db));

        $q = $db->like($col, $text, 'both')->where('deleted', 0)->get()->getResultArray();
        sukses_js('Koneksi sukses.', $q);
    }

    public function add_data_from_db()
    {
        $controller = clear($this->request->getVar('controller'));
        $tabel_db = clear($this->request->getVar('tabel_db'));
        $no_id = clear($this->request->getVar('no_id'));
        $tahun = clear($this->request->getVar('tahun'));
        $ekstra = clear($this->request->getVar('ekstra'));
        $kategori = clear($this->request->getVar('kategori'));

        if ($controller == 'calon') {

            $no_id = $this->request->getVar('no_id');
            $db = db('santri', get_db('santri'));
            $q = $db->where('no_id', $no_id)->get()->getRowArray();


            $pondok = 'Putra';
            if ($q['gender'] == 'P') {
                $pondok = 'Putri';
            }

            $db = db('calon', get_db('calon'));
            $exist = $db->where('id', $no_id)->get()->getRowArray();

            if ($exist) {
                gagal_js('Nama sudah ada.!');
            }

            $data = [
                'id' => $no_id,
                'tahun' => date('Y'),
                'pondok' => $pondok,
                'nama' => $q['nama'],
                'ttl' => ttl($q),
                'logo_partai' => 'file_not_found.jpg',
                'profile' => 'file_not_found.jpg',
                'flyer' => 'file_not_found.jpg',
                'petugas' => session('nama'),
            ];


            if ($db->insert($data)) {
                sukses_js('Data berhasil disimpan.');
            } else {
                gagal_js('Data gagal disimpan.');
            }
        }

        if ($controller == 'pemilih') {

            $d = 'karyawan';
            if ($kategori == 'Santri') {
                $d = 'santri';
            }

            $no_id = $this->request->getVar('no_id');
            $db = db($d, get_db($d));
            $q = $db->where('no_id', $no_id)->get()->getRowArray();


            $pondok = 'Putra';
            if ($q['gender'] == 'P') {
                $pondok = 'Putri';
            }

            $pem = db('pemilih', get_db('pemilih'));
            $exist = $pem->where('no_id', $no_id)->get()->getRowArray();

            if ($exist) {
                gagal_js('Nama sudah ada.!');
            }

            $data = [
                'no_id' => $no_id,
                'tahun' => $tahun,
                'pondok' => $pondok,
                'sub' => $q['sub'],
                'nama' => $q['nama'],
                'kategori' => $kategori,
                'tgl' => 0,
                'voted' => 0,
                'absen' => 0,
                'created_at' => time(),
                'updated_at' => time(),
                'petugas' => session('nama'),
            ];


            if ($pem->insert($data)) {
                sukses_js('Data berhasil disimpan.');
            } else {
                gagal_js('Data gagal disimpan.');
            }
        }

        if ($controller == 'user') {
            $db = db($tabel_db, get_db($tabel_db));
            $q = $db->where('no_id', $no_id,)->where('deleted', 0)->get()->getRowArray();

            $data = [
                'nama' => $q['nama'],
                'no_id' => $q['no_id'],
                'section' => upper_first($tabel_db),
                'role' => 'Member',
                'gender' => $q['gender'],
                'password' => password_hash(upper_first($tabel_db) . '_' . $q['no_id'], PASSWORD_DEFAULT),
                'created_at' => time(),
                'updated_at' => time(),
                'petugas' => session('nama')
            ];

            $db = db('user');
            $q = $db->where('no_id', $data['no_id'])->where('section', $data['section'])->where('role', $data['role'])->get()->getRowArray();
            if ($q) {
                gagal_js('Data sudah ada.');
            }

            if ($db->insert($data)) {
                sukses_js('Data sukses disimpan.');
            } else {
                gagal_js('Data gagal disimpan.');
            }
        }

        if ($controller == 'nilai') {

            $db = db('santri', 'santri');

            $santri = $db->where('no_id', $no_id)->get()->getRowArray();

            $db = db('mapel', 'ekstra');
            $mapel = $db->where('singkatan', $ekstra)->orderBy('no_urut', 'ASC')->get()->getResultArray();

            $time = time();
            $kode = last_no_ekstra($time, $ekstra, $tahun);


            foreach ($mapel as $i) {
                $data = [
                    'tgl' => $time,
                    'ekstra' => $i['ekstra'],
                    'kode' => $kode,
                    'singkatan' => $i['singkatan'],
                    'kepala' => $i['kepala'],
                    'no_urut' => $i['no_urut'],
                    'mapel' => $i['mapel'],
                    'sks' => $i['sks'],
                    'no_id' => $santri['no_id'],
                    'nama' => $santri['nama']
                ];

                $db = db('nilai', get_db('nilai'));
                $db->insert($data);
            }

            sukses_js('Data sukses disimpan.');
        }

        if ($controller == 'sk') {
            $db = db('sk', 'karyawan');
            $q = $db->where('no_id', $no_id)->orderBy('tahun', 'DESC')->orderBy('created_at', 'DESC')->get()->getRowArray(); //sk
            $q['created_at'] = time();
            $q['updated_at'] = time();
            $q['petugas'] = session('nama');
            unset($q['id']);

            $th = db('tahun');
            $thn = $th->where('tahun', $tahun)->get()->getRowArray(); //tahun

            // jika sk dan tahun ada
            if ($q && $thn) {
                $q['no_sk'] = last_sk($thn['penetapan']);
                $q['tahun'] = $tahun;

                if ($db->insert($q)) {
                    sukses_js('Sk berhasil dibuat.');
                } else {
                    gagal_js('Sk gagal dibuat.');
                }
            }
            // jika hanya ada sk
            if ($q) {
                $q['tahun'] = $tahun;

                if ($db->insert($q)) {
                    sukses_js('Sk berhasil dibuat.');
                } else {
                    gagal_js('Sk gagal dibuat.');
                }
            }

            // jika hanya ada tahun
            if ($thn) {
                $user = db('karyawan', 'karyawan');
                $usr = $user->where('no_id', $no_id)->get()->getRowArray();



                $data = [
                    'tahun' => $tahun,
                    'nama' => nama_gelar($user),
                    'ttl' => ttl($user),
                    'no_sk' => last_sk($thn['penetapan']),
                    'sub' => sub($usr['sub'])['lengkap'],
                    'pendidikan' => pendidikan_sk($usr),
                    'penetapan' => $thn['penetapan'],
                    'rapat' => $thn['rapat'],
                    'ketua_ypp' => $thn['ketua_ypp'],
                    'kop' => $thn['kop'],
                    'ttd' => get_ttd($thn['ketua_ypp']),
                    'created_at' => time(),
                    'updated_at' => time(),
                    'petugas' => session('nama')
                ];

                if ($user->insert($data)) {
                    sukses_js('Sk berhasil dibuat.');
                } else {
                    gagal_js('Sk gagal dibuat.');
                }
            }
        }
    }

    public function check_no_sk()
    {
        $id = clear($this->request->getVar('id'));
        $val = clear($this->request->getVar('val'));

        $db = db('sk', 'karyawan');

        $q = $db->whereNotIn('id', [$id])->where('no_sk', $val)->get()->getRowArray();

        if ($q) {
            gagal_js('No. Sk sudah ada.<div style="font-weight:bold;">' . $q['nama'] . '</div>');
        } else {
            sukses_js('<small class="text-success"><i class="fa-solid fa-circle-check"></i> No. Sk tersedia.</small><div class="d-grid mt-1"><button data-id="' . $id . '" data-value="' . $val . '" class="btn_main update_no_sk">Simpan</button></div>');
        }
    }
    public function check_no_id()
    {
        $id = clear($this->request->getVar('id'));
        $db = clear($this->request->getVar('db'));
        $tabel = clear($this->request->getVar('tabel'));
        $val = clear($this->request->getVar('val'));

        $dbs = db($tabel, $db);


        if ($db == 'karyawan') {
            if (strlen($val) !== 9) {
                gagal_js('<small class="text-danger"><i class="fa-solid fa-circle-exclamation"></i> Niy tidak valid!.</small>');
            } else {
                $q = $dbs->whereNotIn('no_id', [$id])->where('no_id', $val)->get()->getRowArray();

                if ($q) {
                    gagal_js('<small class="text-danger"><i class="fa-solid fa-circle-exclamation"></i> Niy sudah ada!.</small>');
                } else {
                    sukses_js('<small class="text-success"><i class="fa-solid fa-circle-check"></i> Niy tersedia!.</small>');
                }
            }
        }
        if ($db == 'santri') {
            if (strlen($val) !== 6) {
                gagal_js('<small class="text-danger"><i class="fa-solid fa-circle-exclamation"></i> No. Id tidak valid!.</small>');
            } else {
                $q = $dbs->whereNotIn('no_id', [$id])->where('no_id', $val)->get()->getRowArray();

                if ($q) {
                    gagal_js('<small class="text-danger"><i class="fa-solid fa-circle-exclamation"></i> No. Id sudah ada!.</small>');
                } else {
                    sukses_js('<small class="text-success"><i class="fa-solid fa-circle-check"></i> No. Id tersedia!.</small>');
                }
            }
        }
    }

    public function indonesia()
    {
        $order = clear($this->request->getVar('order'));
        $val = clear($this->request->getVar('val'));
        $id = clear($this->request->getVar('id'));


        if ($order == 'kota_lahir') {
            $db = db('kabupaten', 'indonesia');
            $q = $db->like('name', $val, 'both')->orderBy('name', 'ASC')->get()->getResultArray();
        } else {
            $db = db($order, 'indonesia');
            $db;
            if ($order !== 'provinsi') {
                $to_tabel = 'provinsi_id';
                if ($order == 'kecamatan') {
                    $to_tabel = 'kabupaten_id';
                }
                if ($order == 'kelurahan') {
                    $to_tabel = 'kecamatan_id';
                }
                $db->whereIn($to_tabel, [$id]);
            }
            $q = $db->like('name', $val, 'both')->orderBy('name', 'ASC')->get()->getResultArray();
        }


        sukses_js('Koneksi sukses.', $q);
    }
    public function panduan()
    {
        $db = db('settings');

        $q = $db->get()->getRowArray();

        if ($q['panduan'] == 0) {
            $q['panduan'] = 1;
        } else {
            $q['panduan'] = 0;
        }

        $db->where('id', $q['id']);
        if ($db->update($q)) {
            sukses_js('Panduan sukses diupdate.');
        } else {
            sukses_js('Panduan gagal diupdate.');
        }
    }

    public function update_wa()
    {
        $acara = clear($this->request->getVar('acara'));
        $tgl = clear($this->request->getVar('tgl'));
        $jam = clear($this->request->getVar('jam'));
        $tempat = clear($this->request->getVar('tempat'));
        $pengumuman = clear($this->request->getVar('pengumuman'));
        $url = clear($this->request->getVar('url'));

        $exp = explode("/", $url);
        $link = [];

        foreach ($exp as $i) {
            if ($i !== '') {
                $link[] = $i;
            }
        }

        $href = base_url() . implode("/", $link);

        $db = db('settings');
        $q = $db->get()->getRowArray();

        $q['acara'] = $acara;
        $q['tgl'] = $tgl;
        $q['jam'] = $jam;
        $q['tempat'] = $tempat;
        $q['pengumuman'] = $pengumuman;

        $db->where('id', $q['id']);
        if ($db->update($q)) {
            sukses($href, 'Data sukses diupdate.');
        } else {
            gagal($href, 'Data gagal diupdate.');
        }
    }

    public function encode()
    {
        $data = json_decode(json_encode($this->request->getVar('data')), true);
        $res = [
            'status' => '200',
            'data' => encode_jwt($data)
        ];

        echo json_encode($res);
        die;
    }



    public function update_checkbox()
    {
        $id = clear($this->request->getVar('id'));
        $col = clear($this->request->getVar('col'));
        $tabel = clear($this->request->getVar('tabel'));
        $db = clear($this->request->getVar('db'));


        $db = db($tabel, $db);
        $q = $db->where('no_id', $id)->get()->getRowArray();
        if (!$q) {
            gagal_js('Id tidak ditemukan!.');
        }

        $q[$col] = ($q[$col] == 1 ? 0 : 1);
        $q['updated_at'] = time();
        $q['petugas'] = session('nama');

        $db->where('no_id', $id);
        if ($db->update($q)) {
            sukses_js('Data sukses diupdate.');
        } else {
            gagal_js('Data gagal diupdate.');
        }
    }

    public function execute(): string
    {
        $id_pemilih = clear($this->request->getVar('id_pemilih'));
        $id_calon = clear($this->request->getVar('id_calon'));
        $url = clear($this->request->getVar('url'));

        $db = db('pemilih', get_db('pemilih'));
        $q = $db->where('no_id', $id_pemilih)->get()->getRowArray();

        if (session('role') == 'Admin') {

            if ($q['absen'] == 0) {
                gagal($url, 'Absent failed.');
            }
        }
        if ($q['voted'] == 3) {
            gagal($url, 'Anda sudah memilih.');
        }

        $bobot_suara = bobot_suara($q['kategori'], $url);

        $calon = db('calon', get_db('calon'));
        $q_calon = $calon->where('id', $id_calon)->get()->getRowArray();

        $q_calon['suara'] = $q_calon['suara'] + $bobot_suara;

        $calon->where('id', $id_calon);
        if ($calon->update($q_calon)) {
            if ($q['kategori'] == 'Ndalem' || $q['kategori'] == 'Dewan' || $q['kategori'] == 'Karyawan') {
                if ($q['voted'] == 0) {
                    if ($q_calon['pondok'] == 'Putra') {
                        $q['voted'] = 1;
                        $q['tgl'] = time();
                        $q['petugas'] = $q['nama'];
                    } else {
                        $q['voted'] = 2;
                        $q['tgl'] = time();
                        $q['petugas'] = $q['nama'];
                    }
                } else {
                    $q['voted'] = 3;
                    $q['tgl'] = time();
                    $q['petugas'] = $q['nama'];
                }
            } else {
                $q['voted'] = 3;
                $q['tgl'] = time();
                $q['petugas'] = $q['nama'];
            }

            $db->where('no_id', $id_pemilih);
            if ($db->update($q)) {
                sukses($url, 'Voted succeed');
            } else {
                gagal($url, 'Voted failed');
            }
        } else {
            gagal($url, 'Increment voting failed');
        }
    }

    public function auth_url()
    {
        $tabel = clear($this->request->getVar('tabel'));
        $id = clear($this->request->getVar('id'));
        $section = clear($this->request->getVar('section'));
        $gender = clear($this->request->getVar('gender'));
        $role = clear($this->request->getVar('role'));
        $nama = clear($this->request->getVar('nama'));

        $encode = encode_jwt(['id' => $id, 'section' => $section, 'role' => $role, 'gender' => $gender, 'nama' => $nama]);
        $url = base_url() . 'public/a/' . $tabel . '/' . $encode;
        sukses_js('Koneksi ok', $url);
    }
    public function change_status()
    {
        $tabel = clear($this->request->getVar('tabel'));
        $id = clear($this->request->getVar('id'));
        $val = clear($this->request->getVar('val'));

        $db = db($tabel, get_db($tabel));

        $q = $db->where('no_id', $id)->get()->getRowArray();

        if (!$q) {
            gagal_js('Id tidak ditemukan!.');
        }

        $q['status'] = $val;
        $q['updated_at'] = time();
        $q['petugas'] = session('nama');

        $db->where('no_id', $id);

        if ($db->update($q)) {
            sukses_js('Data berhasil diupdate.');
        } else {
            gagal_js('Data gagal diupdate!.');
        }
    }
}
