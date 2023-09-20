<?php

namespace App\Controllers;

use App\Models\TaskModel;
use DateTime;

class TaskController
{
    private $task;
    

    // ajoute une tâche. 
    public function addNewTask(string $name, DateTime $date, DateTime $dueDate, string $tagName, int $idList)
    {
        if (!$this->checkIfExist($_POST['newTask'])) {
            $taskModel = new TaskModel();
            // $TaskModel->createTask($_SESSION['user']->getId());
            $taskModel->createTask($name, $date, $dueDate, $tagName, $idList);
        } else {
            echo 'Cette tache existe déjà';
        }
    }

    // vérifie que la tâche existe ou pas.
    public function checkIfExist($taskName): bool
    {
        $task = new TaskModel();
        $idUser = $_SESSION['user']->getId();
        $userTasks = $task->getUserTasks($idUser);

        foreach ($userTasks as $task) {
            if ($task['name'] === $taskName) {
                return true;
            }
        }
        return false;
    }

    // vérifie que le bouton submit est cliqué.
    public function checkSubmitButtonClicked(): bool {
        if (isset($_POST['submit-task'])) {
            return true;
        } else {
            return false;
        }
    }
}