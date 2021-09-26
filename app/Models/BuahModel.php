<?php

namespace App\Models;

use CodeIgniter\Model;

class BuahModel extends Model
{
    protected $table = 'buah';
    protected $useTimestamps = true;
    protected $allowedFields = ['nama', 'slug', 'agen', 'stok', 'harga', 'gambar'];

    public function getBuah($slug = false)
    {
       if($slug == false) {
          return $this->findAll();
       }

       return $this->where(['slug' => $slug])->first();
    }

    public function search($keyword)
    {
       return $this->table('buah')->like('nama', $keyword);
    }
}