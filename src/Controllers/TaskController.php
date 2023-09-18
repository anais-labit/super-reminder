<?php

namespace App\Controllers;

use App\Models\TaskModel;

class TaskController
{
    private $task;

    function setTask(): void
    {
        $_SESSION['task'] = $this->task;
    }

}
