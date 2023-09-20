<?php

namespace App\Controllers;

use App\Models\ListModel;

class ListController
{
    private $list;

    public function checkIfExists($listName): bool
    {
        $lists = new ListModel();
        $idUser = $_SESSION['user']->getId();
        $userLists = $lists->getUserLists($idUser);

        foreach ($userLists as $list) {
            if (strtolower($list['name']) == strtolower($listName)) {
                return true;
            }
        }
        return false;
    }

    public function addNewList(string $name, int $idUser): void
    {
        if (!$this->checkIfExists($_POST['newList'])) {
            $listModel = new ListModel();
            $listModel->createList($name, $idUser);
            echo json_encode([
                "success" => true,
                "message" => "Votre liste a bien été créée."
            ]);
        } else if ($this->checkIfExists($_POST['newList'])) {
            echo json_encode([
                "success" => false,
                "message" => "Cette liste existe déjà."
            ]);
        }
    }

    function displayUserLists(int $idUser): ?array
    {
        $userLists = new ListModel();
        $result = $userLists->getUserLists($idUser);

        return $result;
    }


    function deleteList(int $idList, int $idUser): void
    {
        $delete = new ListModel();
        $delete->deleteLists($idList, $idUser);
        echo json_encode(['message' => 'La liste a bien été supprimée.']);
    }
}
