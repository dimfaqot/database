<?php


namespace App\Controllers\Root;

use App\Controllers\BaseController;

class User extends BaseController
{

    function __construct()
    {
        helper('functions');
        if (!session('id')) {
            gagal(base_url(), 'Anda belum login.');
        }
        check_role();
    }

    public function index($section)
    {

        $db = db(menu()['tabel']);

        $sections = $db->select('section')->groupBy('section')->orderBy('section', 'ASC')->get()->getResultArray();

        $db;
        if ($section !== 'All') {
            $db->where('section', $section);
        }
        $data = $db->orderBy('section', 'ASC')->orderBy('nama', 'ASC')->get()->getResultArray();
        return view('root/' .  menu()['controller'], ['judul' => menu()['menu'], 'data' => $data, 'section' => $section, 'sections' => $sections]);
    }

    public function add()
    {
        $nama = upper_first(clear($this->request->getVar('nama')));
        $username = strtolower(clear($this->request->getVar('username')));
        $section = clear($this->request->getVar('section'));
        $role = clear($this->request->getVar('role'));
        $gender = clear($this->request->getVar('gender'));

        $data = [
            'nama' => $nama,
            'username' => $username,
            'section' => $section,
            'role' => $role,
            'gender' => $gender,
            'password' => password_hash($section . '_' . $username, PASSWORD_DEFAULT),
            'created_at' => time(),
            'updated_at' => time(),
            'petugas' => session('nama')
        ];

        $url = base_url(menu()['controller']) . '/' . $section;
        $db = db(menu()['tabel']);

        $q = $db->where('username', $username)->get()->getRowArray();

        if ($q) {
            gagal($url, 'Username sudah ada.');
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
        $nama = upper_first($this->request->getVar('nama'));
        $username = strtolower(clear($this->request->getVar('username')));
        $section = clear($this->request->getVar('section'));
        $role = clear($this->request->getVar('role'));
        $gender = clear($this->request->getVar('gender'));

        $url = base_url(menu()['controller']) . '/' . $section;
        $db = db('user');

        $q = $db->where('id', $id)->get()->getRowArray();

        if (!$q) {
            gagal($url, 'Id tidak ditemukan.');
        }

        $exist = $db->whereNotIn('id', [$id])->whereNotIn('username', [''])->where('username', $username)->get()->getRowArray();

        if ($exist) {
            gagal($url, 'Username sudah ada.');
        }

        $q['nama'] = $nama;
        $q['username'] = $username;
        $q['section'] = $section;
        $q['role'] = $role;
        $q['gender'] = $gender;
        $q['updated_at'] = time();
        $q['petugas'] = session('nama');

        $db->where('id', $id);
        if ($db->update($q)) {
            sukses($url, 'Data sukses diupdate.');
        } else {
            gagal($url, 'Data gagal diupdate.');
        }
    }

    public function reset_password()
    {

        $id = $this->request->getVar('id');

        $db = db(menu()['tabel']);

        $q = $db->where('id', $id)->get()->getRowArray();

        if (!$q) {
            gagal_js('Id tidak ditemukan.');
        }



        $q['password'] = default_password();
        $q['updated_at'] = time();
        $q['petugas'] = session('nama');

        $db->where('id', $id);
        if ($db->update($q)) {
            sukses_js('Password sukses direset.');
        } else {
            gagal_js('Password gagal direset.');
        }
    }

    // public function add_data_from_api()
    // {
    //     $nama = upper_first(clear($this->request->getVar('nama')));
    //     $no_id = clear($this->request->getVar('no_id'));
    //     $gender = clear($this->request->getVar('gender'));
    //     $tabel_api = clear($this->request->getVar('tabel_api'));
    //     $role = upper_first($tabel_api);
    //     $bidang = 'Member';

    //     $data = [
    //         'nama' => $nama,
    //         'no_id' => $no_id,
    //         'role' => $role,
    //         'bidang' => $bidang,
    //         'gender' => $gender,
    //         'password' => password_hash(default_password(), PASSWORD_DEFAULT),
    //         'created_at' => time(),
    //         'updated_at' => time(),
    //         'petugas' => session('nama')
    //     ];

    //     $db = \Config\Database::connect();
    //     $db = $db->table(menu()['tabel']);

    //     $q = $db->where('no_id', $no_id)->get()->getRowArray();

    //     if ($q) {
    //         gagal_js('Username sudah ada.');
    //     }

    //     if ($db->insert($data)) {
    //         sukses_js('Data sukses disimpan.');
    //     } else {
    //         gagal_js('Data gagal disimpan.');
    //     }
    // }

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
