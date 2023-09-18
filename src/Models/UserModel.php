<?php

namespace App\Models;

use PDO;

class UserModel
{
    private ?int $id;
    private ?string $login;
    private ?string $firstname;
    private ?string $lastname;
    private ?string $password;
    private ?int $row;
    private ?int $role;

    public function __construct($id = null, $login = null, $firstname = null, $lastname = null, $password = null, $role = null)
    {
        $this->id = $id;
        $this->login = $login;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->password = $password;
        $this->role = $role;
    }

    public function connectDb(): PDO
    {
        $conn = new DatabaseModel;
        return $conn->connect();
    }

    public function setId(?int $id): UserModel
    {
        $this->id = $id;
        return $this;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function setLogin(?string $login): UserModel
    {
        $this->login = $login;
        return $this;
    }
    public function getLogin(): string
    {
        return $this->login;
    }

    public function setFirstname(?string $firstname): UserModel
    {
        $this->firstname = $firstname;
        return $this;
    }
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setLastname(?string $lastname): UserModel
    {
        $this->lastname = $lastname;
        return $this;
    }
    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setPassword(?string $password): UserModel
    {
        $this->password = $password;
        return $this;
    }
    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRow(): ?int
    {
        return $this->row;
    }

    public function setRole(?int $role): UserModel
    {
        $this->role = $role;
        return $this;
    }
    public function getRole(): ?int
    {
        return $this->role;
    }


    public function register(
        string $login,
        string $firstname,
        string $lastname,
        string $password,
    ): void {
        $request = "INSERT INTO user (login, firstname, lastname, password, role) VALUES (:login, :firstname, :lastname, :password, :role)";
        $newUser = $this->connectDb()->prepare($request);
        $newUser->bindValue(':login', $login);
        $newUser->bindValue(':firstname', $firstname);
        $newUser->bindValue(':lastname', $lastname);
        $newUser->bindValue(':password', $password);
        $newUser->bindValue(':role', 2);
        $newUser->execute();
    }

    public function checkIfLoginExists(string $login): void
    {
        $check = $this->connectDb()->prepare('SELECT * FROM user WHERE login = :login');
        $check->bindValue(':login', $login);
        $check->execute();
        $this->row = $check->rowCount();
    }

    public function getOneUserInfos(string $login)
    {
        $getUserInfos = $this->connectDb()->prepare('SELECT * FROM user WHERE login = :login');
        $getUserInfos->bindValue(':login', $login);
        $getUserInfos->execute();
        $userInfos = $getUserInfos->fetch();

        if (empty($userInfos)) {
            return null;
        } else return $userInfos;
    }


    public function getAllUsers(): array
    {
        $getUsers = $this->connectDb()->prepare("SELECT * from user ");
        $getUsers->execute();
        $userInfos = $getUsers->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($userInfos)) {
            return null;
        } else return $userInfos;
    }

    public function updateOne(array $params): void
    {
        $fieldsToUpdate = $params;
        array_pop($fieldsToUpdate);

        $requestString = [];

        foreach ($fieldsToUpdate as $key => $value) {
            $fieldName = str_replace(':', '', $key);
            $requestString[] = $fieldName . ' = ' . $key;
        }

        $requestString = implode(', ', $requestString);

        $requestUpdateOne = "UPDATE user SET $requestString WHERE login = :login";
        $queryUpdateOne = $this->connectDb()->prepare($requestUpdateOne);
        // var_dump($queryUpdateOne);
        $queryUpdateOne->execute($params);
    }

    public function deleteUser(string $login): void
    {
        $deleteUser = $this->connectDb()->prepare("DELETE FROM user WHERE login = :login");
        $deleteUser->bindValue(':login', $login);
        $deleteUser->execute();
    }
}
