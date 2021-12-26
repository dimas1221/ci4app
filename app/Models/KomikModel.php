<?php

namespace App\Models;

use CodeIgniter\Model;

class KomikModel extends Model
{
    protected $table = 'komik';
    // protected $useSoftDeletes = false; untuk data yang ada di db tdk di hapus false di ganti "true" 
    // protected $allowedFields =[]; untuk data mana yg boleh di input manual
    // protected $returnType ='array /objek ';
    // protected $primaryKey ="primary yg di table"; apabila id beda dengn default yg ad di model.php
    protected $useTimestamps = true;
    protected $allowedFields = ['judul', 'slug', 'penulis', 'penerbit', 'sampul']; //untuk mengetahui apa saja yng boleh di isi

    public function getKomik($slug = false)
    {
        if ($slug == false) {
            return $this->findAll();
        }
        return $this->where(['slug' => $slug])->first();
    }
}
