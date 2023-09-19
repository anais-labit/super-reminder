<?php

namespace App\Models;

use DateTime;
use PDO;

class ListModel
{
    private ?int $id;
    private ?int $idUser;
    private ?int $idList;
    private ?string $name;
    private ?string $tagName;
    private ?DateTime $date;
    private ?DateTime $dueDate;

    public function __construct($id = null, $idUser = null, $idList = null, $name = null, $tagName = null, $date = null, $dueDate = null)
    {
        $this->id = $id;
        $this->idUser = $idUser;
        $this->idList = $idList;
        $this->name = $name;
        $this->tagName = $tagName;
        $this->date = $date;
        $this->dueDate = $dueDate;
    }

    public function connectDb(): PDO
    {
        $conn = new DatabaseModel;
        return $conn->connect();
    }

    public function setId(?int $id): ListModel
    {
        $this->id = $id;
        return $this;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function setIdUser(?string $idUser): ListModel
    {
        $this->idUser = $idUser;
        return $this;
    }
    public function getIdUser(): string
    {
        return $this->idUser;
    }

    public function setName(?string $name): ListModel
    {
        $this->name = $name;
        return $this;
    }
    public function getName(): string
    {
        return $this->name;
    }

    public function setDate(?string $date): ListModel
    {
        $this->date = $date;
        return $this;
    }
    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function setDueDate(?string $dueDate): ListModel
    {
        $this->dueDate = $dueDate;
        return $this;
    }
    public function getDueDate(): DateTime
    {
        return $this->dueDate;
    }

    public function setTagName(?string $tagName): ListModel
    {
        $this->tagName = $tagName;
        return $this;
    }
    public function getTagName(): string
    {
        return $this->tagName;
    }

    public function setIdList(?int $idList): ListModel
    {
        $this->idList = $idList;
        return $this;
    }
    public function getIdList(): ?int
    {
        return $this->idList;
    }

    public function getUserLists($idUser): array
    {
        $query = 'SELECT list.id, list.name
              FROM list
              INNER JOIN user ON list.id_user = user.id
              WHERE user.id = :id_user';

        $check = $this->connectDb()->prepare($query);
        $check->bindValue(':id_user', $idUser, PDO::PARAM_INT);
        $check->execute();

        $lists = $check->fetchAll(PDO::FETCH_ASSOC);

        return $lists;
    }



    public function createList(string $name, int $idUser): void
    {
        $createList = $this->connectDb()->prepare('INSERT INTO list (name, id_user) VALUES (:name, :id_user)');
        $createList->bindValue(':name', $name);
        $createList->bindValue(':id_user', $idUser);

        $createList->execute();
    }
}
