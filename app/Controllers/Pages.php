<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home | web dio',
            'tes' => ['satu', 'dua', 'tiga']
        ];

        return view('pages/home', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'About me'
        ];

        return view('pages/about', $data);
    }

    public function contact()
    {
        $data = [
            'title' => 'contact us',

            'alamat' => [
                [
                    'tipe' => 'rumah',
                    'alamat' => 'jl abc No.123',
                    'kota' => 'Brebes'
                ],
                [
                    'tipe' => 'kantor',
                    'alamat' => 'jl qwe No.124',
                    'kota' => 'jakarta'
                ]
            ]

        ];


        return view('pages/contact', $data);
    }
}
