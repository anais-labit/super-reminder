<?php

namespace App\Controllers;

use App\Models\TaskModel;
use DateTime;

class TaskController
{
    private $tasks;

    public function addNewTask($name,  $dueDate, $idList)
    {
        $name = trim(htmlspecialchars($_POST['newTaskName']));
        var_dump($idList);
        $idList = intval($_POST['postId']);
        var_dump($idList);
        $dueDate = $_POST['dueDateNewTask'];
        $tag = 'urgent';
        $status = 0;
        $date = date('Y-m-d');

        $newTask = new TaskModel();
        $newTask->createTask($name, $date, $dueDate, $tag, $idList, $status);

        // echo json_encode([
        //     "success" => true,
        //     "message" => "La tâche a bien été ajoutée."
        // ]);
    }
}
