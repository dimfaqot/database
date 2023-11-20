<?php


namespace App\Controllers\Root;

use App\Controllers\BaseController;

class Tahun extends BaseController
{

    function __construct()
    {
        helper('functions');
        if (!session('id')) {
            gagal(base_url('login'), 'Anda belum login.');
        }
        check_role();
    }

    public function add()
    {
        $tahun = clear($this->request->getVar('tahun'));
        $rapat = upper_first(clear($this->request->getVar('rapat')));
        $penetapan = upper_first(clear($this->request->getVar('penetapan')));
        $ketua_ypp = upper_first(clear($this->request->getVar('ketua_ypp')));
        $kop = strtolower(clear($this->request->getVar('kop')));
        $url = clear($this->request->getVar('url'));

        $exp_rapat = explode(" ", $rapat);
        $exp_penetapan = explode(" ", $penetapan);

        if (count($exp_rapat) !== 3) {
            gagal($url, 'gagal=tahun=Gagal!. Format tanggal rapat salah. Contoh: 12 Agustus 2023');
        }

        if (count($exp_penetapan) !== 3) {
            gagal($url, 'gagal=tahun=Gagal!. Format tanggal penetapan salah. Contoh: 12 Agustus 2023');
        }

        $db = db('tahun');
        $q = $db->where('tahun', $tahun)->get()->getRowArray();
        if ($q) {
            gagal($url, 'Tahun sudah ada.');
        }

        $data = [
            'tahun' => $tahun,
            'rapat' => $rapat,
            'penetapan' => $penetapan,
            'ketua_ypp' => $ketua_ypp,
            'kop' => $kop,
            'petugas' => session('nama')
        ];


        $q = $db->where('tahun', $tahun)->get()->getRowArray();

        if ($q) {
            session()->setFlashdata('open_modal', 'gagal=tahun=Gagal!. Tahun sudah ada.');
            header("Location: " . base_url('sk/All'));
            die;
        }

        if ($db->insert($data)) {
            session()->setFlashdata('open_modal', 'sukses=tahun');
            header("Location: " . base_url('sk/All'));
            die;
        } else {
            session()->setFlashdata('open_modal', 'gagal=tahun=Gagal!. Data gagal disimpan.');
            header("Location: " . base_url('sk/All'));
            die;
        }
    }

    public function update()
    {
        $id = clear($this->request->getVar('id'));
        $tahun = clear($this->request->getVar('tahun'));
        $rapat = upper_first(clear($this->request->getVar('rapat')));
        $penetapan = upper_first(clear($this->request->getVar('penetapan')));
        $ketua_ypp = upper_first(clear($this->request->getVar('ketua_ypp')));
        $kop = strtolower(clear($this->request->getVar('kop')));

        $exp_rapat = explode(" ", $rapat);
        $exp_penetapan = explode(" ", $penetapan);

        if (count($exp_rapat) !== 3) {
            $data = [
                'status' => '400',
                'message' => 'Gagal!. Format tanggal rapat salah. Contoh: 12 Agustus 2023.'
            ];
            echo json_encode($data);
            die;
        }
        if (count($exp_penetapan) !== 3) {
            $data = [
                'status' => '400',
                'message' => 'Gagal!. Format tanggal penetapan salah. Contoh: 12 Agustus 2023.'
            ];
            echo json_encode($data);
            die;
        }

        $db = db('tahun');
        $q = $db->where('tahun', $id)->get()->getRowArray();

        if (!$q) {
            $data = [
                'status' => '400',
                'message' => 'Gagal!. Id tidak ditemukan.'
            ];
            echo json_encode($data);
            die;
        }

        $q = $db->whereNotIn('tahun', [$id])->where('tahun', $tahun)->get()->getRowArray();
        if ($q) {
            $data = [
                'status' => '400',
                'message' => 'Gagal!. Tahun sudah ada.'
            ];
            echo json_encode($data);
            die;
        }


        $q['tahun'] = $tahun;
        $q['rapat'] = $rapat;
        $q['penetapan'] = $penetapan;
        $q['ketua_ypp'] = $ketua_ypp;
        $q['kop'] = $kop;
        $q['petugas'] = session('nama');


        $db->where('tahun', $id);
        if ($db->update($q)) {
            $data = [
                'status' => '200',
                'message' => 'Data sukses diupdate.'
            ];
        } else {
            $data = [
                'status' => '400',
                'message' => 'Gagal!. Tahun gagal diupdate.'
            ];
        }

        echo json_encode($data);
        die;
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
