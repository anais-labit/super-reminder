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

    // public function setId(?int $id): ListModel
    // {
    //     $this->id = $id;
    //     return $this;
    // }
    // public function getId(): ?int
    // {
    //     return $this->id;
    // }

    // public function setName(?string $name): ListModel
    // {
    //     $this->name = $name;
    //     return $this;
    // }
    // public function getName(): string
    // {
    //     return $this->name;
    // }

    // public function setIdUser(?string $idUser): ListModel
    // {
    //     $this->idUser = $idUser;
    //     return $this;
    // }
    // public function getIdUser(): int
    // {
    //     return $this->idUser;
    // }

    public function getUserLists($idUser): ?array
    {
        $query = 'SELECT list.id, list.name
              FROM list
              INNER JOIN user ON list.id_user = user.id
              WHERE user.id = :id_user';

        $check = $this->connectDb()->prepare($query);
        $check->bindValue(':id_user', $idUser, PDO::PARAM_INT);
        $check->execute();

        $lists = $check->fetchAll(PDO::FETCH_ASSOC);

        if (empty($lists)) {
            return null;
        } else return $lists;
    }

    public function createList(string $name, int $idUser): void
    {
        $createList = $this->connectDb()->prepare('INSERT INTO list (name, id_user) VALUES (:name, :id_user)');
        $createList->bindValue(':name', $name);
        $createList->bindValue(':id_user', $idUser);
        $createList->execute();
    }

    public function deleteLists(string $idList, int $idUser): void
    {
        $deleteList = $this->connectDb()->prepare("DELETE FROM list WHERE id = :id AND id_user = :idUser");
        $deleteList->bindValue(':id', $idList);
        $deleteList->bindValue(':idUser', $idUser);
        $deleteList->execute();
    }

}
