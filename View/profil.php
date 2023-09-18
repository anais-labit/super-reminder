<?php
require_once '../vendor/autoload.php';
session_start();

use App\Controllers\UserController;

$userController = new UserController();

if (isset($_POST['updateProfile'])) {
    $reqUpdate = $userController->updateFields($_SESSION['user']->getLogin(), $_POST);
    die();
}

if (isset($_POST['deleteForm'])) {
    $reqDelete = $userController->selfDelete($_SESSION['user']->getLogin());
    die();
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <script defer src="./javascript/update.js"></script>
    <script defer src="./javascript/delete.js"></script>

    <title>Profil</title>
</head>

<header class="gl-header"> <?php include './includes/header.php' ?></header>

<body>
    <div class="page">
        <div class="container mt-5">
            <form action="" method="POST" id="updateForm">
                <h2 class="text-center">Gestion du Profil</h2>
                <div class="mb-3">
                    <label for="login" class="form-label">Login</label>
                    <input type="text" class="form-control" id="newLogin" placeholder="<?= ucwords($_SESSION['user']->getLogin()) ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="firstname" class="form-label">Prénom</label>
                    <input type="text" class="form-control" id="newFirstname" name="newFirstname" value="<?= ucwords($_SESSION['user']->getFirstname()) ?>">
                </div>
                <div class="mb-3">
                    <label for="lastname" class="form-label">Nom de famille</label>
                    <input type="text" class="form-control" id="newLastname" name="newLastname" value="<?= ucwords($_SESSION['user']->getLastname()) ?>">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Nouveau mot de passe</label>
                    <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Nouveau mot de passe">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Confirmation nouveau mot de passe</label>
                    <input type="password" class="form-control" id="confNewPassword" name="confNewPassword" placeholder="Confirmation nouveau mot de passe">
                </div>
                <div class="form-group">
                    <button type="submit" name="updateButton" id="updateButton" class="btn btn-primary">Modifier le Profil</button>
                </div>
            </form>
            <form action="" method="POST" id="deleteForm">
                <button type="submit" name="deleteButton" id="deleteButton" class="btn btn-danger">Supprimer le Compte</button>
            </form>
            <p><br></p>
            <p id="message"></p>
            <p><br></p>
        </div>
    </div>
    <footer class="bg-dark text-light text-center py-3">
        <?php include './includes/footer.php'; ?></footer>
</body>

</html>