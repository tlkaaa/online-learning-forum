<?php

namespace App\Models;

use CodeIgniter\Model;

class Forum_model extends Model
{
    public function get_category()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('category');
        $query = $builder->get();

        if ($query->getRowArray()) {
            return $query->getResult();
        }

        return false;

    }

    public function get_thread_by_username($username)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('thread');
        $query = $builder->where('username', $username);
        $query = $builder->get();

        if ($query->getResult()) {
            return $query->getResult();
        }
        return false;
    }



    public function get_threads($id = 0)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('thread');

        if (!$id == 0) {
            $query = $builder->where('id', $id);
        }

        $query = $builder->orderBy('id', 'DESC');
        $query = $builder->get();

        if ($query->getRowArray()) {
            return $query->getResult();
        }
        return false;
    }
    

    public function get_threads_by_keywords($keyword = "")
    {
        $db = \Config\Database::connect();
        $builder = $db->table('thread');


        $query = $builder->like('subject', $keyword, 'after');


        $query = $builder->orderBy('id', 'DESC');
        $query = $builder->get();

        if ($query->getRowArray()) {
            return $query->getRow();
        }
        return false;
    }

    public function get_comment($thread)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('comment');
        $query = $builder->where('thread_id', $thread);
        $query = $builder->get();

        if ($query->getRowArray()) {
            return $query->getResult();
        }

        return false;
    }

    public function get_comment_by_username($username)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('comment');
        $query = $builder->where('username', $username);
        $query = $builder->get();

        if ($query->getRowArray()) {
            return $query->getResult();
        }

        return false;
    }

    public function vote($count)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('thread');
    }

    public function view_count($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('thread');

        $query = $builder->set('view_count', 'view_count + 1', false);
        $query = $builder->where('id', $id);
        $builder->update();

    }

    public function get_view_count($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('thread');

        $query = $builder->where('id', $id);
        $query = $builder->get();

        if ($query->getRowArray()) {
            return $query->getRowArray();
        }

        return false;

    }

    public function like($username, $thread)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('likes');
        $action = '';

        $query = $builder->where('username', $username);
        $query = $builder->where('thread', $thread);
        $query = $builder->get();

        if ($query->getRowArray()) {
            $builder->where('username', $username);
            $builder->where('thread', $thread);
            $builder->delete();
            $action = 'like';
        } else {
            $data = [
                'username' => $username,
                'thread' => $thread
            ];

            $builder->insert($data);
            $action = 'unlike';
        }

        return $action;
    }

    public function get_like_by_username($username) {
        $db = \Config\Database::connect();
        $builder = $db->table('likes');
        $query = $builder->where('username', $username);
        $query = $builder->get();

        if ($query->getRowArray()) {
            return $query->getResult();
        }

        return false;
    }

    public function check_like($username, $thread)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('likes');

        $query = $builder->where('username', $username);
        $query = $builder->where('thread', $thread);
        $query = $builder->get();

        if ($query->getRowArray()) {
            return 'unlike';
        } else {
            return 'like';
        }
    }

    public function get_like($thread)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('likes');
        $query = $builder->where('thread', $thread);
        return $query->countAllResults();
    }

    public function get_user_like()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('likes');
        $session = session();
        $username = $_SESSION['username'];

        $query = $builder->where('username', $username);
        $query = $builder->get();

        return $query->getResult();
    }

    public function post_thread($username, $subject, $category)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('thread');

        $data = [
            'id' => 'null',
            'subject' => $subject,
            'date_created' => date('Y/m/d H:i:s', time()),
            'username' => $username,
            'category' => $category,
            'view_count' => 0,
            'upvotes' => 0
        ];

        $builder->insert($data);

        $test_query = $builder->where($data)->get();

        if (!$test_query->getRowArray()) {
            return false;
        }

        return true;
    }

    public function post_comment($id, $username, $comment)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('comment');

        $data = [
            'id' => 'null',
            'content' => $comment,
            'date_created' => date('Y/m/d H:i:s', time()),
            'thread_id' => $id,
            'username' => $username
        ];

        $builder->insert($data);
    }

    public function get_comment_count($id)
    {
        $db = \Config\Database::connect();
        $comment = $db->table('comment');
        $comment->where('thread_id', $id);
        $comments = $comment->countAllResults();
        return $comments;
    }


    public function recommendation()
    {
        //putting different weights on the number of views, likes, and comments a and calculate 
        //the "trendy" threads currently
        //weights: views = 1, comment = 2, llike = 3

        $db = \Config\Database::connect();
        $thread = $db->table('thread');
        $like = $db->table('likes');
        $comment = $db->table('comment');

        $resuls = []; // 0->id, 1->views, 2->likes, 3->comments

        foreach ($thread->get()->getResult() as $row) {
            //put thread in $results[] with formate of id, views, likes, comments
            $id = $row->id;
            $views = $row->view_count;
            $likes = 0;
            $comments = 0;

            $like->where('thread', $id);
            $likes = $like->countAllResults();

            $comment->where('thread_id', $id);
            $comments = $comment->countAllResults();

            $data = [
                'id' => $id,
                'views' => $views,
                'likes' => $likes,
                'comments' => $comments
            ];

            array_push($resuls, $data);
        }

        $weighted_thread = []; //0->id, 1->weights


        foreach ($resuls as $row) {
            //calculte the weights of each thread and put in $weighted_thread[]
            $weight = $row['views'] * 1 + $row['likes'] * 2 + $row['comments'] * 3;

            $data = [
                'id' => $row['id'],
                'weight' => $weight
            ];

            array_push($weighted_thread, $data);
        }

        $sort_weight = array_column($weighted_thread, 'weight');

        array_multisort($sort_weight, SORT_DESC, $weighted_thread);

        $count = 0;
        $top_threads = [];

        foreach ($weighted_thread as $row) {
            //return top 5 threads
            array_push($top_threads, $row);
            $count++;
            if ($count > 4) {       //limiting to 5 top threads
                break;
            }
        }
        //print_r($top_threads); ////////////////////////////////////////////////
        return $top_threads;

    }

}