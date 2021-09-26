<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $useTimestamps = true;
    protected $allowedFields = ['name', 'email', 'image', 'password', 'role_id', 'is_active'];

    public function getUser($email)
    {
       return $this->where(['email' => $email])->first();
    }
    
    public function getUserById($id)
    {
       return $this->where(['id' => $id])->first();
    }

    public function getAllUser()
    {
        return $this->findAll();
    }
}