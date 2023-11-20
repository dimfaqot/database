<?php


namespace App\Controllers\Pemilu;

use App\Controllers\BaseController;

class Calon extends BaseController
{
    function __construct()
    {
        helper('functions');
        if (!session('id')) {
            gagal(base_url('login'), 'Anda belum login.');
        }
        check_role();
    }
    public function index($tahun): string
    {
        $db = db(menu()['tabel'], get_db(menu()['tabel'], get_db(menu()['tabel'])));
        $db;
        if ($tahun !== 'All') {
            $db->where('tahun', $tahun);
        }
        $q = $db->orderBy('pondok', 'ASC')->orderBy('no_urut_partai', 'ASC')->orderBy('status_calon', 'ASC')->get()->getResultArray();

        $tahun = $db->groupBy('tahun')->orderBy('tahun', 'DESC')->get()->getResultArray();

        return view('pemilu/' . menu()['controller'], ['judul' => menu()['menu'], 'data' => $q, 'tahun' => $tahun]);
    }

    public function add_data_from_db()
    {
        $no_id = $this->request->getVar('no_id');
        $nama = $this->request->getVar('nama');
        $kota_lahir = $this->request->getVar('kota_lahir');
        $tgl_lahir = $this->request->getVar('tgl_lahir');
        $tahun = $this->request->getVar('tahun');
        $gender = $this->request->getVar('gender');

        $pondok = 'Putra';
        if ($gender == 'P') {
            $pondok = 'Putri';
        }
        $db = db('calon');
        $q = $db->where('id', $no_id)->get()->getRowArray();

        if ($q) {
            gagal_js('Nama sudah ada.!');
        }

        $data = [
            'id' => $no_id,
            'tahun' => $tahun,
            'pondok' => $pondok,
            'nama' => $nama,
            'ttl' => $kota_lahir . ', ' . date('d', $tgl_lahir) . ' ' . bulan(date('m', $tgl_lahir))['bulan'] . ' ' . date('Y', $tgl_lahir),
            'logo_partai' => 'file_not_found.jpg',
            'profile' => 'file_not_found.jpg',
            'flyer' => 'file_not_found.jpg',
            'petugas' => session('nama'),
        ];

        $db = db(menu()['tabel'], get_db(menu()['tabel']));
        if ($db->insert($data)) {
            sukses_js('Data berhasil disimpan.');
        } else {
            gagal_js('Data gagal disimpan.');
        }
    }

    public function update()
    {
        $id = clear($this->request->getVar('id'));
        $tahun = clear($this->request->getVar('tahun'));


        $tahun = clear($this->request->getVar('tahun'));
        $partai = upper_first(clear($this->request->getVar('partai')));
        $no_urut_partai = clear($this->request->getVar('no_urut_partai'));
        $status_calon = clear($this->request->getVar('status_calon'));
        $pondok = clear($this->request->getVar('pondok'));
        $nama = upper_first(clear($this->request->getVar('nama')));
        $ttl = upper_first(clear($this->request->getVar('ttl')));
        $kelas = strtoupper(clear($this->request->getVar('kelas')));
        $riwayat = $this->request->getVar('riwayat');

        $file_profile = $_FILES['profile'];
        $url = clear($this->request->getVar('url'));


        $url = $url . '/' . $tahun;

        $db = db(menu()['tabel'], get_db(menu()['tabel'], get_db(menu()['tabel'])));

        $q = $db->where('id', $id)->get()->getRowArray();
        if (!$q) {
            gagal($url, 'Id tidak ditemukan.');
        }


        if ($file_profile['error'] !== 4) {
            upload($file_profile, $q, 'profile', $url);
        }


        if ($partai !== $q['partai']) {
            $par = db('partai', get_db('partai'));
            $pa = $par->where('partai', $partai)->get()->getRowArray();
            if ($pa) {

                $q['singkatan_partai'] = $pa['singkatan_partai'];
                $q['logo_partai'] = $pa['logo_partai'];
            }
        }

        $q['tahun'] = $tahun;
        $q['pondok'] = $pondok;
        $q['partai'] = $partai;
        $q['no_urut_partai'] = $no_urut_partai;
        $q['status_calon'] = $status_calon;
        $q['nama'] = $nama;
        $q['ttl'] = $ttl;
        $q['kelas'] = $kelas;
        $q['riwayat'] = $riwayat;
        $q['petugas'] = session('nama');


        $db->where('id', $id);
        if ($db->update($q)) {
            sukses($url, 'Data berhasil diupdate.');
        } else {
            gagal($url, 'Data gagal diupdate.');
        }
    }
    public function flyer()
    {
        $id = clear($this->request->getVar('id'));
        $tahun = clear($this->request->getVar('tahun'));
        $url = clear($this->request->getVar('url'));

        $url = $url . '/' . $tahun;
        $file_flyer = $_FILES['flyer'];


        $db = db(menu()['tabel'], get_db(menu()['tabel'], get_db(menu()['tabel'])));

        $q = $db->where('id', $id)->get()->getRowArray();
        if (!$q) {
            gagal($url, 'Id tidak ditemukan.');
        }


        if ($file_flyer['error'] !== 4) {
            upload($file_flyer, $q, 'flyer', $url);
        }

        $q['petugas'] = session('nama');


        $db->where('id', $id);
        if ($db->update($q)) {
            sukses($url, 'Data berhasil diupdate.');
        } else {
            gagal($url, 'Data gagal diupdate.');
        }
    }
    public function visi()
    {
        $id = $this->request->getVar('id');
        $tahun = $this->request->getVar('tahun');
        $visi_misi = $this->request->getVar('visi_misi');

        $url = base_url() . '/' . menu()['controller'] . '/' . $tahun;


        $db = db(menu()['tabel'], get_db(menu()['tabel']));

        $q = $db->where('id', $id)->get()->getRowArray();
        if (!$q) {
            gagal($url, 'Id tidak ditemukan.');
        }


        $q['visi_misi'] = $visi_misi;
        $q['petugas'] = session('nama');


        $db->where('id', $id);
        if ($db->update($q)) {
            sukses($url, 'Data berhasil diupdate.');
        } else {
            gagal($url, 'Data gagal diupdate.');
        }
    }

    public function delete()
    {

        $id = clear($this->request->getVar('id'));

        $db = db(menu()['tabel'], get_db(menu()['tabel']));

        $q = $db->where('id', $id)->get()->getRowArray();

        if (!$q) {
            gagal_js('Id tidak ditemukan.');
        }

        $db->where('id', $id);
        if ($db->delete()) {
            if (unlink('berkas/' . $q['flyer'])) {
                sukses_js('Data dan gambar berhasil dihapus.');
            } else {
                sukses_js('Gambar gagal dihapus.');
            }
        } else {
            gagal_js('Data gagal dihapus.');
        }
    }
}
