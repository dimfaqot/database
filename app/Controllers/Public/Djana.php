<?php


namespace App\Controllers\Public;

use App\Controllers\BaseController;

class Djana extends BaseController
{

    public function index($tahun = null, $bulan = null)
    {
        $data = get_laporan(($tahun == null ? date('Y') : $tahun), ($bulan == null ? date('m') : $bulan));
        $nota = get_nota(($tahun == null ? date('Y') : $tahun), ($bulan == null ? date('m') : $bulan));

        return view('djana/landing', ['judul' => 'Djana', 'data' => $data, 'statistik' => get_statistik(($tahun == null ? date('Y') : $tahun), ($bulan == null ? date('m') : $bulan), 'All'), 'nota' => $nota]);
    }

    public function nota($jwt)
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
}
