<?php


namespace App\Controllers\Public;

use App\Controllers\BaseController;

class Sertifikat extends BaseController
{


    public function index()
    {
        return view('sertifikat/landing', ['judul' => 'Sertifikat dan Piagam']);
    }

    public function get_data()
    {
        $text = clear($this->request->getVar('text'));
        $jenis = clear($this->request->getVar('jenis'));

        $tabel = strtolower($jenis);

        if ($jenis == 'Ssj') {
            $tabel = 'pilangsari';
        }

        $db = db($tabel, get_db($tabel));

        if ($tabel == 'pilangsari') {

            $q = $db->like('nama', $text, 'both')->where('jenis', 'SSJ')->where('ket', 1)->orderBy('nama', 'ASC')->limit(10)->get()->getResultArray();

            $data = [];

            foreach ($q as $i) {
                $i['url'] = base_url('public/pilangsari/') . encode_jwt([$i['no']]);
                $data[] = $i;
            }
        } else {
            $q = $db->like('nama', $text, 'both')->orderBy('nama', 'ASC')->limit(10)->get()->getResultArray();
            $data = [];

            foreach ($q as $i) {
                $i['url'] = base_url('public/') . $tabel . '/' . encode_jwt([$i['id']]);
                $data[] = $i;
            }
        }


        sukses_js('Koneksi sukses.', $data);
    }
}
