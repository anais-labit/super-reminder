<?php

namespace App\Controllers;

use App\Models\TaskModel;

class TaskController
{
    private $list;

    public function addNewList(string $name, int $idUser) {

        $taskModel = new TaskModel();
        // $taskModel->createList($_SESSION['user']->getId());
        $taskModel->createList($name, $idUser);


        // $list->setId($id)
        //     ->setName($name)
        //     ->setIdUser($idUser);

        // $this->list = $list;
        // $this->setSession();
        
    }




}
