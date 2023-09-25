<?php

use App\Controllers\UserController;

$role = new UserController();
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Super-Reminder</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto flex-column">
                <?php if (isset($_SESSION['user'])) : ?>
                    <?php if ($role->validateAdminRole()) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="./admin.php">Admin</a>
                        </li>
                    <?php else : ?>
                        <li>
                            <a class="nav-link" href="./lists.php">Lists</a>
                        </li>
                        <li>
                            <a class="nav-link" href="./profil.php">Profile</a>
                        </li>
                    <?php endif; ?>
                <?php else : ?>
                    <a class="nav-link" href="./connexion.php">Sign In</a>
                <?php endif; ?>
                <li id="logOut" class="nav-item">
                    <?php if (isset($_SESSION['user'])) : ?>
                        <a class="nav-link" href="index.php?logOut">Log Out</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</nav>