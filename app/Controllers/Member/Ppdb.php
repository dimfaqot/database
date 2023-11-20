<?php


namespace App\Controllers\Member;

use App\Controllers\BaseController;

class Ppdb extends BaseController
{
    function __construct()
    {
        helper('functions');
        if (!session('id')) {
            gagal(base_url('login'), 'Anda belum login.');
        }
        check_role();
    }


    public function identitas($sub_menu)
    {

        $data = user_login();
        $cols = 'no_id,nik,nama,gender,email,hp,kota_lahir,tgl_lahir';

        if ($sub_menu == 'Alamat') {
            $cols = 'nama,no_id,alamat,provinsi,kabupaten,kecamatan,kelurahan,kode_pos';
        }
        if ($sub_menu == 'Riwayat') {
            $cols = 'nama,no_id,sekolah_asal,alamat_sekolah_asal,tahun_masuk,sub,pondok,status';
        }

        if ($sub_menu == 'Perwalian') {
            $cols = 'nama,no_id,pendapatan,infaq,no_kk,nama_ayah,nik_ayah,pekerjaan_ayah,hp_ayah,nama_ibu,nik_ibu,pekerjaan_ibu,hp_ibu,nama_wali,hp_wali,alamat_wali';
        }

        if ($sub_menu == 'Keluarga') {
            $cols = 'nama,no_id,keluarga';
        }
        if ($sub_menu == 'Ekonomi') {
            $cols = 'nama,no_id,ekonomi';
        }

        if ($sub_menu == 'Kesehatan') {
            $cols = 'nama,no_id,kesehatan';
        }
        if ($sub_menu == 'Karakter') {
            $cols = 'nama,no_id,karakter';
        }

        if ($sub_menu == 'Berkas') {
            $x = 'nama,no_id,' . implode(",", array_keys(file_santri()));

            $x = explode(",", $x);
            $v = [];
            foreach ($x as $i) {
                if ($i !== 'wawancara' && $i !== 'psikotes' && $i !== 'questioner' && $i !== 'sp' && $i !== 'listrik' && $i !== 'pdam' && $i !== 'gaji' && $i !== 'photo_1' && $i !== 'photo_2' && $i !== 'photo_3' && $i !== 'photo_4' && $i !== 'photo_5' && $i !== 'photo_6' && $i !== 'photo_7' && $i !== 'photo_8' && $i !== 'photo_9' && $i !== 'photo_10') {
                    $v[] = $i;
                }
            }

            $cols = implode(",", $v);
        }


        if ($sub_menu == 'Profile') {
            $data['tgl_lahir'] = date('Y-m-d', $data['tgl_lahir']);
        }

        return view(strtolower(session('role')) . '/' . menu()['controller'] . '_' . strtolower(session('section')), ['judul' => $sub_menu . ' ' . $data['nama'], 'data' => $data, 'cols' => explode(",", $cols)]);
    }

    public function update()
    {

        $sub_menu = clear($this->request->getVar('sub_menu'));
        $cols = clear($this->request->getVar('cols'));
        $url = clear($this->request->getVar('url'));
        $id = session('no_id');

        $db = db(strtolower(session('section')), get_db(strtolower(session('section'))));
        $q = $db->where('no_id', $id)->get()->getRowArray();
        if (!$q) {
            gagal($url, 'Id tidak ditemukan.');
        }

        $data = user_login();
        if ($sub_menu == 'Berkas') {

            $file = $_FILES['file'];

            upload($file, $data, $cols, $url, strtolower(session('section')));
        }

        $arr_cols = explode(",", $cols);

        foreach ($arr_cols as $i) {

            if ($sub_menu !== 'Profile') {
                if ($i == 'nama' || $i == 'no_id') {
                    continue;
                }
            }

            if ($i == 'nama' || $i == 'kota_lahir' || $i == 'alamat' || $i == 'kelurahan' || $i == 'kecamatan' || $i == 'kabupaten' || $i == 'provinsi' || $i == 'kampus_s1' || $i == 'fakultas_s1' || $i == 'jurusan_s1' || $i == 'kampus_s2' || $i == 'fakultas_s2' || $i == 'jurusan_s2' || $i == 'kampus_s3' || $i == 'fakultas_s3' || $i == 'jurusan_s3') {
                $data[$i] = (upper_first(clear($this->request->getVar($i))) == '' ? $data[$i] : upper_first(clear($this->request->getVar($i))));
            } elseif ($i == 'email') {
                $data[$i] = (strtolower(clear($this->request->getVar($i))) == '' ? $data[$i] : strtolower(clear($this->request->getVar($i))));
            } elseif ($i == 'hp' || $i == 'hp_ayah' || $i == 'hp_ibu' || $i == 'hp_wali') {
                if (strlen(clear($this->request->getVar($i))) < 10 && clear($this->request->getVar($i) !== '')) {
                    gagal($url, 'No. Hp tidak valid.');
                }
                $data[$i] = (clear($this->request->getVar($i)) == '' ? $data[$i] : clear($this->request->getVar($i)));
            } elseif ($i == 'ipk_s1' || $i == 'ipk_s2' || $i == 'ipk_s3') {
                if (clear($this->request->getVar($i)) > 4.00) {
                    gagal($url, 'Ipk maksimal 4.00.');
                }
                $data[$i] = (clear($this->request->getVar($i)) == '' ? $data[$i] : clear($this->request->getVar($i)));
            } elseif ($i == 'gelar_s1' || $i == 'gelar_s2' || $i == 'gelar_s3') {

                $data[$i] = trim(trim(trim($this->request->getVar($i), '.'), ','), '.');
            } elseif ($i == 'kode_pos') {
                if (strlen(clear($this->request->getVar($i))) !== 5 && clear($this->request->getVar($i) > 0)) {
                    gagal($url, 'Kode pos tidak valid.');
                }
                $data[$i] = (clear($this->request->getVar($i)) == '' ? $data[$i] : clear($this->request->getVar($i)));
            } elseif ($i == 'ekonomi' || $i == 'kesehatan' || $i == 'karakter' || $i == 'keluarga') {
                $data[$i] = $this->request->getVar($i);
            } elseif ($i == 'tgl_lahir') {
                $data[$i] = (strtotime(clear($this->request->getVar($i))) == '' ? $data[$i] : strtotime(clear($this->request->getVar($i))));
            } else {
                $data[$i] = (clear($this->request->getVar($i))) == '' ? $data[$i] : clear($this->request->getVar($i));
            }
        }
        $data['updated_at'] = time();
        $data['petugas'] = session('nama');



        $db->where('no_id', $id);
        if ($db->update($data)) {
            sukses($url, 'Data sukses diupdate.');
        } else {
            gagal($url, 'Data gagal diupdate.');
        }
    }
}
