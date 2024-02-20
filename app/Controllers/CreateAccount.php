<?php

namespace App\Controllers;

class CreateAccount extends BaseController
{
    public function index()
    {
        echo view('logout_header');
        echo view('create_account');
        echo view('template/footer');

    }

    public function create_account()
    {

        $rules = [
            'new_email' => 'required|valid_email|is_unique[user.email]',
            'new_username' => 'required|is_unique[user.username]',
            'new_phone' => 'required|min_length[10]|max_length[10]',
            'new_password' => 'required|min_length[10]|regex_match[^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{10,}$]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        if (!$this->validate($rules)) {
            $error_message = \Config\Services::validation()->listErrors();
            echo view('logout_header');
            echo "<div class=\"alert alert-danger\" role=\"alert\"> $error_message </div> ";
            echo view('create_account');
            echo view('template/footer');
        } else {
            $new_email = $this->request->getPost('new_email');
            $new_username = $this->request->getPost('new_username');
            $new_password = $this->request->getPost('new_password');
            $new_phone = $this->request->getPost('new_phone');
            $created_user['created_user'] = $new_username;

            $model = model('App\Models\User_model');
            $check = $model->create_account($new_email, $new_username, $new_password, $new_phone);

            if ($check) {
                echo view('logout_header');
                echo view('created_account', $created_user);
                echo view('template/footer');

                $email = model('App\Models\Email_model');
                $email->send_verification($created_user);

            } else {
                $error_message['create_error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Error! Please try again. </div> ";
                echo view('logout_header');
                echo view('create_account');
                echo view('template/footer');
            }
        }

    }
    public function strong_password($str)
        {
            if (preg_match('#[0-9]#', $str) && preg_match('#[a-zA-Z]#', $str)) {
                return TRUE;
            }
            //$this->form_validation->set_message('check_strong_password', 'The password field must be contains at least one letter and one digit.');
            return FALSE;
        }

}