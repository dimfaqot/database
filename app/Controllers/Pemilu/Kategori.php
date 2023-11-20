<?php


namespace App\Controllers\Pemilu;

use App\Controllers\BaseController;

class Kategori extends BaseController
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
        $q = $db->orderBy('suara', 'DESC')->get()->getResultArray();


        return view('pemilu/' . menu()['controller'], ['judul' => menu()['menu'], 'data' => $q]);
    }

    public function add()
    {

        $kategori = upper_first(clear($this->request->getVar('kategori')));
        $suara = clear($this->request->getVar('suara'));


        $data = [
            'kategori' => $kategori,
            'suara' => $suara,
            'petugas' => session('nama'),
        ];

        $db = db(menu()['tabel'], get_db(menu()['tabel']));
        if ($db->insert($data)) {
            sukses(base_url(menu()['controller']), 'Data berhasil disimpan.');
        } else {
            gagal(base_url(menu()['controller']), 'Data gagal disimpan.');
        }
    }


    public function update()
    {
        $id = $this->request->getVar('id');
        $kategori = upper_first(clear($this->request->getVar('kategori')));
        $suara = clear($this->request->getVar('suara'));

        $db = db(menu()['tabel'], get_db(menu()['tabel']));

        $q = $db->where('id', $id)->get()->getRowArray();
        if (!$q) {
            gagal(base_url(menu()['controller']), 'Id tidak ditemukan.');
        }

        $q['kategori'] = $kategori;
        $q['suara'] = $suara;
        $q['petugas'] = session('nama');


        $db->where('id', $id);
        if ($db->update($q)) {
            sukses(base_url(menu()['controller']), 'Data berhasil diupdate.');
        } else {
            gagal(base_url(menu()['controller']), 'Data gagal diupdate.');
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
            sukses_js('Data berhasil dihapus.');
        } else {
            gagal_js('Data gagal dihapus.');
        }
    }
}
