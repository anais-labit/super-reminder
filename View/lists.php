<?php
require_once '../vendor/autoload.php';
session_start();

use App\Controllers\UserController;
use App\Controllers\ListController;

$userController = new UserController();

if (isset($_GET['logOut'])) {
    $userController->logOut();
    die();
}

$listController = new ListController();

if ($_SESSION['user']) {
    $result = $listController->displayUserLists($_SESSION['user']->getId());
}

if (isset($_POST['submitListBtn'])) {
    $newListName = $_POST['newList'];
    $listController->addNewList($newListName, $_SESSION['user']->getId());
}

if (isset($_POST['deleteListBtn'])) {
    $listController->deleteList($_POST['postId'], $_SESSION['user']->getId());
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super-Reminder</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <script defer src="./javascript/create.js"></script>
    <script defer src="./javascript/update.js"></script>
    <script defer src="./javascript/delete.js"></script>
</head>

<body>
    <header>
        <?php include './includes/header.php' ?>
    </header>
    <div class="page">
        <div class="container mt-5">
            <h2 class="text-center">Mes listes</h2>
            <p id="message"></p>
            <div class="container">
                <div class="formContainer">
                    <form action="" id="addListForm" method="post">
                        <div class="input-group">
                            <input type="text" class="form-control" id="newList" name="newList" placeholder="Ajouter une liste">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary" name="submitListBtn" id="submitListBtn">+</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="listsContainer">
                    <div class="row">
                        <div class="col">
                            <table class="table table-bordered">
                                <tbody>
                                    <form action="" method="POST">
                                        <?php
                                        if (!empty($result)) {
                                            foreach ($result as $list) : ?>
                                                <tr>
                                                    <td class="table-primary">
                                                        <h4><?= ucwords($list['name']) ?></h4>
                                                        <div class="btn-group" role="group">
                                                            <button type="submit" name="openListBtn" class="btn btn-primary" id="openListBtn<?= $list['id'] ?>">Voir +</button>
                                                            <button type="submit" name="deleteListBtn" class="btn btn-danger" id="deleteListBtn" data-list-id="<?= $list['id'] ?>">Supprimer</button>
                                                            <input type="hidden" name="postId" value="<?= $list['id'] ?>">
                                                        </div>
                                                    </td>
                                                </tr>
                                        <?php endforeach;
                                        } ?>
                                    </form>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="bg-dark text-light text-center py-3">
        <?php include './includes/footer.php'; ?>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>