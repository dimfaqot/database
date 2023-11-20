<?php


namespace App\Controllers\Public;

use App\Controllers\BaseController;

class Pilangsari extends BaseController
{

    public function index($jwt)
    {
        $decode = decode_jwt($jwt);

        $db = db('pilangsari', 'sertifikat');
        $q = $db->where('no', $decode[0])->get()->getRowArray();


        $q = $db->where('no', $decode[0])->get()->getRowArray();
        $q['img'] = 'berkas/sertifikat/Pilangsari.jpg';


        $judul = 'SSJ ' . $q['nama'];


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


        $html = view('cetak/pilangsari', ['judul' => $judul, 'data' => $q]);

        $mpdf->AddPage();

        $mpdf->SetDefaultBodyCSS('background', "url(" . $q['img'] . ")");
        $mpdf->SetDefaultBodyCSS('background-image-resize', 6);
        $mpdf->WriteHTML($html);



        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output($judul . '.pdf', 'I');
    }
}
