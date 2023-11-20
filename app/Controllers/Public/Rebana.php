<?php


namespace App\Controllers\Public;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Rebana extends BaseController
{

    public function index($tahun = null, $bulan = null): string
    {
        $tahun = ($tahun == null ? date('Y') : $tahun);
        $bulan = ($bulan == null ? date('m') : $bulan);
        $db = db('rebana', 'rebana');
        $q = $db->orderBy('tgl', 'ASC')->get()->getResultArray();

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
        return view('rebana/landing', ['judul' => 'Rebana Walisongo Sragen', 'data' => $data, 'tahun' => $tahun, 'bulan' => ($bulan == 'All' ? 'All' : bulan($bulan)['bulan']), 'tahuns' => $th]);
    }


    public function cetak($tahun, $bulan, $order)
    {
        $db = db('rebana', get_db('rebana'));
        $q = $db->orderBy('tgl', 'ASC')->get()->getResultArray();

        $data = [];
        $bl_th = [];
        foreach ($q as $i) {
            if ($tahun == 'All' && $bulan == 'All') {
                $text = bulan(date('m', $i['tgl']))['bulan'] . '_' . date('Y', $i['tgl']);
                if (!in_array($text, $bl_th)) {
                    $bl_th[] = $text;
                }
                $i['bl_th'] = $text;
                $data[] = $i;
            } elseif ($tahun !== 'All' && $bulan !== 'All') {

                if (date('m', $i['tgl']) == $bulan && date('Y', $i['tgl']) == $tahun) {
                    $text = bulan(date('m', $i['tgl']))['bulan'] . '_' . date('Y', $i['tgl']);
                    if (!in_array($text, $bl_th)) {
                        $bl_th[] = $text;
                    }
                    $i['bl_th'] = $text;
                    $data[] = $i;
                }
            } elseif ($tahun == 'All' && $bulan !== 'All') {
                if (date('m', $i['tgl']) == $bulan) {
                    $text = bulan(date('m', $i['tgl']))['bulan'] . '_' . date('Y', $i['tgl']);
                    if (!in_array($text, $bl_th)) {
                        $bl_th[] = $text;
                    }
                    $i['bl_th'] = $text;
                    $data[] = $i;
                }
            } elseif ($tahun !== 'All' && $bulan == 'All') {
                if (date('Y', $i['tgl']) == $tahun) {
                    $text = bulan(date('m', $i['tgl']))['bulan'] . '_' . date('Y', $i['tgl']);
                    if (!in_array($text, $bl_th)) {
                        $bl_th[] = $text;
                    }
                    $i['bl_th'] = $text;
                    $data[] = $i;
                }
            }
        }

        $fix_data = [];
        $arr_bl_th = [];
        foreach ($bl_th as $i) {
            if (!in_array($i, $arr_bl_th)) {
                $arr_bl_th[] = $i;
                $temp_data = [];
                foreach ($data as $d) {
                    if ($d['bl_th'] == $i) {
                        $temp_data[] = $d;
                    }
                }
                $fix_data[] = ['bl_th' => $i, 'data' => $temp_data];
            }
        }
        if ($order == 'pdf') {
            $set = [
                'mode' => 'utf-8',
                'format' => [215, 330],
                'orientation' => 'P'
            ];

            $mpdf = new \Mpdf\Mpdf($set);
            foreach ($fix_data as $i) {
                $i['logo'] = '<img width="80" src="berkas/menu/rebana.png" alt="Logo"/>';
                // dd($i);
                $html = view('rebana/cetak_public', ['data' => $i]);
                $mpdf->AddPage();
                $mpdf->WriteHTML($html);
            }
            $this->response->setHeader('Content-Type', 'application/pdf');
            $mpdf->Output('Jadwal_Rebana.pdf', 'I');
        } else {
            $cols = ['tgl', 'jam', 'alamat', 'acara', 'keterangan'];

            $filename = 'Jadwal_Rebana.xlsx';

            $spreadsheet = new Spreadsheet();

            $sheet = $spreadsheet->getActiveSheet();

            $huruf = 'Z';

            foreach ($cols as $k => $c) {
                $huruf++;
                if ($k < 26) {
                    $sheet->setCellValue(substr($huruf, -1) . '1', upper_first(str_replace("_", " ", $c)));
                } else {
                    $sheet->setCellValue('A' . substr($huruf, -1) . '1', upper_first(str_replace("_", " ", $c)));
                }
            }

            $rows = 2;
            $huruf = 'Z';
            foreach ($data as $i) {
                foreach ($cols as $k => $c) {
                    $huruf++;
                    $val = $i[$c];
                    if ($c == 'tgl') {
                        $val = hari(date('l', $i['tgl']))['indo'] . ' ' . $i['pasaran'] . ', ' . date('d', $i['tgl']) . ' ' . bulan(date('m', $i['tgl']))['bulan'] . ' ' . date('Y', $i['tgl']);
                    }
                    if ($k < 26) {
                        $sheet->setCellValue(substr($huruf, -1) . $rows, $val);
                    } else {
                        $sheet->setCellValue('A' . substr($huruf, -1) . $rows, $val);
                    }
                }
                $huruf = 'Z';
                $rows++;
            }
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename=' . $filename);
            header('Cache-Control: maxe-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');

            exit;
        }
    }
}
