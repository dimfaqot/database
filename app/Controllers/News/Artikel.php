<?php


namespace App\Controllers\News;

use App\Controllers\BaseController;

class Artikel extends BaseController
{
    function __construct()
    {
        helper('functions');
        if (!session('id')) {
            gagal(base_url('login'), 'Anda belum login.');
        }
        check_role();
    }
    public function index($filer, $val, $page, $col, $asc): string
    {
        $db = db('artikel', 'news');

        $limit = 0;
        $db;
        if ($page !== 'All') {
            $limit = $page * 50;
            $db->limit($limit);
        }

        if ($val !== 'All') {
            $db->where($filer, $val);
        }

        $q = $db->get()->getResultArray();

        $db;

        if ($val !== 'All') {
            $db->where($filer, $val);
        }

        $total = $db->countAllResults();


        $short_by = ($asc == 'ASC' ? SORT_ASC : SORT_DESC);

        $keys = array_column($q, $col);
        array_multisort($keys, $short_by, $q);


        $data = [
            'status' => '200',
            'total_data' => $total,
            'data_ditampilkan' => ($limit == 0 ? $total : ($total < $limit ? $total : $limit)),
            'data' => $q
        ];

        $dbl = db('label', 'news');
        $lbl = $dbl->orderBy('label', 'ASC')->get()->getResultArray();

        return view('news/' . menu()['controller'], ['judul' => menu()['menu'], 'data' => $data, 'label' => $lbl]);
    }

    public function add()
    {
        $judul = upper_first($this->request->getVar('judul'));
        $label = clear($this->request->getVar('label'));
        $artikel = $this->request->getVar('artikel');
        $url = clear($this->request->getVar('url'));

        $slug = time() . '_' . strtolower(str_replace(" ", "_", remove_char(clear($judul))));

        $db = db('artikel', 'news');


        $file = $_FILES['gambar'];
        $img = '';

        if ($file['error'] == 4) {
            gagal($url, 'Gambar belum dipilih.');
        } else {
            if ($file['error'] == 0) {
                $size = $file['size'];

                if ($size > 2000000) {
                    gagal($url, 'Gagal!. Ukuran maksimal file 2MB.');
                }

                $ext = ['png', 'jpg', 'jpeg'];

                $exp = explode(".", $file['name']);
                $exe = strtolower(end($exp));

                if (array_search($exe, $ext) === false) {
                    gagal($url, 'Gagal!. Format file harus ' . implode(", ", $ext) . '.');
                }

                $gambar = 'berkas/news/' . $slug . '.' . $exe;

                if (!move_uploaded_file($file['tmp_name'], $gambar)) {
                    gagal($url, 'File gagal diupload.');
                }
                $img = $slug . '.' . $exe;
            } else {
                gagal($url, 'Something wrong.');
            }
        }

        $data = [
            'slug' => $slug,
            'tgl' => time(),
            'label' => $label,
            'penulis' => session('nama'),
            'username' => session('username'),
            'judul' => $judul,
            'artikel' => $artikel,
            'img' => $img,
            'created_at' => time(),
            'updated_at' => time(),
            'petugas' => session('nama')
        ];

        if ($db->insert($data)) {
            sukses($url, 'Data sukses disimpan.');
        } else {
            gagal($url, 'Data gagal disimpan.');
        }
    }

    public function update()
    {
        $id = clear($this->request->getVar('id'));
        $judul = upper_first($this->request->getVar('judul'));
        $label = clear($this->request->getVar('label'));
        $artikel = $this->request->getVar('artikel');
        $url = clear($this->request->getVar('url'));

        $db = db('artikel', 'news');

        $q = $db->where('id', $id)->get()->getRowArray();

        if (!$q) {
            gagal($url, 'Id tidak ditemukan.');
        }

        $file = $_FILES['gambar'];
        $img = $q['img'];
        $slug = $q['slug'];


        if ($file['error'] == 0) {
            $slug = time() . '_' . strtolower(str_replace(" ", "_", remove_char(clear($judul))));

            $size = $file['size'];

            if ($size > 2000000) {
                gagal($url, 'Gagal!. Ukuran maksimal file 2MB.');
            }

            $ext = ['png', 'jpg', 'jpeg'];

            $exp = explode(".", $file['name']);
            $exe = strtolower(end($exp));

            if (array_search($exe, $ext) === false) {
                gagal($url, 'Gagal!. Format file harus ' . implode(", ", $ext) . '.');
            }

            $gambar = 'berkas/news/' . $slug . '.' . $exe;

            if (!move_uploaded_file($file['tmp_name'], $gambar)) {
                gagal($url, 'File gagal diupload.');
            }

            if (!unlink('berkas/news/' . $q['img'])) {
                gagal($url, 'File lama gagal dihapus.');
            }

            $img = $slug . '.' . $exe;
        }



        $q['slug'] = $slug;
        $q['label'] = $label;
        $q['judul'] = $judul;
        $q['artikel'] = $artikel;
        $q['img'] = $img;
        $q['updated_at'] = time();
        $q['petugas'] = session('nama');

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

        $db = db('artikel', 'news');

        $q = $db->where('id', $id)->get()->getRowArray();

        if (!$q) {
            gagal_js('Id tidak ditemukan.');
        }

        unlink('berkas/news/' . $q['img']);

        $db->where('id', $id);
        if ($db->delete()) {
            sukses_js('Data berhasil dihapus.');
        } else {
            gagal_js('Data gagal dihapus.');
        }
    }
}
