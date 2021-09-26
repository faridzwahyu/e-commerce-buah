<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
	protected $userModel;
   
   public function __construct()
   {
      $this->userModel = new UserModel();
   }

	public function index()
	{
		$data = [
			'title' => 'User Management',
			'user' => $this->userModel->getAllUser()
		];

		return view('users/manage', $data);
	}

	public function edit($id)
	{
		$data = [
			'title' => 'Edit Level User',
			'user' => $this->userModel->getUserById($id)
      ];

      return view('users/edituser', $data);
	}

	public function update($id)
	{
		$this->userModel->save([
         'id' => $id,
			'role_id' => $this->request->getVar('level')
		]);

		return redirect()->to('/users');
	}

	public function delete($id)
	{
		$user = $this->userModel->find($id);
      $this->userModel->delete($id);
      return redirect()->to('/users');
	}
}
