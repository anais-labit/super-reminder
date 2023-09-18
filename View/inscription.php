<?php
require_once '../vendor/autoload.php';
session_start();

use App\Controllers\UserController;

if (isset($_POST['submitForm'])) {
    $registration = new UserController;
    $registration->newUser($_POST['login'], $_POST['firstname'], $_POST['lastname'], $_POST['password'], $_POST['confPassword']);
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <script defer src="./javascript/register.js"></script>
    <title>Registration</title>
</head>

<header class="gl-header"> <?php include './includes/header.php' ?></header>

<body>
    <div class="login-form">
        <form id="registerForm" action="" method="post">
            <h2 class="text-center">Inscription</h2>
            <p id="message"></p>

            <div class="form-group">
                <label for="login" id="login"></label>
                <input type="text" name="login" class="form-control" placeholder="Login" required="required" autocomplete="off">
                <p id="loginErr"></p>
            </div>
            <div class="form-group">
                <label for="firstname" id="firstname"></label>
                <input type="text" name="firstname" class="form-control" placeholder="Prénom" required="required" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="lastname" id="lastname"></label>
                <input type="text" name="lastname" class="form-control" placeholder="Nom" required="required" autocomplete="off">
            </div>
            <div class="form-group">
                <label style="text-align: justify;" for="password" id="password"></label>
                <input type="password" name="password" class="form-control" placeholder="Mot de passe" required="required" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="confPassword" id="confPassword"></label>
                <input type="password" name="confPassword" class="form-control" placeholder="Confirmation de mot de passe" required="required" autocomplete="off">
            </div>
            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-primary btn-block" id="signUpBtn">Sign Up</button>
            </div>
        </form>
        <p id="generalconnexion" class="text-center"><a href="connexion.php">Sign In</a></p>
    </div>
    <footer class="bg-dark text-light text-center py-3">
        <?php include './includes/footer.php'; ?></footer>
</body>

</html>