<?php


namespace App\Controllers\Public;

use App\Controllers\BaseController;


class Ekstra extends BaseController
{

    public function index($ekstra = null)
    {
        $ekstra = ($ekstra == null ? 'Multimedia' : str_replace("-", " ", $ekstra));
        $db = db('nilai', 'ekstra');
        $db;
        if ($ekstra !== 'All') {
            $db->where('ekstra', $ekstra);
        }
        $q = $db->orderBy('ekstra', 'ASC')->orderBy('nama', 'ASC')->orderBy('no_urut', 'ASC')->groupBy('kode')->get()->getResultArray();


        $e = db('ekstra', 'ekstra');
        $ekstras = $e->orderBy('ekstra', 'ASC')->get()->getResultArray();
        return view('ekstra/landing', ['judul' => 'Ekstrakurikuler', 'data' => $q, 'ekstra' => str_replace(" ", "-", $ekstra), 'ekstras' => $ekstras]);
    }

    public function cetak($jwt)
    {
        $decode_jwt = decode_jwt($jwt);

        $db = db('nilai', 'ekstra');

        $data = [];
        foreach ($decode_jwt as $i) {

            $q = $db->where('kode', $i)->get()->getResultArray();
            $img1 = 'berkas/ekstra/sertifikat1.jpg';
            $img2 = 'berkas/ekstra/sertifikat2.jpg';

            if ($q) {
                $q[0]['link_qr_code'] = $q[0]['qr_code'];
                $q[0]['qr_code'] = '<img width="80px" src="' .  $q[0]['qr_code'] . '" alt="QR CODE"/>';
            }
            $data[] = ['bg_img' => $img1, 'data' => $q, 'profile' => ($q ? $q[0] : [])];
            $data[] = ['bg_img' => $img2, 'data' => $q, 'profile' => ($q ? $q[0] : [])];
        }

        $judul = 'Sertifikat Ekstra';
        if (count($decode_jwt) == 1) {
            $judul = 'Sertifikat Ekstra ' . $data[0]['profile']['ekstra'] . ' ' . $data[0]['profile']['nama'];
        }


        $set = [
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            'margin-left' => 20,
            'margin-right' => 20,
            'margin-top' => -0,
            'margin-bottom' => 0
        ];

        $mpdf = new \Mpdf\Mpdf($set);
        $mpdf->useSubstitutions = false;

        foreach ($data as $k => $i) {
            $html = view('cetak/ekstra', ['judul' => $judul, 'data' => $i, 'k' => $k]);
            $mpdf->AddPage();

            $img = 'berkas/ekstra/sertifikat' . ($k % 2 == 0 ? '1' : '2') . '.jpg';
            $mpdf->SetDefaultBodyCSS('background', "url(" . $img . ")");
            $mpdf->SetDefaultBodyCSS('background-image-resize', 6);
            $mpdf->WriteHTML($html);
            $html = view('cetak/ekstra', ['judul' => $judul, 'data' => $i]);
        }


        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output($judul . '.pdf', 'I');
    }

    public function sertifikat()
    {
    }
}
