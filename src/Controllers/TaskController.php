<?php

namespace App\Controllers;

use App\Models\TaskModel;
use DateTime;

class TaskController
{
    private $tasks;

    public function addNewTask($taskName, $dueDate, $idList)
    {
        $date = date('Y-m-d');
        $taskName = strtolower(trim(htmlspecialchars($_POST['newTaskName'])));
        $taskName = ucwords($taskName);

        if (($taskName != '') && (!empty($dueDate))) {
            if ($dueDate < $date) {
                echo json_encode([
                    "success" => false,
                    "message" => "La date butoir ne peut pas être ultérieure à la date actuelle."
                ]);
            } else {
                $idList = intval($_POST['postId']);
                $dueDate = $_POST['dueDateNewTask'];
                $tag = 'urgent';
                $status = 0;

                $newTask = new TaskModel();
                $newlyCreatedTaskId = $newTask->createTask($taskName, $date, $dueDate, $tag, $idList, $status);

                echo json_encode([
                    "success" => true,
                    "message" => "Tâche ajoutée !",
                    'taskId' => $newlyCreatedTaskId,
                    "status" => $status
                ]);
            }
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Merci de donner un nom et une date butoir à votre tâche."
            ]);
        }
    }


    public function displayListTasks($idList)
    {
        $listTasks = new TaskModel();
        $tasks = $listTasks->getListTasks($idList);

        return $tasks;
    }

    public function changeTaskStatus(int $idTask, int $status): void
    {
        $taskStatus = new TaskModel();

        if ($status == 0) {
            $newStatus = 1;
        } else {
            $newStatus = 0;
        }
        $taskStatus->updateTaskStatus($idTask, $newStatus);

        echo json_encode([
            "success" => true,
            "message" => "Status mis à jour ! ", 
        ]);
    }
}
