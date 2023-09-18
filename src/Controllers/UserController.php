<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController
{
    private $user;

    function loginExists($login): bool
    {
        $loginValidation = new UserModel();

        $loginValidation->checkIfLoginExists($login);

        return ($loginValidation->getRow() !== 0);
    }

    function passwordValidation($password): bool
    {
        return (strlen($password) >= 8) &&
            preg_match('/[A-Z]/', $password) &&
            preg_match('/[0-9]/', $password) &&
            preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $password);
    }

    function newUser(
        string $login,
        string $firstname,
        string $lastname,
        string $password,
        string $confPassword,
    ): void {
        $login = trim(htmlspecialchars($_POST['login']));
        $firstname = trim(htmlspecialchars($_POST['firstname']));
        $lastname = trim(htmlspecialchars($_POST['lastname']));
        $password = trim(htmlspecialchars($_POST['password']));
        $confPassword = trim(htmlspecialchars($_POST['confPassword']));
        if (empty($login) || empty($firstname) || empty($lastname) || empty($password) || empty($confPassword)) {
            echo json_encode([
                "success" => false,
                "message" => "Tous les champs doivent être remplis."
            ]);
            return;
        }
        if (isset($login) && isset($firstname) && isset($lastname) && isset($password) && isset($confPassword) && (!$this->loginExists($login))) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            if (($password === $confPassword) && ($this->passwordValidation($password))) {
                $newUser = new UserModel();

                $_SESSION['welcomeLogin'] = $_POST['login'];

                $newUser->register($login, $firstname, $lastname, $hashedPassword);

                echo json_encode([
                    "success" => true,
                    "message" => "Inscription réussie. Vous allez être redirigé(e)."
                ]);
            } else if (!$this->passwordValidation($password)) {
                $message = json_encode([
                    "success" => false,
                    "message" => "Le mot de passe doit contenir au minimum huit caractères, une majuscule, un chiffre et un caractère spécial."
                ]);
                var_dump($message);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Les mots de passe ne correspondent pas."
                ]);
            }
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Ce login n'est pas disponible."
            ]);
        }
    }

    function logIn(string $login, string $password): void
    {
        $userValidation = new UserModel();

        $userInfos = $userValidation->getOneUserInfos($login);

        $user = $userValidation;
        $firstname = $userValidation->getOneUserInfos($login)['firstname'];
        $lastname = $userValidation->getOneUserInfos($login)['lastname'];
        $hashedPassword = $userValidation->getOneUserInfos($login)['password'];
        $role = $userValidation->getOneUserInfos($login)['role'];

        $user->setLogin($login)
            ->setFirstname($firstname)
            ->setLastname($lastname)
            ->setPassword($hashedPassword)
            ->setRole($role);

        $this->user = $user;
        $this->setSession();

        $hashedPassword = $userInfos['password'];

        if (empty($login) || empty($password)) {
            echo json_encode([
                "success" => false,
                "message" => "Renseignez votre mot de passe."
            ]);
            return;
        } else if ($this->loginExists($login) && password_verify($password, $hashedPassword)) {
            $_SESSION['login'] = $_POST['login'];
            echo json_encode([
                "success" => true,
                "message" => "Connexion réussie. Vous allez être redirigé(e)."
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Informations incorrectes."
            ]);
        }
    }

    function setSession(): void
    {
        $_SESSION['user'] = $this->user;
    }

    function logOut(): void
    {
        unset($_SESSION);
        session_destroy();
        header('Location:index.php');
    }

    function updateFields(string $login, array $values)
    {

        $userModel = new UserModel();
        $isValid = $this->passwordValidation(($values['newPassword']));

        if (isset($_POST['newFirstname']) && ($_POST['newFirstname'] !== $_SESSION['user']->getFirstname())) {
            $newFirstname = htmlspecialchars(trim($_POST['newFirstname']));
            $valuesToSend[':firstname'] = $newFirstname;
        }
        if (isset($_POST['newLastname']) && ($_POST['newLastname'] !== $_SESSION['user']->getLastname())) {
            $newLastname = htmlspecialchars(trim($_POST['newLastname']));
            $valuesToSend[':lastname'] = $newLastname;
        }
        if (($values['newPassword']) !== '' && ($values['confNewPassword']) !== '' && ((($values['newPassword']) === ($values['confNewPassword']))) && ($isValid)) {
            $valuesToSend[':password'] = htmlspecialchars(trim(password_hash($values['newPassword'], PASSWORD_DEFAULT)));
        }

        $valuesToSend[':login'] = $login;
        $userModel->updateOne($valuesToSend);
        $_SESSION['user']->setFirstname($_POST['newFirstname']);
        $_SESSION['user']->setLastname($_POST['newLastname']);
        $_SESSION['user']->setPassword($_POST['newPassword']);
        echo json_encode(['message' => 'Les mises à jour ont bien été prises en compte.']);
    }

    function validateAdminRole(): bool
    {
        if ($_SESSION['user']->getRole() === 1) {
            return true;
        } else return false;
    }

    function displayUsers(): array
    {
        $userInfos = new UserModel();
        $result = $userInfos->getAllUsers();

        return $result;
    }

    function selfDelete(string $login): void
    {
        $delete = new UserModel();
        $delete->deleteUser($login);
        echo json_encode(['message' => 'Votre compte a bien été supprimé.']);
        session_unset();
        session_destroy();
    }
}
