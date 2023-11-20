<?php


namespace App\Controllers\Public;

use App\Controllers\BaseController;

class Piagam extends BaseController
{


    public function index($jwt)
    {
        $decode_jwt = decode_jwt($jwt);

        $db = db('piagam', get_db('piagam'));


        $data = [];
        foreach ($decode_jwt as $i) {

            $q = $db->where('id', $i)->get()->getRowArray();


            $th = db('tahun');
            $t = $th->where('tahun', $q['tahun'])->get()->getRowArray();

            $q['is_ttd'] = true;
            $q['ketua_ypp'] = $t['ketua_ypp'];
            $q['ttd_ketua_ypp'] = '<img width="110px" src="' .  'berkas/ttd/' . get_ttd($t['ketua_ypp']) . '" alt="Ttd"/>';
            if ($q['sub'] == 'Pondok') {
                $exp = explode(",", $q['nama']);
                $dbg = db('karyawan', get_db('karyawan'));
                $g = $dbg->where('nama', $exp[0])->get()->getRowArray();

                $pondok = ($g['gender'] == "L" ? 'putra' : 'putri');
                $kep = $t['kepala_' . strtolower($q['sub']) . '_' . $pondok];

                $q['kepala'] = $kep;
                $q['ttd_kepala'] = '<img width="110px" src="' .  'berkas/ttd/' . get_ttd($kep) . '" alt="Ttd"/>';
            } else {
                if ($q['sub'] == 'Yayasan') {
                    $q['kepala'] = $t['ketua_ypp'];
                    $q['ttd_kepala'] = '<img width="110px" src="' .  'berkas/ttd/' . get_ttd($t['ketua_ypp']) . '" alt="Ttd"/>';
                } else {
                    $q['kepala'] = $t['kepala_' . strtolower($q['sub'])];
                    $q['ttd_kepala'] = '<img width="110px" src="' .  'berkas/ttd/' . get_ttd($t['kepala_' . strtolower($q['sub'])]) . '" alt="Ttd"/>';
                }
            }


            $q['cover'] = '<img src="' .  'berkas/sertifikat/' . $q['jenis'] . '.jpg" alt="Piagam"/>';
            $q['img'] = 'berkas/sertifikat/' . $q['jenis'] . '.jpg';

            $data[] = $q;
        }


        $judul = 'Piagam ' . $data[0]['nama'];




        $set = [
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'L',
            'margin-left' => 20,
            'margin-right' => 20,
            'margin-top' => -0,
            'margin-bottom' => 0
        ];


        $mpdf = new \Mpdf\Mpdf($set);
        $mpdf->useSubstitutions = false;

        foreach ($data as $i) {
            $html = view('cetak/piagam', ['judul' => $judul, 'data' => $i]);

            $mpdf->AddPage();

            $mpdf->SetDefaultBodyCSS('background', "url(" . $i['img'] . ")");
            $mpdf->SetDefaultBodyCSS('background-image-resize', 6);
            $mpdf->WriteHTML($html);
        }


        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output($judul . '.pdf', 'I');
    }
}
