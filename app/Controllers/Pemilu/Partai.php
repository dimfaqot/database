<?php


namespace App\Controllers\Pemilu;

use App\Controllers\BaseController;

class Partai extends BaseController
{
    function __construct()
    {
        helper('functions');
        if (!session('id')) {
            gagal(base_url('login'), 'Anda belum login.');
        }
        check_role();
    }
    public function index(): string
    {

        $db = db(menu()['tabel'], get_db(menu()['tabel']));
        $q = $db->orderBy('id', 'ASC')->get()->getResultArray();


        return view('pemilu/' . menu()['controller'], ['judul' => menu()['menu'], 'data' => $q]);
    }

    public function add()
    {

        $col = $this->request->getVar('col');

        $partai = upper_first(clear($this->request->getVar('partai')));
        $singkatan_partai = strtoupper(clear($this->request->getVar('singkatan_partai')));
        $file = $_FILES['file'];

        $url = base_url() . menu()['controller'];


        $data = [
            'partai' => $partai,
            'singkatan_partai' => $singkatan_partai,
            'petugas' => session('nama'),
        ];

        upload_add($file, $data, $col, $url);
    }
    public function detail($id)
    {

        $db = db(menu()['tabel'], get_db(menu()['tabel']));
        $q = $db->where('id', $id)->get()->getRowArray();
        if (!$q) {
            gagal(menu()['controller'] . '/show', 'Id tidak ditemukan.');
        }

        return view('pemilu/detail_' . menu()['controller'], ['judul' => $q['singkatan_partai'], 'data' => $q]);
    }

    public function update()
    {
        $id = $this->request->getVar('id');
        $partai = upper_first(clear($this->request->getVar('partai')));
        $singkatan_partai = strtoupper(clear($this->request->getVar('singkatan_partai')));



        $col = $this->request->getVar('col');
        $file = $_FILES['file'];

        $url = base_url() . menu()['controller'] . '/dtl/' . $id;

        $db = db(menu()['tabel'], get_db(menu()['tabel']));
        $q = $db->where('id', $id)->get()->getRowArray();
        if (!$q) {
            gagal($url, 'Id tidak ditemukan.');
        }

        $logo_partai = $q['logo_partai'];
        if ($file['error'] !== 4) {
            $q['nama'] = strtolower($singkatan_partai);
            $logo_partai = upload($file, $q, $col, $url);
        }

        $q['partai'] = $partai;
        $q['singkatan_partai'] = $singkatan_partai;
        $q['logo_partai'] = $logo_partai;
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

        $id = $this->request->getVar('id');

        $db = db(menu()['tabel'], get_db(menu()['tabel']));

        $q = $db->where('id', $id)->get()->getRowArray();

        if (!$q) {
            gagal_js('Id tidak ditemukan.');
        }


        $db->where('id', $id);
        if ($db->delete()) {
            if (unlink('berkas/' . $q['logo_partai'])) {
                sukses_js('Data dan gambar berhasil dihapus.');
            } else {
                sukses_js('Gambar gagal dihapus.');
            }
        } else {
            gagal_js('Data gagal dihapus.');
        }
    }
    public function restore()
    {

        $id = $this->request->getVar('id');

        $db = db(menu()['tabel'], get_db(menu()['tabel']));

        $q = $db->where('slug', $id)->get()->getRowArray();

        if (!$q) {
            gagal_js('Id tidak ditemukan.');
        }

        $q['deleted'] = 0;
        $q['updated_at'] = time();
        $q['petugas'] = session('nama');
        $db->where('slug', $id);
        if ($db->update($q)) {
            sukses_js('Data berhasil direstore.');
        } else {
            gagal_js('Data gagal direstore.');
        }
    }
}
