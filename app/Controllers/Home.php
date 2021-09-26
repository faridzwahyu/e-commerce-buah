<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\BuahModel;

class Home extends BaseController
{
	protected $userModel;
	protected $buahModel;
   
   public function __construct()
   {
		$this->userModel = new UserModel();
		$this->buahModel = new BuahModel();
   }

	public function index()
	{
		$data = [
			'title' => 'Home',
			'user' => $this->userModel->getUser(session()->get('email'))
		];
		return view('home', $data);
	}
}
