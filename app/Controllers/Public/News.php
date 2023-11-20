<?php


namespace App\Controllers\Public;

use App\Controllers\BaseController;

class News extends BaseController
{

    public function single($slug): string
    {
        $db = db('artikel', 'news');
        $q = $db->where('slug', $slug)->get()->getRowArray();

        if (!$q) {
            header("Location: " . base_url());
            die;
        }

        $q['views'] = $q['views'] + 1;

        $db->where('id', $q['id']);
        $db->update($q);


        return view('news/single', ['judul' => $q['judul'], 'data' => $q]);
    }
    public function filter_by($col, $val): string
    {
        $db = db('artikel', 'news');
        $q = $db->where($col, $val)->get()->getResultArray();

        $col = ($col == 'username' ? 'penulis' : $col);
        $val = ($q && $col == 'penulis' ? $q[0]['penulis'] : $val);

        return view('news/filter_by', ['judul' => $val, 'col' => $col, 'data' => $q]);
    }
}
