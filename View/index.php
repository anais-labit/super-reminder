<?php
require_once '../vendor/autoload.php';
session_start();

use App\Controllers\UserController;

$userController = new UserController();

if (isset($_GET['logOut'])) {
    $userController->logOut();
    die();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Faux Site</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <header>
        <?php include './includes/header.php' ?>
    </header>

    <div class="page">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12">
                    <?php if (isset($_SESSION['login'])) { ?>
                        <h1>Bienvenue <?php echo ucwords($_SESSION['login']) ?></h1>

                        <?php if ($userController->validateAdminRole()) { ?>
                            <div class="alert alert-info mt-3">
                                En tant qu'administrateur, vous avez accès à toutes les données utilisateurs.
                            </div>
                            <a href="./admin.php" class="btn btn-primary mt-3">Voir la liste des utilisateurs</a>
                        <?php } else { ?>
                            <div>
                                <p>Maintenant que vous avez créé votre compte, vous pouvez modifier vos informations personnelles. </p>
                                <a href="./profil.php" class="btn btn-primary">Gérer mon profil</a>
                            </div>
                            <p><br></p>
                            <div class="alert alert-danger">
                                <p> En tant qu'utilisateur lambda, vous n'avez pas accès aux informations concernant les autres utilisateurs.</p>
                                <p>Pour vous connecter en tant qu'administrateur, utilisez les identifiants suivants :
                                <ul>
                                    <li>Login : admiN1337$</li>
                                    <li>Mot de passe : admiN1337$</li>
                                </ul>
                                </p>
                            </div>
                        <?php
                        }
                    } else { ?>
                        <section>
                            <h2>Description du projet :</h2>
                            <p>
                                Dans ce projet, j'ai développé un module de connexion complet qui permet aux utilisateurs de créer leur compte, de se connecter et de gérer leurs informations personnelles.
                            </p>
                            <p>Vous trouverez le détail des étapes suivies en cliquant sur "En savoir plus".</p>
                            <p>Le lien vers le repo GitHub se trouve dans le footer.</p>

                            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#voirPlus">
                                En savoir plus
                            </button>
                            <a href="./inscription.php" class="btn btn-primary">Créer un compte</a>
                            <div id="voirPlus" class="collapse">

                                <h5><br>Étape 1 : Configuration de la Base de Données</h5>
                                <p>
                                    Pour commencer, j'ai créé une base de données nommée "moduleconnexionb2" à l'aide de phpMyAdmin. À l'intérieur de cette base de données, j'ai créé une table "user" avec les champs suivants :
                                </p>
                                <ul>
                                    <li><strong>id</strong> (clé primaire, auto-incrémentée)</li>
                                    <li><strong>login</strong></li>
                                    <li><strong>firstname</strong></li>
                                    <li><strong>lastname</strong></li>
                                    <li><strong>password</strong></li>
                                </ul>
                                <p>
                                    J'ai également créé un utilisateur administrateur avec les informations de connexion suivantes :
                                </p>
                                <ul>
                                    <li>Login : "admiN1337$"</li>
                                    <li>Prénom : "Admin"</li>
                                    <li>Nom : "Admin"</li>
                                    <li>Mot de passe : "admiN1337$"</li>
                                </ul>
                                <h5>Étape 2 : Pages du Projet</h5>
                                <p>
                                    J'ai développé plusieurs pages pour mon projet :
                                </p>
                                <ul>
                                    <li><strong>Page d'Accueil (index.php) :</strong> Cette page présente mon site et explique son fonctionnement.</li>
                                    <li><strong>Page d'Inscription (inscription.php) :</strong> J'ai créé un formulaire d'inscription complet qui collecte les informations de l'utilisateur, y compris la confirmation du mot de passe. J'ai mis en place des règles de validation pour le mot de passe, et les logins doivent être uniques en base de données. Une fois l'utilisateur remplit ce formulaire, ses données sont insérées dans la base de données, et il est redirigé vers la page de connexion.</li>
                                    <li><strong>Page de Connexion (connexion.php) :</strong> Cette page contient un formulaire de connexion avec deux champs : "login" et "password". Lorsque l'utilisateur soumet le formulaire avec les informations correctes, il est considéré comme connecté, et des variables de session sont créées.</li>
                                    <li><strong>Page de Modification du Profil (profil.php) :</strong> Les utilisateurs connectés peuvent utiliser cette page pour modifier leurs informations personnelles. Le formulaire est pré-rempli avec les informations actuellement stockées en base de données.</li>
                                    <li><strong>Page d'Administration (admin.php) :</strong> Cette page est accessible uniquement par l'utilisateur "admin". Elle permet d'afficher la liste complète des informations des utilisateurs présents dans la base de données.</li>
                                </ul>
                                <h5>Approche Orientée Objet :</h5>
                                <p>
                                    J'ai utilisé la programmation orientée objet (POO) pour développer ce projet. J'ai créé une classe User pour représenter les utilisateurs, ce qui m'a permis de structurer mon code de manière efficace.
                                </p>
                                <h5>Design et Sécurité :</h5>
                                <p>
                                    J'ai veillé à ce que le site ait une structure HTML correcte et un design soigné grâce à Bootstrap. J'ai choisi un thème adapté à mon projet. De plus, toutes les requêtes ont été sécurisées pour se prémunir contre d'éventuelles attaques.
                                </p>
                            </div>
                        </section>
                    <?php } ?>
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