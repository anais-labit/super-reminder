<?php

namespace App\Models;

use DateTime;
use PDO;

class TaskModel
{
    private ?int $id;
    private ?string $name;
    private ?DateTime $dueDate;
    private ?string $tag;
    private ?int $idList;
    private ?int $status;

    public function __construct($id = null, $name = null, $dueDate = null, $tag = null, $idList = null, $status = 0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->dueDate = $dueDate;
        $this->tag = $tag;
        $this->idList = $idList;
        $this->status = $status;
    }

    public function connectDb(): PDO
    {
        $conn = new DatabaseModel;
        return $conn->connect();
    }
    public function createTask(string $name, string $date, string $dueDate, string $tag, $idList, int $status): int
    {
        $conn = $this->connectDb();

        $createList = $conn->prepare('INSERT INTO task (name, date, due_date, tag, id_list, status) VALUES (:name, NOW(), :due_date, :tag, :id_list, :status)');
        $createList->bindValue(':name', $name);
        $createList->bindValue(':due_date', $dueDate);
        $createList->bindValue(':tag', $tag);
        $createList->bindValue(':id_list', $idList);
        $createList->bindValue(':status', $status);
        $createList->execute();

        $lastInsertId = $conn->lastInsertId();

        return $lastInsertId;
    }



    public function getListTasks($idList)
    {
        $getTasks = $this->connectDb()->prepare('SELECT id, name, due_date, status, id_list FROM task WHERE id_list = :id_list ');
        $getTasks->bindValue(':id_list', $idList);
        $getTasks->execute();

        $tasks = $getTasks->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($tasks);

    }

    public function updateTaskStatus(int $idTask, int $newStatus): void
    {
        $updateTaskStatus = $this->connectDb()->prepare('UPDATE task SET status = :status WHERE id = :id');
        $updateTaskStatus->bindValue('id', $idTask);
        $updateTaskStatus->bindValue('status', $newStatus); 
        $updateTaskStatus->execute();
    }
}
