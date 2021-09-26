<?php

namespace App\Controllers;

use App\Models\BuahModel;
use App\Models\UserModel;

class Buah extends BaseController
{
   protected $buahModel;
   protected $userModel;
   
   public function __construct()
   {
      $this->buahModel = new BuahModel();
      $this->userModel = new UserModel();
   }

	public function index()
	{
      $currentPage = $this->request->getVar('page_buah') ? $this->request->getVar('page_buah') : 1;

      $keyword = $this->request->getVar('keyword');
      if($keyword) {
         $buah = $this->buahModel->search($keyword);
      } else {
         $buah = $this->buahModel;
      }

		$data = [
			'title' => 'Home',
         // 'buah' => $this->buahModel->getBuah()
         'buah' => $buah->paginate(5, 'buah'),
         'pager' => $this->buahModel->pager,
         'currentPage' => $currentPage,
         'user' => $this->userModel->getUser(session()->get('email'))
		];

		return view('buah/index', $data);
	}

   public function detail($slug)
   {
      $data = [
			'title' => 'Detail Buah',
         'buah' => $this->buahModel->getBuah($slug),
         'user' => $this->userModel->getUser(session()->get('email'))
		];

      return view('buah/detail', $data);
   }

   public function create()
   {
      // session();

      $data = [
			'title' => 'Tambah Data Buah',
         'validation' => \Config\Services::validation(),
         'user' => $this->userModel->getUser(session()->get('email'))
      ];

      return view('buah/create', $data);
   }

   public function save()
   {
      if(!$this->validate([
         'nama' => [
            'rules' => 'required|is_unique[buah.nama]',
            'errors' => [
               'required' => 'Nama buah tidak boleh kosong', 
               'is_unique' => 'Nama buah sudah ada'
               ]
         ],
         'agen' => [
            'rules' => 'required',
            'errors' => [
               'required' => 'Agen tidak boleh kosong'
               ]
         ],
         'stok' => [
            'rules' => 'numeric',
            'errors' => [
               'numeric' => 'Masukkan angka'
               ]
         ],
         'harga' => [
            'rules' => 'required|numeric',
            'errors' => [
               'required' => 'Harga tidak boleh kosong',
               'numeric' => 'Masukkan harga'
               ]
         ],
         'gambar' => [
            'rules' => 'is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]|max_size[gambar,1024]',
            'errors' => [
               'is_image' => 'Yang Anda upload bukan gambar',
               'mime_in' => 'Yang Anda upload bukan gambar', 
               'max_size' => 'Ukuran gambar terlalu besar'
               ]
         ]
      ])) {

         return redirect()->to('buah/create')->withInput();
      }

      $nama = $this->request->getVar('nama');
      $slug = url_title($nama, '-', true);
      $agen = $this->request->getVar('agen');
      $stok = $this->request->getVar('stok');
      $harga = $this->request->getVar('harga');
      $file = $this->request->getFile('gambar');

      if($file->getError() == 4) {
         $namaFile = 'default.jpg';
      } else {
         $namaFile = $file->getRandomName();
         $file->move('img', $namaFile);
      }

      $this->buahModel->save([
         'nama' => $nama,
         'slug' => $slug,
         'agen' => $agen,
         'stok' => $stok,
         'harga' => $harga,
         'gambar' => $namaFile
      ]);

      session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
      return redirect()->to('/buah');
   }
   
   public function delete($id)
   {
      $buah = $this->buahModel->find($id);
      
      if($buah['gambar'] != 'default.jpg') {
         unlink('img/' . $buah['gambar']);
      }

      $this->buahModel->delete($id);
      session()->setFlashdata('pesan', 'Data berhasil dihapus.');
      return redirect()->to('/buah');
   }

   public function edit($slug)
   {
      $data = [
			'title' => 'Ubah Data Buah',
         'validation' => \Config\Services::validation(),
         'buah' => $this->buahModel->getBuah($slug),
         'user' => $this->userModel->getUser(session()->get('email'))
      ];

      return view('buah/edit', $data);
   }

   public function update($id)
   {
      $namaLama = $this->buahModel->getBuah($this->request->getVar('slug'));
      if($namaLama['nama'] == $this->request->getVar('nama')) {
         $rules = 'required';
      } else {
         $rules = 'required|is_unique[buah.nama]';
      }

      if(!$this->validate([
         'nama' => [
            'rules' => $rules,
            'errors' => [
               'required' => 'Nama buah tidak boleh kosong',
               'is_unique' => 'Nama buah sudah ada'
               ]
         ],
         'agen' => [
            'rules' => 'required',
            'errors' => [
               'required' => 'Agen tidak boleh kosong'
               ]
         ],
         'stok' => [
            'rules' => 'numeric',
            'errors' => [
               'numeric' => 'Masukkan angka'
               ]
         ],
         'harga' => [
            'rules' => 'required|numeric',
            'errors' => [
               'required' => 'Harga tidak boleh kosong',
               'numeric' => 'Masukkan harga'
               ]
         ],
         'gambar' => [
            'rules' => 'is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]|max_size[gambar,1024]',
            'errors' => [
               'is_image' => 'Yang Anda upload bukan gambar', 
               'mime_in' => 'Yang Anda upload bukan gambar', 
               'max_size' => 'Ukuran gambar terlalu besar'
               ]
         ]
      ])) {

         return redirect()->to('buah/edit/' . $this->request->getVar('slug'))->withInput();
      }

      $nama = $this->request->getVar('nama');
      $slug = url_title($nama, '-', true);
      $agen = $this->request->getVar('agen');
      $stok = $this->request->getVar('stok');
      $harga = $this->request->getVar('harga');
      $file = $this->request->getFile('gambar');

      if($file->getError() == 4) {
         $namaFile = $this->request->getVar('namaLama');
      } else {
         $namaFile = $file->getRandomName();
         $file->move('img', $namaFile);
         unlink('img/' . $this->request->getVar('namaLama'));
      }

      $this->buahModel->save([
         'id' => $id,
         'nama' => $nama,
         'slug' => $slug,
         'agen' => $agen,
         'stok' => $stok,
         'harga' => $harga,
         'gambar' => $namaFile
      ]);

      session()->setFlashdata('pesan', 'Data berhasil diubah.');
      return redirect()->to('/buah');
   }
}
