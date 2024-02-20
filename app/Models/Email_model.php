<?php

namespace App\Models;
use CodeIgniter\Email\Email;
use CodeIgniter\Model;



class Email_model extends Model
{
    public function send_verification($user)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('user');

        $builder->where('username', $user);
        $query = $builder->get();
        $row = $query->getRow();

        $address = "";

        if (isset($row)) {
            $address = $row->email;
        }

        $email = new Email();

        $emailConf = [
            'protocol' => 'smtp',
            'wordWrap' => true,
            'SMTPHost' => 'mailhub.eait.uq.edu.au',
            'SMTPPort' => 25
        ];
        $email->initialize($emailConf);

        $token = bin2hex(random_bytes(16));

        $data = [
            'token' => $token
        ];

        $builder = $db->table('user');
        $builder->update($data, ['username' => $user]);

        $message = "Dear User,"
                . "\r\n\r\n"
                . "Please open the following link to verify your email address."
                .  "\r\n\r\n"
                . "https://infs3202-bb356835.uqcloud.net/demo/verify/token/"
                . $token
                .  "\r\n\r\n"
                . "Regards";

        $email->setTo($address);
        $email->setFrom("infs3202-bb356835@uqcloud.net");
        $email->setSubject("Email Verification Link");
        $email->setMessage($message);
        $email->send();
    }

    public function send_forget_password($address, $token)
    {
        $email = new Email();

        $emailConf = [
            'protocol' => 'smtp',
            'wordWrap' => true,
            'SMTPHost' => 'mailhub.eait.uq.edu.au',
            'SMTPPort' => 25
        ];
        $email->initialize($emailConf);

        $message = "Dear User,"
                . "\r\n\r\n"
                . "Please open the following link to reset your password."
                .  "\r\n\r\n"
                . "https://infs3202-bb356835.uqcloud.net/demo/login/reset/"
                . $token
                .  "\r\n\r\n"
                . "Regards";

        $email->setTo($address);
        $email->setFrom("infs3202-bb356835@uqcloud.net");
        $email->setSubject("Reset Password Link");
        $email->setMessage($message);
        $email->send();
    }

    public function verified($token) 
    {
        $db = \Config\Database::connect();
        $builder = $db->table('user');
        $query = $builder->where('token', $token);
        $query = $builder->get();

        if ($query->getRowArray()) {
            $row = $query->getRow();
            
            $data = [
                'verification_status' => 1
            ];
    
            if (isset($row)) {
                $username = $row->username;
            }
            $builder->where('username', $username);
            $builder->update($data);
            return true;
        }

       return false;
        
    }

}