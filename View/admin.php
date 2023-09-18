<?php
require_once '../vendor/autoload.php';
session_start();

use App\Controllers\UserController;

$userController = new UserController();

if (isset($_GET['logOut'])) {
    $userController->logOut();
    die();
}

if ($userController->validateAdminRole()) {
    $result = $userController->displayUsers();
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
        <div class="container mt-5">
            <?php if (!$userController->validateAdminRole()) : ?>
                <div class="alert alert-danger">
                    Vous n'avez pas accès à ces informations.
                </div>
                <a href="profil.php" class="btn btn-primary">Accédez à votre profil</a>
            <?php else : ?>
                <h1 class="text-center">Liste des utilisateurs</h1>
                <div class="row">
                    <div class="col">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Login</th>
                                    <th>Prénom</th>
                                    <th>Nom de famille</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result as $user) : ?>
                                    <tr>
                                        <td><?= $user['login'] ?></td>
                                        <td><?= $user['firstname'] ?></td>
                                        <td><?= $user['lastname'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
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