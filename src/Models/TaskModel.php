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

    public function createTask(string $name, string $date, string $dueDate, string $tag, $idList, int $status): void
    {
        $createList = $this->connectDb()->prepare('INSERT INTO task (name, date, due_date, tag, id_list, status) VALUES (:name, NOW(), :due_date, :tag, :id_list, :status)');
        $createList->bindValue(':name', $name);
        $createList->bindValue(':due_date', $dueDate);
        $createList->bindValue(':tag', $tag);
        $createList->bindValue(':id_list', $idList);
        $createList->bindValue(':status', 0);
        $createList->execute();
    }

    public function getListTasks(int $idList): ?array
    {
        $getTasks = $this->connectDb()->prepare('SELECT * FROM task WHERE id_list = :id_list ');
        $getTasks->bindValue(':id_list', $idList);
        $getTasks->execute();

        $tasks = $getTasks->fetchAll(PDO::FETCH_ASSOC);

        if (!isset($tasks)) {
            return [];
        } else return $tasks;
    }
}
