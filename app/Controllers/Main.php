<?php

namespace App\Controllers;

use App\Models\Forum_model;
use App\Models\User_model;

class Main extends BaseController
{
    public function index()
    {
        if (!session()->get('username')) {
            # If no current session, redirect to login page, else continue show the home 
            # page of the forum
            return redirect()->to(base_url('login'));

        } else {

            $model = model('App\Models\Forum_model');
            $trend = $model->recommendation(); //id, weight

            echo view('template/header');

            echo view('new_thread'); //new thread button 


            $model = model('App\Models\Forum_model');
            $threads = $model->get_threads();

            $Image_model = model('App\Models\Image_model');

            $profile_image_path = '';

            // Trending threads
            echo "<br><div class=\"container\"><h5>Trending 🔥</h5></div>";

            foreach ($trend as $current_thread) {

                $thread = $model->get_threads($current_thread['id']);

                foreach ($thread as $row) {
                    $path = $Image_model->get_profile_picture($row->username);
                }

                if (isset($path)) {
                    $profile_image_path = $path->profile_picture;
                }

                if (!$profile_image_path) {
                    $profile_image_path = 'no-pic.jpg';
                }

                $croped = $Image_model->scale_thumbnail(WRITEPATH . 'uploads/', $profile_image_path);

                // change time to Brisbane time (+10 hours)
                $old_date = strtotime($row->date_created) + 600 * 60;
                $new_date = date('Y/m/d H:i:s', $old_date);

                $view_count = $model->get_view_count($row->id);

                if (isset($view_count)) {
                    $views = $view_count['view_count'];
                }

                $data = [
                    'id' => $row->id,
                    'subject' => $row->subject,
                    'likes' => $model->get_like($row->id),
                    'views' => $views,
                    'date_created' => $new_date,
                    'thumbnail' => '/demo/writable/uploads/' . $croped,
                    'username' => $row->username
                ];

                echo view('home', $data);
            }

            // All threads
            echo "<br><div class=\"container\"><h5>All Threads</h5></div>";

            foreach ($threads as $row) {

                $path = $Image_model->get_profile_picture($row->username);

                if (isset($path)) {
                    $profile_image_path = $path->profile_picture;
                }
                if (!$profile_image_path) {
                    $profile_image_path = 'no-pic.jpg';
                }

                $croped = $Image_model->scale_thumbnail(WRITEPATH . 'uploads/', $profile_image_path);

                // change time to Brisbane time (+10 hours)
                $old_date = strtotime($row->date_created) + 600 * 60;
                $new_date = date('Y/m/d H:i:s', $old_date);

                $view_count = $model->get_view_count($row->id);

                if (isset($view_count)) {
                    $views = $view_count['view_count'];
                }

                $data = [
                    'id' => $row->id,
                    'subject' => $row->subject,
                    'likes' => $model->get_like($row->id),
                    'views' => $views,
                    'date_created' => $new_date,
                    'thumbnail' => '/demo/writable/uploads/' . $croped,
                    'username' => $row->username
                ];

                echo view('home', $data);
            }

            echo view('template/footer');

        }
    }


    public function post_thread()
    {
        $username = session()->get('username');
        $thread_subject = $this->request->getPost('thread_subject');

        echo $thread_subject;

        $model = model('App\Models\Forum_model');
        $model->post_thread($username, $thread_subject, 1);

        return redirect()->to(base_url('home'));

    }

    public function post_comment($id = 0)
    {
        $username = session()->get('username');
        $comment = $this->request->getPost('comment');


        $model = model('App\Models\Forum_model');
        $model->post_comment($id, $username, $comment);


        return redirect()->to(base_url('home/thread/' . $id));

    }

    public function thread($id = 0)
    {

        echo view('template/header');

        $session = session();
        $username = $_SESSION['username'];
        $model = model('App\Models\Forum_model');
        $like = $model->check_like($username, $id);

        $data = [
            'like' => $like,
            'id' => $id
        ];

        echo view('new_comment', $data); //new thread button

        # Showing all threads
        $model = model('App\Models\Forum_model');

        $current_thread = $model->get_threads($id);
        $model->view_count($id);

        $view_count = $model->get_view_count($id);

        if (isset($view_count)) {
            echo "<br><div class=\"container\">" . "View Count: " . $view_count['view_count'] . "</div>";

        }

        foreach ($current_thread as $row) {
            $data = [
                'username' => $row->username,
                'date' => $row->date_created,
                'subject' => $row->subject
            ];
            echo view("thread", $data);
        }

        # Displaying all comments for current thread
        $comments = $model->get_comment($id);

        if ($comments == false) {
            echo "No Comments";
        } else {
            foreach ($comments as $row) {

                $data = [
                    'username' => $row->username,
                    'date' => $row->date_created,
                    'comment' => $row->content
                ];

                echo view("comment", $data);
            }
        }

        echo view('template/footer');

    }

    public function like_unlike($id = 0)
    {
        #AJAX
        $request = $this->request;
        $session = session();
        $username = $_SESSION['username'];
        $model = model('App\Models\Forum_model');

        if ($request->isAJAX()) {
            $fm = new Forum_model();
            $likes = $fm->like($username, $id);

            header('Conten-Type: application/json');

            echo json_encode($likes);

        } else {
            echo "not working";
        }

    }

    public function user_like()
    {
        $model = model('App\Models\Forum_model');
        $liked_threads = $model->get_user_like();


        foreach ($liked_threads as $row) {
            $thread = $model->get_threads($row->thread);
            echo $thread;
        }
    }

    public function search($text)
    {
        #AJAX
        $request = $this->request;
        $result = [];
        if ($request->isAJAX()) {
            $fm = new Forum_model();
            $search = $fm->get_threads_by_keywords($text);

            if (isset($search)) {
                $result = $search->subject;
            }

            header('Conten-Type: application/json');
            echo json_encode($result);

        } else {
            echo "not working";
        }

    }

    public function get_search()
    {
        $text = $this->request->getPost('search_ajax');
        $fm = new Forum_model();
        $search = $fm->get_threads_by_keywords($text);

        if (!$search) {
            return redirect()->to(base_url('home'));
        }

        if (isset($search)) {
            $result = $search->id;
        }
        return redirect()->to(base_url('home/thread/' . $result));
    }


}


// $data['current_user'] = session()->get('username');
// echo view("profile", $data);