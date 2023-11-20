<?php

namespace App\Controllers\Djana;

use App\Controllers\BaseController;

class Pesanan extends BaseController
{
    function __construct()
    {
        helper('functions');
        if (!session('id')) {
            gagal(base_url('login'), 'Anda belum login.');
        }
        check_role();
    }
    public function index($tahun, $bulan): string
    {

        return view('djana/' . menu()['controller'], ['judul' => menu()['menu'], 'data' => get_pesanan($tahun, $bulan)]);
    }

    public function data_belum()
    {
        sukses_js('Koneksi sukses', get_data_belum(menu()['controller']));
    }
    public function add()
    {

        $url = clear($this->request->getVar('url'));
        $tgl_order = strtotime(clear($this->request->getVar('tgl_order')));
        $deadline = clear($this->request->getVar('deadline'));
        $barang = upper_first(clear($this->request->getVar('barang')));
        $penerima_order = clear($this->request->getVar('penerima_order'));
        $pemesan = upper_first(clear($this->request->getVar('pemesan')));
        $catatan_order = upper_first(clear($this->request->getVar('catatan_order')));

        if ($deadline == '-') {
            $deadline = 0;
        } else {
            $exp = explode("/", $deadline);
            $deadline = strtotime($exp[2] . '-' . $exp[1] . '-' . $exp[0]);
        }

        $data = [
            'tgl_order' => $tgl_order,
            'deadline' => $deadline,
            'barang' => $barang,
            'penerima_order' => $penerima_order,
            'pemesan' => $pemesan,
            'catatan_order' => $catatan_order,
            'created_at' => time(),
            'updated_at' => time()
        ];


        $db = db(menu()['tabel'], get_db(menu()['tabel']));

        if ($db->insert($data)) {
            sukses($url, 'Data berhasil disimpan.');
        } else {
            gagal($url, 'Data gagal disimpan.');
        }
    }

