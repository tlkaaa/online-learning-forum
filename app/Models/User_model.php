<?php

namespace App\Models;

use CodeIgniter\Model;

class User_model extends Model
{
    public function login($username, $password)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('user');
        
        $builder->where('username', $username);
        $query = $builder->get();

        $hashed_pw = '';

        $row = $query->getRowArray();

        if (isset($row)) {
            $hashed_pw = $row['password'];
        } 

        if (password_verify($password, $hashed_pw)) {
            return true;
        }

        return false;
    }

    public function get_user($username)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('user');
        $builder->where('username', $username);
        $query = $builder->get();
        if ($query->getRowArray()) {
            return $query->getRow();
        }
        return false;
    }

    public function create_account($new_email, $new_username, $new_password, $new_phone)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('user');

        $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
        
        $data = [
            'email'         => $new_email,
            'username'      => $new_username,
            'password'      => $password_hash,
            'phone'         => $new_phone
        ];
        
        $builder->insert($data);
        $test_query = $builder->where($data)->get();
        
        if (!$test_query->getRowArray()) {
            return false;
        }

        return true;
    }

    public function update_details($username, $email, $phone)
    {
        $db = \Config\Database::connect();

        $builder = $db->table('user');
        $builder->where('username', $username);

        $data = [
            'email' => $email,
            'phone' => $phone
        ];

        $builder->where('username', $username);

        $builder->update($data);

        return true;
    }

    public function check_email($email) {
        $db = \Config\Database::connect();
        $builder = $db->table('user');
        $builder->where('email', $email);
        $query = $builder->get();

        if ($query->getRow()) {
            return true;
        }
        return false;

    }

    public function forget_password($email) {
        $db = \Config\Database::connect();
        $builder = $db->table('forget_password');
        $builder->where('email', $email);
        $query = $builder->get();

        $token = bin2hex(random_bytes(32));

        if (!$query->getRow()) {
            $data = [
                'email' => $email,
                'time' => date('Y/m/d H:i:s', time()),
                'token' => $token
            ];

            $builder->insert($data);
            return $token;
        } else {
            $data = [
                'time' => date('Y/m/d H:i:s', time()),
                'token' => $token
            ];
            $builder->update($data, ['email' => $email]);
            return $token;
        }
    }


    public function check_reset_link($token) {
        $db = \Config\Database::connect();
        $builder = $db->table('forget_password');
        $builder->where('token', $token);
        $query = $builder->get();
        $row = $query->getRow();

        if ($row) {

            $timestamp =  strtotime($row->time);
            $time_limit = time() - $timestamp;

            #reset link valid time (set to 5 minutes, 300)
            if ($time_limit <= 300) {
                return "in-time";
            } else {
                return "expired";
            }
        } 
        return false;
    }

    public function update_forget_password($token, $password) {
        $db = \Config\Database::connect();
        $builder = $db->table('forget_password');
        $builder->where('token', $token);
        $query = $builder->get();
        $row = $query->getRow();
        $email = '';
        if ($row) {
            $email = $row->email;
        } 

        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        $data = [
            'password' => $password_hash
        ];
        
        $builder = $db->table('user');
        $builder->where('email', $email);
        $builder->update($data);
    }

    public function distroy_token($token) {
        $db = \Config\Database::connect();
        $builder = $db->table('forget_password');
        $builder->delete(['token' => $token]);

    }


}
