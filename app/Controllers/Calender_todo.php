<?php

namespace App\Controllers;

class Calender_todo extends BaseController
{
    public function index()
    {
        echo view('template/header');
        echo view('todo_list');

        $added['data'] = '';
        echo view('add_todo', $added);

    }

    public function check_remove_task()
    {
        $remove['data'] = 'TODO Task Removed!';

        echo view('template/header');
        echo view('todo_list');

        echo view('add_todo', $remove);

    }

    public function add_task()
    {
        $session = session();
        $username = $_SESSION['username'];
        $date = $this->request->getPost('date');
        $task = $this->request->getPost('task');

        $model = model('App\Models\Calender_model');
        $model->add_todo($username, $date, $task);

        return redirect()->to(base_url() . 'todo/1');
    }

    public function check_add_task()
    {
        $added['data'] = 'TODO added!';

        echo view('template/header');
        echo view('todo_list');
        echo view('add_todo', $added);

    }

    public function remove_task($task)
    {
        $model = model('App\Models\Calender_model');
        $model->delete_todo($task);
        return redirect()->to(base_url() . 'todo/3');
    }


}