    public function update()
    {

        $id = clear($this->request->getVar('id'));

        $db = db(menu()['tabel'], get_db(menu()['tabel']));
        $url = clear($this->request->getVar('url'));
        $q = $db->where('id', $id)->get()->getRowArray();
        if (!$q) {
            gagal($url, 'Id tidak ditemukan.');
        }


        $is_inv = (clear($this->request->getVar('is_inv')) == 'on' ? 1 : 0);
        $tgl_order = strtotime(clear($this->request->getVar('tgl_order')));
        $barang = upper_first(clear($this->request->getVar('barang')));
        $penerima_order = clear($this->request->getVar('penerima_order'));
        $pj_order = clear($this->request->getVar('pj_order'));
        $deadline = clear($this->request->getVar('deadline'));
        $pemesan = upper_first(clear($this->request->getVar('pemesan')));
        $catatan_order = upper_first(clear($this->request->getVar('catatan_order')));

        $tgl_dp = clear($this->request->getVar('tgl_dp'));
        $jml_dp = rp_to_int(clear($this->request->getVar('jml_dp')));
        $pj_dp = clear($this->request->getVar('pj_dp'));
        $catatan_dp = upper_first(clear($this->request->getVar('catatan_dp')));

        $tgl_lunas = clear($this->request->getVar('tgl_lunas'));
        $jml_lunas = rp_to_int(clear($this->request->getVar('jml_lunas')));
        $pj_lunas = clear($this->request->getVar('pj_lunas'));
        $catatan_lunas = upper_first(clear($this->request->getVar('catatan_lunas')));


        $tgl = clear($this->request->getVar('tgl'));
        $jml = rp_to_int(clear($this->request->getVar('jml')));
        $penerima = clear($this->request->getVar('penerima'));
        $catatan = upper_first(clear($this->request->getVar('catatan')));


        $deadline = check_tgl($q['deadline'], $deadline);
        $tgl_dp = check_tgl($q['tgl_dp'], $tgl_dp);
        $tgl_lunas = check_tgl($q['tgl_lunas'], $tgl_lunas);
        $tgl = check_tgl($q['tgl'], $tgl);

        $q['is_inv'] = $is_inv;
        $q['tgl_order'] = $tgl_order;
        $q['barang'] = $barang;
        $q['penerima_order'] = $penerima_order;
        $q['pj_order'] = $pj_order;
        $q['deadline'] = $deadline;
        $q['pemesan'] = $pemesan;
        $q['catatan_order'] = $catatan_order;

        $q['tgl_dp'] = $tgl_dp;
        $q['jml_dp'] = $jml_dp;
        $q['pj_dp'] = $pj_dp;
        $q['catatan_dp'] = $catatan_dp;

        $q['tgl_lunas'] = $tgl_lunas;
        $q['jml_lunas'] = $jml_lunas;
        $q['pj_lunas'] = $pj_lunas;
        $q['catatan_lunas'] = $catatan_lunas;

        $q['tgl'] = $tgl;
        $q['jml'] = $jml;
        $q['penerima'] = $penerima;
        $q['catatan'] = $catatan;

        $q['updated_at'] = time();

        $db->where('id', $id);
        if ($db->update($q)) {
            sukses($url, 'Data berhasil diupdate.');
        } else {
            gagal($url, 'Data gagal diupdate.');
        }
    }
    public function selesai()
    {

        $id = clear($this->request->getVar('id'));

        $db = db(menu()['tabel'], get_db(menu()['tabel']));
        $q = $db->where('id', $id)->get()->getRowArray();
        if (!$q) {
            gagal_js('Id tidak ditemukan!.');
        }

        $q['selesai'] = ($q['selesai'] == 0 ? 1 : 0);
        $q['updated_at'] = time();

        $db->where('id', $id);
        if ($db->update($q)) {
            sukses_js('Data berhasil diupdate.');
        } else {
            gagal_js('Data gagal diupdate.');
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
            gagal_js('Data berhasil dihapus.');
        }
    }
    public function detail_js()
    {

        $id = $this->request->getVar('id');
        $tabel = $this->request->getVar('tabel');

        $db = db($tabel, get_db($tabel));

        $q = $db->where('id', $id)->get()->getRowArray();
        if (!$q) {
            gagal_js('Id tidak ditemukan.');
        }
        $q['status'] = get_status($q);
        $q['icon'] = get_icon(get_status($q))['icon'];
        $q['tgl_order'] = ($q['tgl_order'] == 0 ? '-' : date('d/m/Y', $q['tgl_order']));
        $q['tgl_dp'] = ($q['tgl_dp'] == 0 ? '-' : date('d/m/Y', $q['tgl_dp']));
        $q['tgl_lunas'] = ($q['tgl_lunas'] == 0 ? '-' : date('d/m/Y', $q['tgl_lunas']));
        $q['tgl'] = ($q['tgl'] == 0 ? '-' : date('d/m/Y', $q['tgl']));

        sukses_js('Koneksi sukses', $q);
    }

    public function insert_to_laporan()
    {
        $data = json_decode(json_encode($this->request->getVar('data')), true);

        $dbl = db('laporan', 'djana');
        $db = db('pesanan', 'djana');

        $tgl_laporan = time();

        foreach ($data as $i) {
            $q = $dbl->where('barang_id', $i)->get()->getRowArray();
            if (!$q) {
                $d = $db->where('id', $i)->get()->getRowArray();

                $val = [
                    'tgl_laporan' => $tgl_laporan,
                    'tgl' => $d['tgl_order'],
                    'barang' => $d['barang'],
                    'barang_id' => $d['id'],
                    'keluar' => $d['jml_lunas'],
                    'masuk' => $d['jml'],
                    'created_at' => time(),
                    'updated_at' => time()
                ];
                $dbl->insert($val);
            }
        }

        sukses_js('Data berhasil diinsert.');
    }

    public function add_image()
    {
        $url = clear($this->request->getVar('url'));
        $folder = clear($this->request->getVar('folder'));
        add_image($_FILES['file'], $url, $folder);
    }
    public function delete_file()
    {
        $dir = clear($this->request->getVar('dir'));

        if (unlink($dir)) {
            sukses_js('File berhasil dihapus.');
        } else {
            gagal_js('File gagal dihapus.');
        }
    }
}
