<?php


namespace App\Controllers\Public;

use App\Controllers\BaseController;

class Rental extends BaseController
{

    public function index($tahun = null, $bulan = null, $kategori = null)
    {
        if ($tahun == null) {
            $tahun = date('Y');
        }
        if ($bulan == null) {
            $bulan = date('m');
        }
        if ($kategori == null) {
            $kategori = 'Bus';
        }

        $db = db(strtolower($kategori), 'rental');

        $q = $db->where('kategori', $kategori)->orderBy('tgl', 'ASC')->get()->getResultArray();

        $data = [];

        $th = [];
        foreach ($q as $i) {
            if (!in_array(date('Y', $i['tgl']), $th)) {
                $th[] = date('Y', $i['tgl']);
            }
            if ($tahun == 'All' && $bulan == 'All') {
                $data[] = $i;
            } elseif ($tahun !== 'All' && $bulan !== 'All') {

                if (date('m', $i['tgl']) == $bulan && date('Y', $i['tgl']) == $tahun) {
                    $data[] = $i;
                }
            } elseif ($tahun == 'All' && $bulan !== 'All') {
                if (date('m', $i['tgl']) == $bulan) {
                    $data[] = $i;
                }
            } elseif ($tahun !== 'All' && $bulan == 'All') {
                if (date('Y', $i['tgl']) == $tahun) {
                    $data[] = $i;
                }
            }
        }

        return view('rental/landing', ['judul' => 'Walisongo Rental, Travel, and Tour', 'data' => $data, 'tahuns' => $th]);
    }
}
