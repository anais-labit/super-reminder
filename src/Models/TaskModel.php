<?php

namespace App\Models;

use DateTime;
use PDO;

class TaskModel
{
    private ?int $id;
    private ?string $name;
    private ?DateTime $date;
    private ?DateTime $dueDate;
    private ?string $tagName;
    private ?int $idList;


    public function __construct($id = null, $name = null, $date = null, $dueDate = null,  $tagName = null, int $idList)
    {
        $this->id = $id;
        $this->name = $name;
        $this->date = $date;
        $this->dueDate = $dueDate;
        $this->tagName = $tagName;
        $this->idList = $idList;

    }

    public function connectDb(): PDO
    {
        $conn = new DatabaseModel;
        return $conn->connect();
    }

    public function setId(?int $id): TaskModel
    {
        $this->id = $id;
        return $this;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function setIdUser(?string $idUser): TaskModel
    {
        $this->idUser = $idUser;
        return $this;
    }
    public function getIdUser(): string
    {
        return $this->idUser;
    }

    public function setName(?string $name): TaskModel
    {
        $this->name = $name;
        return $this;
    }
    public function getName(): string
    {
        return $this->name;
    }

    public function setDate(?string $date): TaskModel
    {
        $this->date = $date;
        return $this;
    }
    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function setDueDate(?string $dueDate): TaskModel
    {
        $this->dueDate = $dueDate;
        return $this;
    }
    public function getDueDate(): DateTime
    {
        return $this->dueDate;
    }

    public function setTagName(?string $tagName): TaskModel
    {
        $this->tagName = $tagName;
        return $this;
    }
    public function getTagName(): string
    {
        return $this->tagName;
    }

    public function setidList(?string $idList): TaskModel
    {
        $this->idList = $idList;
        return $this;
    }
    public function getidList(): string
    {
        return $this->idList;
    }



    public function getUserTasks($idUser): array
    {
        $query = 'SELECT task.id, task.name
              FROM task
              INNER JOIN user ON task.id_user = user.id
              WHERE user.id = :id_user';

        $check = $this->connectDb()->prepare($query);
        $check->bindValue(':id_user', $idUser, PDO::PARAM_INT);
        $check->execute();

        $task = $check->fetchAll(PDO::FETCH_ASSOC);

        return $task;
    }

    public function createTask(string $name, DateTime $date, DateTime $dueDate, string $tagName, int $idList): void
    {
        $createTask = $this->connectDb()->prepare('INSERT INTO task (name, date, due_date, tag, id_list) VALUES (:name, :date, :due_date, :tag, :id_list)');
        $createTask->bindValue(':name', $name);
        $createTask->bindValue(':date', $date);
        $createTask->bindValue(':due_date', $dueDate);
        $createTask->bindValue(':tag', $tagName);
        $createTask->bindValue(':id_list', $idList);

        $createTask->execute();
    }
}