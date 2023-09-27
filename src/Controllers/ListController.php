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

    public function addNewList(string $listName, int $idUser): void
    {
        $listModel = new ListModel();
        $listName = strtolower(trim(htmlspecialchars($listName)));
        $listName = ucwords($listName);

        if (!$this->checkIfExists($listName) && !empty($listName)) {
            $listModel->createList($listName, $idUser);
            echo json_encode([
                "success" => true,
                "message" => "Votre liste a bien été créée."
            ]);
        } elseif (empty($listName)) {
            echo json_encode([
                "success" => false,
                "message" => "La liste doit porter un nom."
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Cette liste existe déjà."
            ]);
        }
    }

    function displayUserLists(int $idUser)
    {
        $userLists = new ListModel();
        $result = $userLists->getUserLists($idUser);
        echo json_encode($result);
    }

    function deleteList(int $idList, int $idUser): void
    {
        $delete = new ListModel();
        $delete->deleteLists($idList, $idUser);
        echo json_encode(['message' => 'La liste a bien été supprimée.']);
    }
}
