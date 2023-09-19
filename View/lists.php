<?php
require_once '../vendor/autoload.php';
session_start();

use App\Controllers\UserController;
use App\Controllers\ListController;
use App\Models\ListModel;

$userController = new UserController();

if (isset($_GET['logOut'])) {
    $userController->logOut();
    die();
}

$taskModel = new ListModel();
$result = $taskModel->getUserLists($_SESSION['user']->getId());
var_dump($result);
var_dump($_SESSION['user']);

if (isset($_POST['submitList'])) {
    $taskController = new ListController();
    $taskController->addNewList($_POST['newList'], $_SESSION['user']->getId());
    var_dump($taskController->addNewList($_POST['newList'], $_SESSION['user']->getId()));
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faux Site</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <header><?php include './includes/header.php' ?></header>
    <div class="page">
        <div class="formContainer">
            <form action="" id="addListForm" method="post">
                <div class="input-group">
                    <input type="text" class="form-control" id="newList" name="newList" placeholder="Ajouter une liste">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary" name="submitList" id="submitList">+</button>
                    </div>
                </div>
            </form>
        </div>
        <div id="listsContainer">
            <h1 class="text-center">Mes listes</h1>
            <div class="row">
                <div class="col">
                    <table class="table table-bordered">
                        <tbody>
                            <?php foreach ($result as $task) : ?>
                                <tr>
                                    <td class="table-primary">
                                        <h4><?= $task['name'] ?></h4>
                                        <button type="submit" class="btn btn-primary" id="list<?= $task['id'] ?>">voir +</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
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