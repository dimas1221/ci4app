<?php

namespace App\Controllers;

use CodeIgniter\Model;
use Config\Database;
use \App\Models\KomikModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Komik extends BaseController
{
    protected $komikModel;

    public function __construct()
    {
        // pindah kesi agar method lain bisa mengakses a tpi di kasih awala $this-> / di base kontlroles jika di butuhkan semua kontroler
        $this->komikModel = new KomikModel();
    }
    public function index()
    {
        // $komik = $this->komikModel->findAll(); // = select * from namtab di native
        $data = [
            'title' => 'Daftar Komik',
            // 'komik' =>  $komik
            'komik' => $this->komikModel->getKomik()
        ];

        //conek db manual
        // $db = \Config\Database::connect();
        // $komik = $db->query("SELECT * FROM komik");
        // foreach ($komik->getResultArray() as $row) {
        // d($row);
        // }

        // $KomikModel = new \App\Models\KomikModel();

        // $KomikModel = new KomikModel();   

        return view('komik/index', $data);
    }

    public function detail($slug)
    {
        $data = [
            'title' => 'Detail Komik',
            'komik' => $this->komikModel->getKomik($slug)
        ];
        //jika komit tdk ada di tbel
        if (empty($data['komik'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('judul komik ' . $slug . ' tidak di temukan');
        }

        return view('komik/detail', $data);
    }

    public function create()
    {
        // menjalankan fungsi session karna input di kirim lewat session
        // session(); di taruh di basecontroler agar tidak lupa

        $data = [
            'title' => 'form tambah data',
            'validation' => \Config\Services::validation()
        ];

        return view('komik/create', $data);
    }

    public function save()
    {
        //validasi input  note: harus sama dengan name field tabel
        if (!$this->validate([
            //tulisan default dari ci4 'judul' => 'required|is_unique[komik.judul]'

            //jika ingin tulisan eror seusai keinginan
            'judul' => [
                'rules' => 'required|is_unique[komik.judul]',
                'errors' => [
                    'required' => '{field} komik harus di isi',
                    'is_unique' => '{field} komik sudah ada'
                ]
            ],
            'penulis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ],
            'penerbit' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus di isi'
                ]
            ]
        ])) {
            // mengambil pesan kesalahan harus simpan dulu ke dalam variabel
            //library service
            $validation = \Config\Services::validation();

            //end
            //note reirect() tidak bisa pakai komo ex: $data = validation, return redirect()->to('/komik/create', $data);
            // maka jika ingin menggunakan redirect bisa di tulis seperti di bawah
            return redirect()->to('/komik/create')->withInput()->with('validation', $validation);
        }
        //end

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $this->request->getVar('sampul')
        ]);

        session()->setFlashdata('pesan', 'data berhasil di tambahkan.'); //menampilkan dalam satu waktu saja


        return redirect()->to('/komik');
    }
}
