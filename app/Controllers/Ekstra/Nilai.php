<?php


namespace App\Controllers\Ekstra;

use App\Controllers\BaseController;


class Nilai extends BaseController
{
    function __construct()
    {
        helper('functions');
        if (!session('id')) {
            gagal(base_url('login'), 'Anda belum login.');
        }
        check_role();
    }

    public function index($tahun, $ekstra)
    {

        $db = db(menu()['tabel'], get_db(menu()['tabel']));
        $q = $db->where('singkatan', $ekstra)->orderBy('ekstra', 'ASC')->orderBy('nama', 'ASC')->orderBy('no_urut', 'ASC')->groupBy('kode')->get()->getResultArray();

        $data = [];

        $tahuns = [];
        foreach ($q as $i) {
            if (date('Y', $i['tgl']) == $tahun) {
                $data[] = $i;
            }

            if (!in_array(date('Y', $i['tgl']), $tahuns)) {
                $tahuns[] = date('Y', $i['tgl']);
            }
        }

        $e = db('ekstra', 'ekstra');
        $eks = $e->orderBy('ekstra', 'ASC')->get()->getResultArray();

        return view('ekstra/' . menu()['controller'], ['judul' => menu()['menu'], 'data' => $q, 'tahun' => $tahuns, 'ekstra' => $eks]);
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

    public function update_blur()
    {
        $col = clear($this->request->getVar('col'));
        $id = str_replace("_", "/", clear($this->request->getVar('id')));
        $key = clear($this->request->getVar('key'));
        $tabel = clear($this->request->getVar('tabel'));
        $db = clear($this->request->getVar('db'));
        $val = clear($this->request->getVar('val'));


        $db = db($tabel, $db);

        $q = $db->where('kode', $id)->get()->getResultArray();

        foreach ($q as $i) {
            $i['kelas'] = $val;

            $db->where('id', $i['id']);
            $db->update($i);
        }

        sukses_js('Data berhasil diinput.');
    }
    public function detail_js()
    {

        $id = str_replace("_", "/", clear($this->request->getVar('id')));


        $db = db('nilai', 'ekstra');

        $q = $db->where('kode', $id)->get()->getResultArray();

        if (!$q) {
            gagal_js('Id tidak ditemukan!.');
        }


        sukses_js('Data berhasil diinput.', $q);
    }
    public function update_nilai()
    {

        $id = clear($this->request->getVar('id'));
        $val = clear($this->request->getVar('val'));


        $db = db('nilai', 'ekstra');

        $q = $db->where('id', $id)->get()->getRowArray();

        if (!$q) {
            gagal_js('Id tidak ditemukan!.');
        }

        $q['nilai'] = $val;


        $db->where('id', $id);
        if ($db->update($q)) {
            sukses_js('Data berhasil diupdate.');
        } else {
            sukses_js('Data gagal diupdate.');
        }
    }



    public function delete()
    {
        $id = str_replace("_", "/", clear($this->request->getVar('id')));

        $db = db(menu()['tabel'], get_db(menu()['tabel']));

        $q = $db->where('kode', $id)->get()->getResultArray();

        if (!$q) {
            gagal_js('Id tidak ditemukan.');
        }

        foreach ($q as $k => $i) {

            $db->where('id', $i['id']);
            $db->delete();
        }

        sukses_js('Data sukses didelete');
    }
}
