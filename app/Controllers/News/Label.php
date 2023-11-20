<?php


namespace App\Controllers\News;

use App\Controllers\BaseController;

class Label extends BaseController
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
        $db = db('label', 'news');
        $data = $db->orderBy('label')->get()->getResultArray();

        return view('news/' . menu()['controller'], ['judul' => menu()['menu'], 'data' => $data]);
    }

    public function add()
    {
        $label = upper_first(clear($this->request->getVar('label')));

        $db = db('label', 'news');

        $q = $db->where('label', $label)->get()->getRowArray();

        $url = base_url() .  menu()['controller'];

        if ($q) {
            gagal($url, 'Label sudah ada.');
        }

        $data = [
            'label' => $label
        ];


        if ($db->insert($data)) {
            sukses($url, 'Data sukses disimpan.');
        } else {
            gagal($url, 'Data gagal disimpan.');
        }
    }

    public function update_blur()
    {
        $id = clear($this->request->getVar('id'));
        $col = clear($this->request->getVar('col'));
        $val = upper_first(clear($this->request->getVar('val')));


        $db = db('label', 'news');

        $exist = $db->whereNotIn('id', [$id])->where($col, $val)->get()->getRowArray();

        if ($exist) {
            gagal_js('Label sudah ada!.');
        }

        $q = $db->where('id', $id)->get()->getRowArray();

        if (!$q) {
            gagal_js('Id tidak ditemukan.');
        }

        $q[$col] = $val;

        $db->where('id', $id);
        if ($db->update($q)) {
            sukses_js('Data berhasil diupdate.');
        } else {
            sukses_js('Data gagal diupdate.');
        }
    }


    public function delete()
    {
        $id = $this->request->getVar('id');

        $db = db('label', 'news');

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
