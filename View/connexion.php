<?php
require_once '../vendor/autoload.php';
session_start();

use App\Controllers\UserController;

if (isset($_POST['submitForm']) && (!empty($_POST['password']))) {
    $connexion = new UserController();
    $connexion->logIn($_POST['login'], $_POST['password']);
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
    <script defer src="./javascript/login.js"></script>
    <title>Connexion</title>
</head>

<header class="gl-header"> <?php include './includes/header.php' ?></header>

<body>
    <div class="page">
        <div class="login-form">
            <form id="loginForm" action="" method="post">
                <h2 class="text-center">Connexion</h2>
                <p id="message"></p>
                <div class="form-group">
                    <label for="login" id="login"></label>
                    <input type="text" name="login" class="form-control" value="<?= isset($_SESSION['welcomeLogin']) ? ucwords($_SESSION['welcomeLogin']) : ''; ?>" placeholder="Login" required="required" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="password" id="password"></label>
                    <input type="password" name="password" class="form-control" placeholder="Mot de passe" required="required" autocomplete="off">
                </div>
                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary btn-block" id="signInBtn">Sign In</button>
                </div>
            </form>
            <p class="text-center"><a href="inscription.php">Sign Up</a></p>
        </div>
    </div>
    <footer class="bg-dark text-light text-center py-3">
        <?php include './includes/footer.php'; ?></footer>

</body>

</html>