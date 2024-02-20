<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index($in = 0)
    {
        $value = "";

        if (isset($_COOKIE['username'])) {
            $value = $_COOKIE['username'];
        }

        $data = [
            'test' => $value,
            'error' => ''
        ];

        echo view('logout_header');

        if (session()->get('username')) {
            # Check is there exist a session, if true then then home page will be shown,
            # else the login page will be shown
            return redirect()->to(base_url('home'));

        } else {

            if ($in == 1) {
                # If login details is not correct, check_login() will redirect to login page with 
                # $in = 1 which routes to login/1 that tiggers the error message.
                # If not the situation above, $in is equal to 0 by default which will not trigger
                # the error message.
                $error = "<div class=\"alert alert-danger\" role=\"alert\"> Incorrect username or password!! </div> ";
                $data = [
                    'test'  => $value,
                    'error' => $error
                ];
                echo view('login', $data);
            } else {
                echo view('login', $data);
            }
        }

        echo view('template/footer');
    }

    public function check_login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember');



        $model = model('App\Models\User_model');

        $check = $model->login($username, $password);

        if ($check) {
            # Create a session if username and password is correct and redirect back to /login
            # else redirect to /login/1 which triggers error message
            $session = session();
            $session->set('username', $username);

            if ($remember) {
                # If remember me box is ticked, username will be stored in cookie
                setcookie('username', $username, time() + 10);
            }

            return redirect()->to(base_url('login'));

        } else {

            $in = 1;
            return redirect()->to(base_url('login/' . $in));
        }
    }

    public function logout()
    {
        if (!session()->get('username')) {
            return redirect()->to(base_url('login'));
        }
        
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('login'));
    }

    public function forget_password($error = false)
    {
        $error_message["error"] = "";

        echo view('logout_header');

        if ($error) {
            $error_message["error"] = "Email Incorrect or Not Exists";
            echo view("forget_password", $error_message);
        } else {
            echo view("forget_password", $error_message);
        }
        

    }

    public function check_forget_password()
    {
        echo view('logout_header');
        $email = $this->request->getPost('email');

        $model = model('App\Models\User_model');
        $email_model = model('App\Models\Email_model');

        $check = $model->check_email($email);

        if ($check) {
            $token = $model->forget_password($email);
            echo "An Email with reset link have been sent to " . $email;
            $email_model->send_forget_password($email, $token);
        } else {
            return redirect()->to(base_url('login/forget_password/true'));
        }
    }

    public function reset_password($token)
    {
        $model = model('App\Models\User_model');
        $check = $model->check_reset_link($token);
        echo view('logout_header');

        $data = [
            'token' => $token
        ];

        if ($check == "expired") {
            echo "Link expired, please request again.";
            $model->distroy_token($token);
        } else if ($check == "in-time") {
            echo view('reset_password', $data);
        } else {
            echo "Error! Try again later";
        }

    }

    public function check_reset_password($token)
    {
        echo view('logout_header');

        $rules = [
            'password' => 'required|min_length[10]|regex_match[^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{10,}$]',
            'confirm_password' => 'required|matches[password]'
        ];

        $data = [
            'token' => $token
        ];


        if (!$this->validate($rules)) {
            $error_message = \Config\Services::validation()->listErrors();
            echo "<div class=\"alert alert-danger\" role=\"alert\"> $error_message </div> ";
            echo view('reset_password', $data);
        } else {
            $password = $this->request->getPost('password');
            $model = model('App\Models\User_model');
            $model->update_forget_password($token, $password);
            $model->distroy_token($token);
            echo 'New password have been set!';
        }
        
        
    }


}
