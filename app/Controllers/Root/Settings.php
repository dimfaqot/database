<?php


namespace App\Controllers\Root;

use App\Controllers\BaseController;

class Settings extends BaseController
{

    function __construct()
    {
        helper('functions');
        if (!session('id')) {
            gagal(base_url('login'), 'Anda belum login.');
        }
        check_role();
    }

    public function index()
    {

        $db = db(menu()['tabel']);

        $data = $db->get()->getRowArray();

        return view('root/' .  menu()['controller'], ['judul' => menu()['menu'], 'data' => $data]);
    }


    public function update()
    {
        $id = $this->request->getVar('id');
        $default_password = clear($this->request->getVar('default_password'));
        $key_jwt = clear($this->request->getVar('key_jwt'));
        $hasil_pemilu = clear($this->request->getVar('hasil_pemilu'));
        $pemilu_dimulai = clear($this->request->getVar('pemilu_dimulai'));
        $is_sertifikat = clear($this->request->getVar('is_sertifikat'));
        $db_i = clear($this->request->getVar('db'));

        $url = base_url(menu()['controller']);



        $db = db(menu()['tabel'], get_db(menu()['tabel']));

        $q = $db->where('id', $id)->get()->getRowArray();
        if (!$q) {
            gagal($url, 'Id tidak ditemukan.');
        }


        $q['default_password'] = $default_password;
        $q['is_sertifikat'] = $is_sertifikat;
        $q['db'] = $db_i;
        $q['key_jwt'] = $key_jwt;
        $q['hasil_pemilu'] = $hasil_pemilu;
        $q['pemilu_dimulai'] = $pemilu_dimulai;


        $db->where('id', $id);
        if ($db->update($q)) {
            sukses($url, 'Data sukses diupdate.');
        } else {
            gagal($url, 'Data gagal diupdate.');
        }
    }
}
