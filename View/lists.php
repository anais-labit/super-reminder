<?php
require_once '../vendor/autoload.php';
session_start();

use App\Controllers\UserController;
use App\Controllers\ListController;
use App\Controllers\TaskController;


$userController = new UserController();

if (isset($_GET['logOut'])) {
    $userController->logOut();
    die();
}



$listController = new ListController();

if ($_SESSION['user']) {
    $lists = $listController->displayUserLists($_SESSION['user']->getId());
    var_dump($lists);
}


if (isset($_POST['submitAddListForm'])) {
    $newListName = $_POST['newList'];
    $listController->addNewList($newListName, $_SESSION['user']->getId());
    die();
}

if (isset($_POST['submitDeleteListForm'])) {
    $listController->deleteList($_POST['postId'], $_SESSION['user']->getId());
    die();
}

$taskController = new TaskController();

if (isset($_POST['addTaskBtn'])) {
    $taskController->addNewTask(($_POST['newTaskName']), $_POST['dueDateNewTask'], $_POST['postId']);
    die();
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
    <script src="https://kit.fontawesome.com/427958ed2f.js" crossorigin="anonymous"></script>
    <script defer src="./javascript/create.js"></script>
    <!-- <script defer src="./javascript/update.js"></script> -->
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
                                <button type="submit" class="btn btn-primary" name="addListBtn" id="addListBtn"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="listsContainer">
                    <div class="row">
                        <div class="col">
                            <table class="table table-bordered">
                                <tbody>
                                    <?php if (isset($lists)) {
                                        foreach ($lists as $list) : ?>
                                            <tr>
                                                <td class="table-primary">
                                                    <h4><?= ucwords($list['name']) ?></h4>
                                                    <form action="" method="POST" class="deleteListForm">
                                                        <button type="submit" name="deleteListBtn" class="btn btn-danger deleteListBtn" data-list-id="<?= $list['id'] ?>"><i class="fa-solid fa-trash"></i></button>
                                                        <input type="hidden" name="postId" value="<?= $list['id'] ?>">
                                                    </form>
                                                    <div class="btn-group" role="group">
                                                        <form action="" method="POST" class="addTaskForm">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="newTaskName-<?= $list['id'] ?>" name="newTaskName-<?= $list['id'] ?>" placeholder="Ajouter une tâche">
                                                                <input type="date" class="form-control" id="dueDateNewTask-<?= $list['id'] ?>" name="dueDateNewTask-<?= $list['id'] ?>">

                                                                <div class="input-group-append">
                                                                    <button type="submit" name="addTaskBtn" class="btn btn-primary addTaskBtn" addTaskBtn data-list-id="<?= $list['id'] ?>">+</button>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="postId" value="<?= $list['id'] ?>">
                                                        </form>
                                                    </div>
                                                    <div id="tasksContainer-<?= $list['id'] ?>"></div>
                                                </td>
                                            </tr>
                                    <?php
                                        endforeach;
                                    }
                                    ?>
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