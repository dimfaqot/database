<?php

namespace App\Controllers\Kelas;

use App\Controllers\BaseController;

class Kelas extends BaseController
{
    function __construct()
    {
        helper('functions');
        if (!session('id')) {
            gagal(base_url('login'), 'Anda belum login.');
        }
        check_role();
    }

    public function index($angkatan = 'Tujuh')
    {
        $db = db(menu()['tabel'], get_db(menu()['tabel']));
        $db;
        if ($angkatan !== 'All') {
            $db->where('angkatan', str_replace("-", " ", $angkatan));
        }
        $q = $db->orderBy('angkatan', 'ASC')->orderBy('id', 'DESC')->get()->getResultArray();

        return view('kelas/' .  menu()['controller'], ['judul' => menu()['menu'], 'data' => $q]);
    }

    public function add()
    {
        $angkatan = clear($this->request->getVar('angkatan'));
        $kelas = strtoupper(clear($this->request->getVar('kelas')));
        $wali_kelas = upper_first($this->request->getVar('wali_kelas'));
        $url = clear($this->request->getVar('url'));

        if ($angkatan == 'All') {
            gagal($url, 'Kelas tidak boleh All.');
        }

        $db = db(menu()['tabel'], get_db(menu()['tabel']));

        $q = $db->where('angkatan', $angkatan)->where('kelas', $kelas)->get()->getRowArray();

        if ($q) {
            gagal($url, 'Data sudah ada.');
        }

        $data = [
            'angkatan' => $angkatan,
            'kelas' => $kelas,
            'wali_kelas' => $wali_kelas
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
        $angkatan = clear($this->request->getVar('angkatan'));
        $kelas = strtoupper(clear($this->request->getVar('kelas')));
        $wali_kelas = upper_first($this->request->getVar('wali_kelas'));
        $url = clear($this->request->getVar('url'));

        if ($angkatan == 'All') {
            gagal($url, 'Kelas tidak boleh All.');
        }

        $db = db(menu()['tabel'], get_db(menu()['tabel']));

        $q = $db->where('id', $id)->get()->getRowArray();

        if (!$q) {
            gagal($url, 'Id tidak ditemukan.');
        }

        $exist = $db->whereNotIn('id', [$id])->where('angkatan', $angkatan)->where('kelas', $kelas)->get()->getRowArray();
        if ($exist) {
            gagal($url, 'Data sudah ada.');
        }

        $q['angkatan'] = $angkatan;
        $q['kelas'] = $kelas;
        $q['wali_kelas'] = $wali_kelas;

        $db->where('id', $id);
        if ($db->update($q)) {
            sukses($url, 'Data sukses diupdate.');
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
            sukses_js('Data berhasil dihapus.');
        } else {
            gagal_js('Data gagal dihapus.');
        }
    }
}
