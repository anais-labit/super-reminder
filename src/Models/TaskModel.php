<?php

namespace App\Models;

use DateTime;
use PDO;

class TaskModel
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
    public function getidUser(): string
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

    public function setIdList(?int $idList): TaskModel
    {
        $this->idList = $idList;
        return $this;
    }
    public function getIdList(): ?int
    {
        return $this->idList;
    }


    
}
