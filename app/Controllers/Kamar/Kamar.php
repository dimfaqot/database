<?php

namespace App\Controllers\Kamar;

use App\Controllers\BaseController;

class Kamar extends BaseController
{
    function __construct()
    {
        helper('functions');
        if (!session('id')) {
            gagal(base_url('login'), 'Anda belum login.');
        }
        check_role();
    }

    public function index($pondok = 'L')
    {
        $db = db(menu()['controller'], get_db(menu()['controller']));
        if (session('role') == 'Root') {
            $db;
            if ($pondok !== 'All') {
                $db->where('pondok', $pondok);
            }
            $q = $db->orderBy('pondok', 'ASC')->orderBy('kamar', 'ASC')->get()->getResultArray();
        } else {
            $q = $db->where('pondok', session('gender'))->orderBy('kamar', 'ASC')->get()->getResultArray();
        }
        return view('kamar/' .  menu()['controller'], ['judul' => menu()['menu'], 'data' => $q]);
    }

    public function add()
    {
        $pondok = clear($this->request->getVar('pondok'));
        $kamar = upper_first(clear($this->request->getVar('kamar')));
        $wali_kamar_1 = upper_first(clear($this->request->getVar('wali_kamar_1')));
        $wali_kamar_2 = upper_first(clear($this->request->getVar('wali_kamar_2')));
        $url = clear($this->request->getVar('url'));

        if ($pondok == 'All') {
            gagal($url, 'Pondok tidak boleh All.');
        }

        $db = db(menu()['tabel'], get_db(menu()['tabel']));

        $q = $db->where('pondok', $pondok)->where('kamar', $kamar)->get()->getRowArray();

        if ($q) {
            gagal($url, 'Data sudah ada.');
        }

        $data = [
            'pondok' => $pondok,
            'kamar' => $kamar,
            'wali_kamar_1' => $wali_kamar_1,
            'wali_kamar_2' => $wali_kamar_2
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
        $pondok = clear($this->request->getVar('pondok'));
        $kamar = upper_first(clear($this->request->getVar('kamar')));
        $wali_kamar_1 = upper_first($this->request->getVar('wali_kamar_1'));
        $wali_kamar_2 = upper_first($this->request->getVar('wali_kamar_2'));
        $url = clear($this->request->getVar('url'));

        if ($pondok == 'All') {
            gagal($url, 'Pondok tidak boleh All.');
        }
        $db = db(menu()['tabel'], get_db(menu()['tabel']));

        $q = $db->where('id', $id)->get()->getRowArray();

        if (!$q) {
            gagal($url, 'Id tidak ditemukan.');
        }

        $exist = $db->whereNotIn('id', [$id])->where('pondok', $pondok)->where('kamar', $kamar)->get()->getRowArray();
        if ($exist) {
            gagal($url, 'Data sudah ada.');
        }

        $q['pondok'] = $pondok;
        $q['kamar'] = $kamar;
        $q['wali_kamar_1'] = $wali_kamar_1;
        $q['wali_kamar_2'] = $wali_kamar_2;

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
