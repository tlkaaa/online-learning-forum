<?php

namespace App\Controllers;
use App\ThirdParty\FPDF;
use App\Models\User_model;

class Profile extends BaseController
{
    public function index()
    {
        # Display the user's profile
        echo view('template/header');

        $model = model('App\Models\User_model');

        $current_user = session()->get('username');

        $user = $model->get_user($current_user);

        $data = "";

        $profile_image_path = '';

        $Image_model = model('App\Models\Image_model');
        $path = $Image_model->get_profile_picture($current_user);

        if (isset($path)) {
            $profile_image_path = $path->profile_picture;
        }

        if (!$profile_image_path) {
            $profile_image_path = 'no-pic.jpg';
        }
        $croped = $Image_model->scale(WRITEPATH . 'uploads/', $profile_image_path);

        $verification_link = "<br><a href=\"../demo/verify\">Chick here to verify your email</a>";

        if (isset($user)) {
            $data = [
                'profile_picture' => '/demo/writable/uploads/' . $croped,
                'username' => $user->username,
                'email' => $user->email,
                'verification' => $user->verification_status,
                'verification_link' => $verification_link,
                'phone' => $user->phone
            ];
            if ($data['verification'] == 0) {
                $data['verification'] = "Not Verified";
            } else {
                $data['verification'] = "Verified";
                $data['verification_link'] = "";
            }

        }

        echo view('profile', $data);

        $model = model('App\Models\Forum_model');
        $liked_threads = $model->get_user_like();


        foreach ($liked_threads as $row) {

            $thread = $model->get_threads($row->thread);

            foreach ($thread as $i) {

                $data = [
                    'id' => $i->id,
                    'subject' => $i->subject
                ];
                echo view('liked_threads', $data);
            }

        }

        echo view('template/footer');
    }

    public function update()
    {
        # Display the update user form
        echo view('template/header');
        echo view('update_details');
        echo view('template/footer');
    }

    public function check_update()
    {
        echo view('template/header');

        $model = model('App\Models\User_model');

        $current_user = session()->get('username');

        $rules = [
            'email_update' => 'required|valid_email|is_unique[user.email]',
            'phone_update' => 'required|min_length[10]|max_length[10]'
        ];

        if (!$this->validate($rules)) {
            $error_message = \Config\Services::validation()->listErrors();
            echo "<div class=\"alert alert-danger\" role=\"alert\"> $error_message </div> ";
            echo view('update_details');
        } else {
            $email = $this->request->getPost('email_update');
            $phone = $this->request->getPost('phone_update');
            $model->update_details($current_user, $email, $phone);
            echo 'success!';
        }

        echo view('template/footer');

    }

    public function dz()
    {
        $model = model('App\Models\Image_model');

        $rules = [
            'image' => 'uploaded[image]|max_size[image,1024]|ext_in[image,jpg,jpeg,png,gif]'
        ];


        if ($this->validate($rules) && !empty($_FILES)) {

            $image = $this->request->getFile('image');

            $newName = $image->getRandomName();

            $path = WRITEPATH . 'uploads';

            $image->move($path, $newName);

            $model->upload($newName);

        }

    }

    public function upload_profile_picture()
    {

        $model = model('App\Models\Image_model');

        $rules = [
            'image' => 'uploaded[image]|max_size[image,1024]|ext_in[image,jpg,jpeg,png,gif]'
        ];


        if ($this->validate($rules) && !empty($_FILES)) {

            $image = $this->request->getFile('image');

            $newName = $image->getRandomName();

            $path = WRITEPATH . 'uploads';

            $image->move($path, $newName);

            $model->upload($newName);

            echo view('template/header');
            echo $newName . "  Successfully uploaded";

            echo view('template/footer');

        } else {

            # Display the user's profile
            echo view('template/header');

            $error_message = \Config\Services::validation()->listErrors();
            echo "<div class=\"alert alert-danger\" role=\"alert\"> $error_message </div> ";

            $model = model('App\Models\User_model');

            $current_user = session()->get('username');

            $user = $model->get_user($current_user);

            $data = "";

            $profile_image_path = '';

            $Image_model = model('App\Models\Image_model');
            $path = $Image_model->get_profile_picture($current_user);

            if (isset($path)) {
                $profile_image_path = $path->profile_picture;
            }

            if (!$profile_image_path) {
                $profile_image_path = 'no-pic.jpg';
            }
            $croped = $Image_model->scale(WRITEPATH . 'uploads/', $profile_image_path);

            if (isset($user)) {
                $data = [
                    'profile_picture' => '/demo/writable/uploads/' . $croped,
                    'username' => $user->username,
                    'email' => $user->email,
                    'phone' => $user->phone
                ];
            }

            echo view('profile', $data);
        }
    }

