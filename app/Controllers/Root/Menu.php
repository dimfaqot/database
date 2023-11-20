<?php


namespace App\Controllers\Root;

use App\Controllers\BaseController;

class Menu extends BaseController
{

    function __construct()
    {
        helper('functions');
        if (!session('id')) {
            gagal(base_url('login'), 'Anda belum login.');
        }
        check_role();
    }

    public function index($menu_role)
    {
        $db = db(menu()['tabel']);

        $menu_roles = $db->select('section')->groupBy('section')->orderBy('section', 'ASC')->get()->getResultArray();

        $db;
        if ($menu_role !== 'All') {
            $db->where('section', $menu_role);
        }

        $data = $db->orderBy('section', 'ASC')->orderBy('no_urut', 'ASC')->get()->getResultArray();
        return view('root/' .  menu()['controller'], ['judul' => menu()['menu'], 'data' => $data, 'menu_roles' => $menu_roles, 'menu_role' => $menu_role]);
    }

    public function add()
    {
        $section = upper_first(clear($this->request->getVar('section')));
        $role = upper_first(clear($this->request->getVar('role')));
        $menu = upper_first(clear($this->request->getVar('menu')));
        $tabel = strtolower(clear($this->request->getVar('tabel')));
        $icon = strtolower(clear($this->request->getVar('icon')));
        $controller = strtolower(clear($this->request->getVar('controller')));
        $no_urut = clear($this->request->getVar('no_urut'));

        $db = db('menu');

        $q = $db->where('section', $section)->where('role', $role)->orderBy('no_urut', 'DESC')->get()->getRowArray();
        $no_urut = 1;
        if ($q) {
            $no_urut = $q['no_urut'] + 1;
        }

        $file = $_FILES['logo'];


        $url = base_url() . menu()['controller'] . '/' . $section;

        $logo = 'file_not_found.jpg';
        if ($file['error'] !== 4) {

            if ($file['error'] == 0) {
                $size = $file['size'];

                if ($size > 2000000) {
                    session()->setFlashdata('gagal', 'Gagal!. Ukuran maksimal file 2MB.');
                    header("Location: " . $url);
                    die;
                }

                $ext = ['png'];

                $exp = explode(".", $file['name']);
                $exe = strtolower(end($exp));

                if (array_search($exe, $ext) === false) {
                    session()->setFlashdata('gagal', 'Gagal!. Format file harus ' . implode(", ", $ext) . '.');
                    header("Location: " . $url);
                    die;
                }

                $gambar = 'berkas/' . menu()['controller'] . '/' . strtolower($menu) . '.png';

                if (!move_uploaded_file($file['tmp_name'], $gambar)) {
                    session()->setFlashdata('gagal', 'File gagal diupload!.');
                    header("Location: " . $url);
                    die;
                }
                $logo = strtolower($menu) . '.png';
            }
        }

        $data = [
            'section' => $section,
            'role' => $role,
            'menu' => $menu,
            'tabel' => $tabel,
            'controller' => $controller,
            'icon' => $icon,
            'no_urut' => $no_urut,
            'logo' => $logo,
            'created_at' => time(),
            'updated_at' => time(),
            'petugas' => session('nama')
        ];


        $q = $db->where('section', $section)->where('role', $role)->where('menu', $menu)->get()->getRowArray();

        if ($q) {
            gagal($url, 'Menu sudah ada.');
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
        $section = upper_first(clear($this->request->getVar('section')));
        $role = upper_first(clear($this->request->getVar('role')));
        $menu = upper_first(clear($this->request->getVar('menu')));
        $tabel = strtolower(clear($this->request->getVar('tabel')));
        $controller = strtolower(clear($this->request->getVar('controller')));
        $icon = strtolower(clear($this->request->getVar('icon')));
        $no_urut = clear($this->request->getVar('no_urut'));
        $file = $_FILES['logo'];

        $url = base_url() . menu()['controller'] . '/' . $section;

        $db = db(menu()['tabel']);

        $q = $db->where('id', $id)->get()->getRowArray();

        if (!$q) {
            gagal($url, 'Id tidak ditemukan.');
        }

        $exist = $db->whereNotIn('id', [$id])->where('section', $section)->where('role', $role)->where('menu', $menu)->get()->getRowArray();
        if ($exist) {
            gagal($url, 'Menu sudah ada.');
        }

        $logo = $q['logo'];
        if ($file['error'] !== 4) {
            $dir = 'berkas/' . menu()['controller'] . '/';
            if ($file['error'] == 0) {

                if ($q['logo'] !== 'file_not_found.jpg') {
                    if (!unlink($dir . strtolower($menu) . '.png')) {
                        gagal($url, 'File lama gagal dihapus.');
                    }
                }


                $size = $file['size'];

                if ($size > 2000000) {
                    session()->setFlashdata('gagal', 'Gagal!. Ukuran maksimal file 2MB.');
                    header("Location: " . $url);
                    die;
                }

                $ext = ['png'];

                $exp = explode(".", $file['name']);
                $exe = strtolower(end($exp));

                if (array_search($exe, $ext) === false) {
                    session()->setFlashdata('gagal', 'Gagal!. Format file harus ' . implode(", ", $ext) . '.');
                    header("Location: " . $url);
                    die;
                }

                $gambar = $dir . strtolower($menu) . '.png';

                if (!move_uploaded_file($file['tmp_name'], $gambar)) {
                    session()->setFlashdata('gagal', 'File gagal diupload!.');
                    header("Location: " . $url);
                    die;
                }
                $logo = strtolower($menu) . '.png';
            }
        }

        $q['section'] = $section;
        $q['role'] = $role;
        $q['menu'] = $menu;
        $q['tabel'] = $tabel;
        $q['controller'] = $controller;
        $q['icon'] = $icon;
        $q['no_urut'] = $no_urut;
        $q['logo'] = $logo;
        $q['updated_at'] = time();
        $q['petugas'] = session('nama');

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
        $section = upper_first(clear($this->request->getVar('section')));
        $role = upper_first(clear($this->request->getVar('role')));
        $section_now = clear($this->request->getVar('section_now'));

        $url = base_url() . menu()['controller'] . '/' . $section;
        $db = db(menu()['tabel']);

        $q = $db->where('id', $id)->get()->getRowArray();

        if (!$q) {
            gagal(base_url(menu()['controller']) . '/' . $section_now, 'Id tidak ditemukan.');
        }

        $exist = $db->where('section', $section)->where('role', $role)->where('menu', $q['menu'])->get()->getRowArray();
        if ($exist) {
            gagal(base_url(menu()['controller']) . '/' . $section_now, 'Menu sudah ada.');
        }

        $no_urut = 1;
        $last = $db->where('section', $section)->where('role', $role)->orderBy('no_urut', 'DESC')->get()->getRowArray();
        if ($last) {
            $no_urut = $last['no_urut'] + 1;
        }
        $data = [
            'section' => $section,
            'role' => $role,
            'menu' => $q['menu'],
            'tabel' => $q['tabel'],
            'controller' => $q['controller'],
            'icon' => $q['icon'],
            'logo' => 'file_not_found.jpg',
            'no_urut' => $no_urut,
            'created_at' => time(),
            'updated_at' => time(),
            'petugas' => session('nama')
        ];

        if ($db->insert($data)) {
            sukses($url, 'Data sukses dicopy.');
        } else {
            gagal($url, 'Data gagal dicopy.');
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

        $dir = 'berkas/' . menu()['controller'] . '/';
        if ($q['logo'] !== 'file_not_found.jpg') {
            if (!unlink($dir . $q['logo'])) {
                gagal_js('File gagal dihapus.');
            }
        }


        $db->where('id', $id);
        if ($db->delete()) {
            sukses_js('Data berhasil dihapus.');
        } else {
            gagal_js('Data gagal dihapus.');
        }
    }
}
