<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\UserTokenModel;

class Auth extends BaseController
{
	protected $userModel;
	protected $userTokenModel;
   
   public function __construct()
   {
      $this->userModel = new UserModel();
      $this->userTokenModel = new UserTokenModel();
   }

	public function index()
	{
		// mengirim data ke halaman login
		$dataIndex = [
			'title' => 'Login',
			'validation' => \Config\Services::validation()
		];
		return view('auth/login', $dataIndex);
	}

	public function login()
	{
		// validasi login
		if(!$this->validate([
			'email' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Masukkan email!'
				]
			],
			'password' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Masukkan password!'
				]
			]
		])) {
			return redirect()->to('/auth')->withInput();
		}
		
		// menangkap inputan
		$email = $this->request->getPost('email');
		$password = $this->request->getPost('password');
		
		// mengambil data database
		$user = $this->userModel->getUser($email);
		
		if($user) {
			
			if($user['is_active'] == 1) {

				if(password_verify($password, $user['password'])) {
					$data = [
						'email' => $user['email'],
						'role_id' => $user['role_id'],
						'logged_in' => TRUE
					];

					if($user['role_id'] == 1) {
						session()->set($data);						
						return redirect()->to('/buah');

					} else {
						session()->set($data);
						return redirect()->to('/home');
					}

				} else {
					session()->setFlashdata([
						'pesan' => 'Password salah!',
						'status' => 'danger'
					]);
					return redirect()->to('/auth')->withInput();
				}

			} else {
				session()->setFlashdata([
					'pesan' => 'Email Anda belum teraktivasi!',
					'status' => 'danger'
				]);
				return redirect()->to('/auth')->withInput();
			}

		} else {
			session()->setFlashdata([
				'pesan' => 'Email Anda belum terdaftar!',
				'status' => 'danger'
			]);
			return redirect()->to('/auth')->withInput();
		}

	}

	public function register()
	{
		$data = [
			'title' => 'Sign Up',
			'validation' => \Config\Services::validation()
		];

		return view('auth/register', $data);
	}

	public function save()
	{
		if(!$this->validate([
			'name' => [
				'rules' => 'required',
				'errors' => [
					'required' => "Name can't be empty"
				]
			],
			'email' => [
				'rules' => 'required|valid_email|is_unique[user.email]',
				'errors' => [
					'required' => 'Email cannot be empty',
					'valid_email' => 'Email not valid',
					'is_unique' => 'Email already registered'
				]
			],
			'password1' => [
				'rules' => 'required|min_length[3]',
				'errors' => [
					'required' => 'Password cannot be empty',
					'min_length' => 'Password is too short'
				]
			],
			'password2' => [
				'rules' => 'required|matches[password1]',
				'errors' => [
					'required' => 'Re-type password',
					'matches' => 'Password not matches'
				]
			]
		])) {
			return redirect()->to('auth/register')->withInput();
		}

		$email = $this->request->getVar('email');
		
		$this->userModel->save([
			'name' => $this->request->getVar('name'),
			'email' => $email,
			'image' => 'default.jpg',
			'password' => password_hash($this->request->getVar('password1'), PASSWORD_DEFAULT),
			'role_id' => 2,
			'is_active' => 0
		]);

		$token = base64_encode(random_bytes(32));

		$this->userTokenModel->save([
			'email' => $email,
			'token' => $token,
			'date_created' => time()
		]);

		$this->_sendMail($token, 'verify');

		session()->setFlashdata([
			'pesan' => 'Activation link have been send to your email. Please activated to complete your registered!',
			'status' => 'success'
		]);
		return redirect()->to('/auth');
	}

	private function _sendMail($token, $type)
	{
		$email = \Config\Services::email();
		$mailReg = $this->request->getVar('email');

		$email->setFrom('frlightroomediting@gmail.com', 'Toko Buah');
		$email->setTo($mailReg);
		
		if($type == 'verify') {
			$email->setSubject('Account Verification');
			$email->setMessage('Click this link: <a href="http://localhost:8080/auth/verify?email='.$mailReg.'&token='.urlencode($token).'">Activate</a>'); 
		} else if($type == 'forgot') {
			$email->setSubject('Reset Password');
			$email->setMessage('Click this link: <a href="http://localhost:8080/auth/newpassword?email='.$mailReg.'&token='.urlencode($token).'">Reset Password</a>'); 
		}

		return $email->send();
	}

	public function verify()
	{
		$mailReg = $this->request->getVar('email');
		$token = $this->request->getVar('token');

		$user = $this->userModel->getUser($mailReg);
		$user_token = $this->userTokenModel->getToken($token);

		if($user) {
			if($user_token) {
				if(time() - $user_token['date_created'] < (60*60*24)) {
					$this->userModel->save([
						'id' => $user['id'],
						'is_active' => 1
					]);
					$this->userTokenModel->delete([
						'id' => $user_token['id']
					]);
					session()->setFlashdata([
						'pesan' => 'Activation success.',
						'status' => 'success'
					]);
					return redirect()->to('/auth');
				} else {
					session()->setFlashdata([
						'pesan' => 'Activation failed. Token expired!',
						'status' => 'danger'
					]);
					return redirect()->to('/auth');
				}
			} else {
				session()->setFlashdata([
					'pesan' => 'Activation failed. Invalid token!',
					'status' => 'danger'
				]);
				return redirect()->to('/auth');
			}
		} else {
			session()->setFlashdata([
				'pesan' => 'Activation failed. Invalid email!',
				'status' => 'danger'
			]);
			return redirect()->to('/auth');
		}
	}

	public function forgotPassword()
	{
		$data = [
			'title' => 'Forgot Password',
			'validation' => \Config\Services::validation()
		];

		return view('auth/forgotpassword', $data);
	}

	public function resetPassword()
	{
		if(!$this->validate([
			'email' => [
				'rules' => 'required|valid_email',
				'errors' => [
					'required' => 'Type your email',
					'valid_email' => 'Email not valid'
				]
			]
		])) {
				return redirect()->to('auth/forgotpassword')->withInput();
		}

		$email = $this->request->getVar('email');
		$user = $this->userModel->getUser($email);
		$token = base64_encode(random_bytes(32));
		
		if($user) {
			if($user['is_active'] == 1) {

				$this->userTokenModel->save([
					'email' => $email,
					'token' => $token,
					'date_created' => time()
				]);
		
				$this->_sendMail($token, 'forgot');

				session()->setFlashdata([
					'pesan' => 'Check your email to reset password!',
					'status' => 'success'
				]);
				return redirect()->to('/auth/forgotpassword'); 
			} else {
				session()->setFlashdata([
					'pesan' => 'Your account has not been activated!',
					'status' => 'danger'
				]);
				return redirect()->to('/auth/forgotpassword'); 
			}
		} else {
			session()->setFlashdata([
				'pesan' => 'Email has not registered!',
				'status' => 'danger'
			]);
			return redirect()->to('/auth/forgotpassword');
		}
	}

	public function newPassword()
	{
		$email = $this->request->getVar('email');
		$token = $this->request->getVar('token');

		$user = $this->userModel->getUser($email);
		$user_token = $this->userTokenModel->getToken($token);

		if($user) {
			if($user_token) {
				session()->set('reset_email', $email);
				return $this->setNewPassword();
			} else {
				session()->setFlashdata([
					'pesan' => 'Reset Password Failed! Wrong Token.',
					'status' => 'danger'
				]);
				return redirect()->to('/auth');
			}
		} else {
			session()->setFlashdata([
				'pesan' => 'Reset Password Failed! Wrong Email',
				'status' => 'danger'
			]);
			return redirect()->to('/auth');
		}
	}

	public function setNewPassword()
	{
		if(!session()->get('reset_email')) {
			return redirect()->to('/auth');
		}

		$data = [
			'title' => 'Set New Password',
			'validation' => \Config\Services::validation()
		];

		return view('auth/setNewPassword', $data);
	}

	public function makePassword()
	{
		if(!$this->validate([
			'password1' => [
				'rules' => 'required|min_length[3]',
				'errors' => [
					'required' => 'Type new password',
					'min_length' => 'Password is too short'
				]
			],
			'password2' => [
				'rules' => 'required|matches[password1]',
				'errors' => [
					'required' => 'Re-type password',
					'matches' => 'Password not matches'
				]
			]
		])) {
				return redirect()->to('auth/setnewpassword')->withInput();
		}

		$email = session()->get('reset_email');
		$user = $this->userModel->getUser($email);
		$this->userModel->save([
			'id' => $user['id'],
			'password' => password_hash($this->request->getVar('password1'), PASSWORD_DEFAULT),
		]);

		session()->setFlashdata([
			'pesan' => 'Reset Password Success',
			'status' => 'success'
		]);
		return redirect()->to('/auth');
	}
	
   public function logout()
	{
		session()->remove('reset_email');
		
		session()->setFlashdata([
			'pesan' => 'You have been logged out. Thanks',
			'status' => 'success'
		]);
		return redirect()->to('/auth');
	}
}