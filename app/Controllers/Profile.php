<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
	protected $userModel;
   
   public function __construct()
   {
      $this->userModel = new UserModel();
   }

	public function index()
	{
		$data = [
			'title' => 'Profile',
			'user' => $this->userModel->getUser(session()->get('email'))
		];
		return view('profile/myprofile', $data);
	}

	public function ubahPassword()
	{
		$data = [
			'title' => 'Ubah Password',
			'user' => $this->userModel->getUser(session()->get('email')),
			'validation' => \Config\Services::validation()
		];
		return view('profile/ubahpassword', $data);
	}

	public function changePassword()
	{
		if(!$this->validate([
			'passwordlama' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Type your old password'
				]
			],
			'passwordbaru1' => [
				'rules' => 'required|min_length[3]',
				'errors' => [
					'required' => 'Set new password',
					'min_length' => 'Password is too short'
				]
			],
			'passwordbaru2' => [
				'rules' => 'required|matches[passwordbaru1]',
				'errors' => [
					'required' => 'Re-type password',
					'matches' => 'Password not matches'
				]
			]
		])) {
			return redirect()->to('/profile/ubahpassword')->withInput();
		}

		$user = $this->userModel->getUser(session()->get('email'));
		$id = $this->request->getVar('id');
		$passwordlama = $this->request->getVar('passwordlama');
		$passwordbaru1 = $this->request->getVar('passwordbaru1');

		if(!password_verify($passwordlama, $user['password'])) {
			
			session()->setFlashdata([
				'pesan' => 'Password Lama Salah.'
			]);
			return redirect()->to('/profile/ubahpassword');

		} else {

			if($passwordlama == $passwordbaru1) {
				session()->setFlashdata([
					'pesan' => 'Set Password Baru.'
				]);
				return redirect()->to('/profile/ubahpassword');
			} else {
			$this->userModel->save([
				'id' => $id,
				'password' => password_hash($passwordbaru1, PASSWORD_DEFAULT)
			]);
			session()->setFlashdata([
				'pesan' => 'Password berhasil diubah.'
			]);
			return redirect()->to('/profile');
			}
		}
	}
}
