<?php


namespace App\Controllers\Ekstra;

use App\Controllers\BaseController;


class Mapel extends BaseController
{


    function __construct()
    {
        helper('functions');
        if (!session('id')) {
            gagal(base_url('login'), 'Anda belum login.');
        }
        check_role();
    }

    public function index($singkatan)
    {
        $db = db(menu()['tabel'], get_db(menu()['tabel']));
        $q = $db->where('singkatan', $singkatan)->orderBy('no_urut', 'ASC')->get()->getResultArray();

        $db = db('ekstra', get_db('ekstra'));
        $ekstra = $db->orderBy('ekstra', 'ASC')->get()->getResultArray();
        return view('ekstra/' . menu()['controller'], ['judul' => menu()['menu'], 'data' => $q, 'ekstra' => $ekstra]);
    }

    public function add()
    {
        $ekstra = clear($this->request->getVar('ekstra'));
        $no_urut = clear($this->request->getVar('no_urut'));
        $mapel = upper_first(clear($this->request->getVar('mapel')));
        $sks = clear($this->request->getVar('sks'));

        $eks = db('ekstra', get_db('ekstra'));

        $db_ekstra = $eks->where('singkatan', $ekstra)->get()->getRowArray();

        $data = [
            'ekstra' => $db_ekstra['ekstra'],
            'singkatan' => $db_ekstra['singkatan'],
            'kepala' => $db_ekstra['kepala'],
            'no_urut' => $no_urut,
            'mapel' => $mapel,
            'sks' => $sks
        ];

        $db = db(menu()['tabel'], get_db(menu()['tabel']));

        if ($db->insert($data)) {
            sukses(base_url(menu()['controller']) . '/' . $ekstra, 'Data berhasil dimasukkan.');
        } else {
            sukses(base_url(menu()['controller']) . '/' . $ekstra, 'Data gagal dimasukkan.');
        }
    }

    public function update()
    {
        $id = clear($this->request->getVar('id'));
        $ekstra = clear($this->request->getVar('ekstra'));
        $no_urut = clear($this->request->getVar('no_urut'));
        $mapel = upper_first(clear($this->request->getVar('mapel')));
        $sks = clear($this->request->getVar('sks'));

        $url = base_url(menu()['controller']) . '/' . $ekstra;


        $db = db(menu()['tabel'], get_db(menu()['tabel']));

        $q = $db->where('id', $id)->get()->getRowArray();

        if (!$q) {
            gagal($url, 'Id tidak ditemukan.');
        }

        $eks = db('ekstra', get_db('ekstra'));

        $db_ekstra = $eks->where('ekstra', $ekstra)->get()->getRowArray();

        if ($ekstra !== $q['ekstra']) {
            $q['ekstra'] = $db_ekstra['ekstra'];
            $q['singkatan'] = $db_ekstra['singkatan'];
            $q['kepala'] = $ekstra['kepala'];
        }

        $q['no_urut'] = $no_urut;
        $q['mapel'] = $mapel;
        $q['sks'] = $sks;

        $db->where('id', $id);
        if ($db->update($q)) {
            sukses($url, 'Data berhasil diupdate.');
        } else {
            sukses($url, 'Data gagal diupdate.');
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
            sukses_js('Data berhasil didelete.');
        } else {
            gagal_js('Data gagal didelete.');
        }
    }
}
