<?php

namespace App\Models;

use CodeIgniter\Model;

class UserTokenModel extends Model
{
    protected $table = 'user_token';
   //  protected $useTimestamps = true;
    protected $allowedFields = ['email', 'token', 'date_created'];

    public function getUser($email)
    {
       return $this->where(['email' => $email])->first();
    }

    public function getToken($token)
    {
       return $this->where(['token' => $token])->first();
    }
}