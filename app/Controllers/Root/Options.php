<?php


namespace App\Controllers\Root;

use App\Controllers\BaseController;

class Options extends BaseController
{

    function __construct()
    {
        helper('functions');
        if (!session('id')) {
            gagal(base_url('login'), 'Anda belum login.');
        }
        check_role();
    }

    public function index($kategori)
    {

        $db = db(menu()['tabel']);

        $kategoris = $db->select('kategori')->groupBy('kategori')->orderBy('kategori', 'ASC')->get()->getResultArray();

        $db;
        if ($kategori !== 'All') {
            $db->where('kategori', $kategori);
        }

        $data = $db->orderBy('no_urut', 'ASC')->get()->getResultArray();

        return view('root/' .  menu()['controller'], ['judul' => menu()['menu'], 'data' => $data, 'kategoris' => $kategoris, 'kategori' => $kategori]);
    }

    public function add()
    {
        $kategori = upper_first(clear($this->request->getVar('kategori')));
        $value = upper_first(clear($this->request->getVar('value')));

        $no_urut = 1;

        $db = db(menu()['tabel']);
        $q = $db->where('kategori', $kategori)->orderBy('no_urut', 'DESC')->get()->getRowArray();
        if ($q) {
            $no_urut = $q['no_urut'] + 1;
        }

        $data = [
            'kategori' => $kategori,
            'value' => $value,
            'no_urut' => $no_urut
        ];

        $url = base_url(menu()['controller']) . '/' . $kategori;


        $q = $db->where('kategori', $kategori)->where('value', $value)->get()->getRowArray();

        if ($q) {
            gagal($url, 'Data sudah ada.');
        }

        if ($db->insert($data)) {
            sukses($url, 'Data sukses disimpan.');
        } else {
            gagal($url, 'Data gagal disimpan.');
        }
    }

    public function update()
    {
        $id = $this->request->getVar('id');
        $kategori_now = upper_first(clear($this->request->getVar('kategori_now')));
        $kategori = upper_first(clear($this->request->getVar('kategori')));
        $value = upper_first(clear($this->request->getVar('value')));
        $no_urut = clear($this->request->getVar('no_urut'));

        $url = base_url(menu()['controller']) . '/' . $kategori;

        $db = \Config\Database::connect();
        $db = $db->table(menu()['tabel']);

        $q = $db->where('id', $id)->get()->getRowArray();

        if (!$q) {
            gagal(base_url(menu()['controller']) . '/' . $kategori_now, 'Id tidak ditemukan.');
        }

        $exist = $db->whereNotIn('id', [$id])->where('kategori', $kategori)->where('value', $value)->get()->getRowArray();
        if ($exist) {
            gagal(base_url(menu()['controller']) . '/' . $kategori_now, 'Data sudah ada.');
        }

        $q['kategori'] = $kategori;
        $q['value'] = $value;
        $q['no_urut'] = $no_urut;

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

        $db = db(menu()['tabel']);

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
