<?php


namespace App\Controllers\News;

use App\Controllers\BaseController;

class Landing extends BaseController
{

    public function index()
    {
        // if (session('id')) {
        //     header("Location: " . base_url('home'));
        //     die;
        // }


        return view('news/landing', ['judul' => 'Ponpes Walisongo Sragen']);
    }
    public function login()
    {
        if (session('id')) {
            header("Location: " . base_url('home'));
            die;
        }
        return view('news/login', ['judul' => 'Ponpes Walisongo Sragen']);
    }

    public function proses_login()
    {
        $username = clear($this->request->getVar('username'));
        $password = clear($this->request->getVar('password'));

        $db = db('user');

        $by_username = $db->where('username', $username)->whereNotIn('username', [''])->get()->getRowArray();

        if ($by_username) {
            if (!password_verify($password, $by_username['password'])) {
                gagal(base_url('login'), 'Pasword salah.');
            } else {
                $data = [
                    'id' => $by_username['id'],
                    'username' => $by_username['username'],
                    'gender' => $by_username['gender'],
                    'no_id' => $by_username['no_id'],
                    'section' => $by_username['section'],
                    'role' => $by_username['role'],
                    'nama' => $by_username['nama']
                ];
                session()->set($data);
                sukses(base_url('home'), 'Login sukses.');
            }
        } else {
            $by_id = $db->where('no_id', $username)->whereNotIn('no_id', [0])->get()->getRowArray();
            if ($by_id) {
                if (!password_verify($password, $by_id['password'])) {
                    gagal(base_url('login'), 'Pasword salah.');
                } else {
                    $data = [
                        'id' => $by_username['id'],
                        'username' => $by_username['username'],
                        'gender' => $by_username['gender'],
                        'no_id' => $by_username['no_id'],
                        'section' => $by_username['section'],
                        'role' => $by_username['role'],
                        'nama' => $by_username['nama']
                    ];

                    session()->set($data);
                    sukses(base_url('home'), 'Login sukses.');
                }
            } else {
                gagal(base_url('login'), 'Username tidak ditemukan!.');
            }
        }
    }
}
