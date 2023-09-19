<?php

namespace App\Controllers;

use App\Models\ListModel;

class ListController
{
    private $list;
    private $result;
    
    public function checkIfExists($listName): bool
    {
        $lists = new ListModel();
        $idUser = $_SESSION['user']->getId();
        $userLists = $lists->getUserLists($idUser);

        foreach ($userLists as $list) {
            if ($list['name'] == $listName) {
                return true;
            }
        }
        return false;
    }
    
    public function addNewList(string $name, int $idUser)
    {
        if (!$this->checkIfExists($_POST['newList'])) {
            $listModel = new ListModel();
            // $ListModel->createList($_SESSION['user']->getId());
            $listModel->createList($name, $idUser);
        } else {
            echo 'Cette liste existe déjà';
        }
    }

    function displayUserLists(int $idUser) : array {

        $userLists = new ListModel();
        $result = $userLists->getUserLists($idUser);

        return $result;
    }

}
