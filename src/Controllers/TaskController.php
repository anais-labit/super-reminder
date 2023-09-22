<?php

namespace App\Controllers;

use App\Models\TaskModel;
use DateTime;

class TaskController
{
    private $tasks;

    public function addNewTask($name,  $dueDate, $idList)
    {

        if (isset($name) && isset($dueDate)) {
            $name = trim(htmlspecialchars($_POST['newTaskName']));
            $idList = intval($_POST['postId']);
            $dueDate = $_POST['dueDateNewTask'];
            $tag = 'urgent';
            $status = 0;
            $date = date('Y-m-d');

            $newTask = new TaskModel();
            $newTask->createTask($name, $date, $dueDate, $tag, $idList, $status);

            echo json_encode([
                "success" => true,
                "message" => "La tâche a bien été ajoutée."
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Une erreur est survenue."
            ]);
        }
    }

    public function displayListTasks(int $idList): ?array {

        $listTasks = new TaskModel();

        $result = $listTasks->getListTasks($idList);

        return $result;
        
    }
}
