<?php

namespace App\Controllers\Djana;

use App\Controllers\BaseController;

class Nota extends BaseController
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
        $data = get_nota($tahun, $bulan);
        return view('djana/' . menu()['controller'], ['judul' => menu()['menu'], 'data' => $data['data'], 'tahun' => $data['tahun']]);
    }

    public function update_qty()
    {

        $id = clear($this->request->getVar('id'));
        $harga = clear($this->request->getVar('harga'));
        $val = clear($this->request->getVar('val'));

        $db = db('nota', get_db('nota'));

        $q = $db->where('id', $id)->get()->getRowArray();
        if (!$q) {
            gagal_js('Id tidak ditemukan.');
        }
        $q['qty'] = (int)$val;

        $db->where('id', $id);
        if ($db->update($q)) {
            sukses_js('Data sukses diupdate.');
        } else {
            gagal_js('Data gagal diupdate.');
        }
    }

    public function cetak($jwt)
    {
        $val = decode_jwt($jwt);

        $data = get_nota('', '', $val[0]);

        $judul = 'NOTA NOMOR ' . $val[0];

        $set = [
            'mode' => 'utf-8',
            'format' => [200, 165],
            'orientation' => 'L',
            'margin-left' => 10,
            'margin-right' => 10,
            'margin-top' => 0,
            'margin-bottom' => 0,
        ];

        $mpdf = new \Mpdf\Mpdf($set);
        $logo = '<img width="80px" src="' .  'berkas/djana/logo.png" alt="Logo Djana"/>';
        $html = view('djana/cetak_nota', ['judul' => $judul, 'data' => $data, 'logo' => $logo, 'jwt' => $jwt]);
        $mpdf->AddPage();
        $mpdf->WriteHTML($html);


        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output($judul . '.pdf', 'I');
    }

    public function cari_barang()
    {
        $db = db('pesanan', 'djana');

        $text = clear($this->request->getVar('text'));

        $q = $db->like('barang', $text, 'both')->orderBy('barang', 'ASC')->limit(10)->get()->getResultArray();
        $data = [];
        foreach ($q as $i) {
            $i['tgl_order'] = date('d/m/Y', $i['tgl_order']);
            $data[] = $i;
        }

        sukses_js('Koneksi sukses.', $data);
    }
    public function create()
    {
        $db = db('pesanan', 'djana');
        $time = time();
        $data = json_decode(json_encode($this->request->getVar('data')), true);
        $no_nota = last_no_nota($time);

        foreach ($data as $i) {
            $q = $db->where('id', $i['id'])->get()->getRowArray();

            if ($q) {
                $val = [
                    'no_nota' => $no_nota,
                    'tgl' => $q['tgl_order'],
                    'pembeli' => $q['pemesan'],
                    'barang_id' => $q['id'],
                    'barang' => $q['barang'],
                    'harga' => round($q['jml_lunas'] / $i['qty']),
                    'qty' => $i['qty'],
                    'jml' => $q['jml_lunas'],
                    'teller' => upper_first($q['penerima_order']),
                    'petugas' => upper_first(session('username'))
                ];
                $d = db('nota', 'djana');
                $d->insert($val);
            }
        }

        sukses_js('Koneksi sukses.');
    }
}
