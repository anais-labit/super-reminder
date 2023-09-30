<?php

namespace App\Models;

use PDO;

class ListModel
{
    private ?int $id;
    private ?string $name;
    private ?int $idUser;

    public function __construct($id = null, $name = null, $idUser = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->idUser = $idUser;
    }

    public function connectDb(): PDO
    {
        $conn = new DatabaseModel;
        return $conn->connect();
    }

    public function getUserLists($idUser)
    {
        $query = 'SELECT list.id, list.name
              FROM list
              INNER JOIN user ON list.id_user = user.id
              WHERE user.id = :id_user
              ORDER BY list.id DESC';

        $check = $this->connectDb()->prepare($query);
        $check->bindValue(':id_user', $idUser, PDO::PARAM_INT);
        $check->execute();

        $lists = $check->fetchAll(PDO::FETCH_ASSOC);

        return $lists;
    }

    public function createList(string $name, int $idUser): void
    {
        $createList = $this->connectDb()->prepare('INSERT INTO list (name, id_user) VALUES (:name, :id_user)');
        $name = ucwords($name);
        $createList->bindValue(':name', $name);
        $createList->bindValue(':id_user', $idUser);
        $createList->execute();
    }

    public function deleteLists(string $idList, int $idUser): void
    {
        $tasksQuery = $this->connectDb()->prepare("SELECT id FROM task WHERE id_list = :idList");
        $tasksQuery->bindValue(':idList', $idList);
        $tasksQuery->execute();

        while ($task = $tasksQuery->fetch(PDO::FETCH_ASSOC)) {
            $taskId = $task['id'];
            $deleteTask = $this->connectDb()->prepare("DELETE FROM task WHERE id = :id");
            $deleteTask->bindValue(':id', $taskId);
            $deleteTask->execute();
        }

        $deleteList = $this->connectDb()->prepare("DELETE FROM list WHERE id = :id AND id_user = :idUser");
        $deleteList->bindValue(':id', $idList);
        $deleteList->bindValue(':idUser', $idUser);
        $deleteList->execute();
    }
}
