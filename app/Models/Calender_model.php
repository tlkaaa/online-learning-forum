<?php

namespace App\Models;

use CodeIgniter\Email\Email;
use CodeIgniter\Model;



class Calender_model extends Model
{
    public function calender()
    {

        //$month = date("Ym", time() + 600  * 600 * 60); //600  * 600 * 60 demo of showing 2024/01

        $month = date("Ym");
        $results = [];

        $file = fopen("/var/www/htdocs/demo/holidays.csv", "r");
        while (($line = fgetcsv($file)) !== FALSE) {

            if (str_contains($line[1], $month) && str_contains($line[5], "qld")) {
                array_push($results, $line);
            }
        }
        fclose($file);

        foreach ($results as $row) {
            echo date("d-m-Y", strtotime($row[1])) . " ". $row[2] . "<br>";
        }
    }

    public function add_todo($username, $date, $task)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('todo');

        $data = [
            'username' => $username,
            'time' => $date,
            'task' => $task
        ];

        $builder->insert($data);
        
    }

    public function get_todo()
    {
        $db = \Config\Database::connect();

        $session = session();
        $username = $_SESSION['username'];
        
        $builder = $db->table('todo');
        $builder->where('username', $username);
        return $builder->get();
    }

    public function delete_todo($task)
    {
        $db = \Config\Database::connect();

        $session = session();
        $username = $_SESSION['username'];
        
        $builder = $db->table('todo');

        $builder->where('username', $username);
        $builder->where('task', $task);
        $builder->delete();
    }



}