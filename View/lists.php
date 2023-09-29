<?php
require_once '../vendor/autoload.php';
session_start();

use App\Controllers\UserController;
use App\Controllers\ListController;
use App\Controllers\TaskController;

$userController = new UserController();
$listController = new ListController();
$taskController = new TaskController();



if (isset($_GET['logOut'])) {
    $userController->logOut();
    die();
}

if (isset($_GET['getUserLists'])) {
    $lists = $listController->displayUserLists($_SESSION['user']->getId());
    return $lists;
}

if (isset($_GET['getListTasks'])) {
    $tasks = $taskController->displayListTasks($_GET['id']);
    return $tasks;
}

if (isset($_POST['submitAddListForm'])) {
    $newListName = $_POST['newList'];
    $listController->addNewList($newListName, $_SESSION['user']->getId());
    die();
}


if (isset($_GET['deleteList'])) {
    $listController->deleteList($_GET['deleteList'], $_SESSION['user']->getId());
    die();
}

if (isset($_POST['addTaskBtn'])) {
    $taskController->addNewTask(($_POST['newTaskName']), $_POST['dueDateNewTask'], $_POST['postId']);
    die();
}

// if (isset($_POST['checkTaskForm'])) {
//     $taskController->changeTaskStatus($_POST['postTaskId'], $_POST['status']);
//     die();
// }

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
    <script defer src="./javascript/read.js"></script>
    <script defer src="./javascript/update.js"></script>
    <script defer src="./javascript/delete.js"></script>
</head>

<body>
    <header>
        <?php include './includes/header.php' ?>
    </header>
    <div class="page">
        <div class="container mt-5 custom-container ">
            <form action="" id="addListForm" method="post">
                <div class="input-group">
                    <input type="text" class="form-control border-0" id="newList" name="newList" placeholder="Créer une liste">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary" name="addListBtn" id="addListBtn"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="container mt-3">
            <p id="message"></p>
            <div id="listsContainer">
            </div>

            <div id="tasksContainer"></div>
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