    public function email_verify()
    {
        $session = session();
        $username = $_SESSION['username'];
        $model = model('App\Models\User_model');
        $email = model('App\Models\Email_model');

        $address = '';
        $user = $model->get_user($username);
        if (isset($user)) {
            $address = $user->email;
        }


        if ($username != null) {
            echo view('template/header');
            echo "An verification email have been sent to " . $address;
            $email->send_verification($username);
        } else {
            echo "Error! Try again later";
        }

    }

    public function verify($token)
    {
        $model = model('App\Models\Email_model');
        $check = $model->verified($token);

        echo view("logout_header");
        if ($check) {
            echo "Your Email have been verified";
        } else {
            echo "Error! Try again later.";
        }
    }

    public function pdf() {

        $session = session();
        $username = $_SESSION['username'];

        $model = model('App\Models\User_model');
        $builder = $model->get_user($username);
        $email = "";
        $phone = "";
        $v = "";
        if(isset($builder)) {
            $email = $builder->email;
            $phone = $builder->phone;
            if ($builder->verification_status == 1) { 
                $v = "Verified";
            } else {
                $v = "Not-Verified";
            }
            
        }

        $thread = model('App\Models\Forum_model');
        $threads = $thread->get_thread_by_username($username);
        $comments = $thread->get_comment_by_username($username);
        $likes = $thread->get_like_by_username($username);

        require('/var/www/htdocs/demo/app/ThirdParty/FPDF.php');
        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('courier', '', 10);
        $date = date('Y/m/d H:i:s', time()+ 600 * 60);
        $pdf->Cell(30, 3, "As At " . $date, 0,1);

        $pdf->SetFont('courier', '', 12);
        $pdf->Cell(30, 4, "", 0,1);
        $pdf->Cell(30, 8, "Username: ". $username, 0,1);
        $pdf->Cell(30, 8, "Email: ". $email, 0,1);
        $pdf->Cell(30, 8, "Email Vertification Status: ". $v, 0,1);
        $pdf->Cell(30, 8, "Phone: ". $phone, 0,1);
        $pdf->Cell(30, 8, "", 0,1);

        $pdf->Cell(30, 8, "Threads Posted:", 0,1);
        $pdf->SetFont('courier', '', 11);
        if (!$threads) {
            $pdf->Cell(30, 8, "No Thread Posted.", 0,1);
        } else {
            foreach ($threads as $row) {
                $old_date = strtotime($row->date_created) + 600 * 60;
                $new_date = date('Y/m/d H:i:s', $old_date);
                $pdf->Cell(30, 8, $new_date . "    ".$row->subject , 0,1);
            }
        }
        
        $pdf->Cell(30, 8, "", 0,1);

        $pdf->SetFont('courier', '', 12);
        $pdf->Cell(30, 8, "Comments Posted (Thread): ", 0,1);
        $pdf->SetFont('courier', '', 11);
        if (!$comments) {
            
            $pdf->Cell(30, 8, "No Comment Posted.", 0,1);
        } else {
            foreach ($comments as $row) {
                $thread_subject = $thread->get_threads($row->thread_id);

                $old_date = strtotime($row->date_created) + 600 * 60;
                $new_date = date('Y/m/d H:i:s', $old_date);
                
                foreach($thread_subject as $t) {
                    $pdf->Cell(30, 8, $new_date. "    ". $row->content. "   (" .$t->subject.") " , 0,1);
                }
            }
        }
        $pdf->Cell(30, 8, "", 0,1);

        $pdf->SetFont('courier', '', 12);
        $pdf->Cell(30, 8, "Threads Liked: ", 0,1);
        $pdf->SetFont('courier', '', 11);
        if (!$likes) {
            $pdf->Cell(30, 8, "No Liked Thread.", 0,1);
        } else {
            foreach ($likes as $row) {
                $thread_subject_like = $thread->get_threads($row->thread);

                foreach($thread_subject_like as $t) {
                    $pdf->Cell(30, 8, $t->subject, 0,1);   
                }
            }
        }
        $pdf->Cell(30, 8, "", 0,1);
        $pdf->Cell(30, 8, "", 0,1);
        $pdf->SetFont('courier', '', 10);
        $pdf->Cell(30, 3, "---------------------------------  End of Transcript  ---------------------------------", 0, 'C');

        $name = $username.'_transcript.pdf';
       
        $pdf->Output('I', $name);

        exit;

        
    }

}