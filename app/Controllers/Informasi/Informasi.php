<?php

namespace App\Controllers\Informasi;

use App\Controllers\BaseController;

class Informasi extends BaseController
{
    function __construct()
    {
        helper('functions');
        if (!session('id')) {
            gagal(base_url('login'), 'Anda belum login.');
        }
        check_role();
    }

    public function index($section = 'Root', $role = 'Root')
    {
        $db = db(menu()['controller'], get_db(menu()['controller']));
        if (session('role') == 'Root') {
            $db;
            if ($section !== 'All') {
                $db->where('section', $section);
            }
            if ($role !== 'All') {
                $db->where('role', $role);
            }
            $q = $db->orderBy('section', 'ASC')->get()->getResultArray();
        } else {
            $q = $db->where('section', session('section'))->where('role', 'Member')->get()->getResultArray();
        }

        return view('informasi/' .  menu()['controller'], ['judul' => menu()['menu'], 'data' => $q]);
    }

    public function add()
    {
        $section = clear($this->request->getVar('section'));
        $role = clear($this->request->getVar('role'));
        $gender = clear($this->request->getVar('gender'));
        $url = clear($this->request->getVar('url'));
        $informasi = $this->request->getVar('informasi');

        $db = db(menu()['tabel'], get_db(menu()['tabel']));

        $q = $db->where('section', $section)->where('role', $role)->where('gender', $gender)->get()->getRowArray();

        if ($q) {
            gagal($url, 'Data sudah ada.');
        }

        $data = [
            'section' => $section,
            'role' => $role,
            'gender' => $gender,
            'informasi' => $informasi
        ];

        if ($db->insert($data)) {
            sukses($url, 'Data sukses disimpan.');
        } else {
            gagal($url, 'Data gagal disimpan.');
        }
    }

    public function update()
    {
        $id = $this->request->getVar('id');
        $section = clear($this->request->getVar('section'));
        $role = clear($this->request->getVar('role'));
        $gender = clear($this->request->getVar('gender'));
        $url = clear($this->request->getVar('url'));
        $informasi = $this->request->getVar('informasi');


        $db = db(menu()['tabel'], get_db(menu()['tabel']));

        $q = $db->where('id', $id)->get()->getRowArray();

        if (!$q) {
            gagal($url, 'Id tidak ditemukan.');
        }

        $exist = $db->whereNotIn('id', [$id])->where('section', $section)->where('role', $role)->where('gender', $gender)->get()->getRowArray();
        if ($exist) {
            gagal($url, 'Data sudah ada.');
        }

        $q['section'] = $section;
        $q['role'] = $role;
        $q['gender'] = $gender;
        $q['informasi'] = $informasi;

        $db->where('id', $id);
        if ($db->update($q)) {
            sukses($url, 'Data sukses diupdate.');
        } else {
            gagal($url, 'Data gagal diupdate.');
        }
    }
    public function copy()
    {
        $id = $this->request->getVar('id');
        $section = clear($this->request->getVar('section'));
        $role = clear($this->request->getVar('role'));
        $gender = clear($this->request->getVar('gender'));
        $url = clear($this->request->getVar('url'));


        $db = db(menu()['tabel'], get_db(menu()['tabel']));

        $q = $db->where('id', $id)->get()->getRowArray();

        if (!$q) {
            gagal($url, 'Id tidak ditemukan.');
        }

        $exist = $db->whereNotIn('id', [$id])->where('section', $section)->where('role', $role)->where('gender', $gender)->get()->getRowArray();
        if ($exist) {
            gagal($url, 'Data sudah ada.');
        }

        $q['section'] = $section;
        $q['role'] = $role;
        $q['gender'] = $gender;
        $q['informasi'] = $q['informasi'];
        unset($q['id']);

        if ($db->insert($q)) {
            sukses($url, 'Data sukses dicopy.');
        } else {
            gagal($url, 'Data gagal dicopy.');
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
            sukses_js('Data berhasil dihapus.');
        } else {
            gagal_js('Data gagal dihapus.');
        }
    }
}
