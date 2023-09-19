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
    <title>Super-Reminder</title>
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
                                <p>Maintenant que vous avez créé votre compte, vous pouvez créer vos Todolists et modifier vos informations personnelles. </p>
                                <a href="./lists.php" class="btn btn-primary">Créer mes ToDoLists</a>
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
                                Dans ce projet, nous avons développé une super To-Do-List qui permet aux utilisateurs de créer des listes et des tâches associées.
                            </p>
                            <p>Vous trouverez le détail des étapes suivies en cliquant sur "En savoir plus".</p>
                            <p>Le lien vers le repo GitHub se trouve dans le footer.</p>

                            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#voirPlus">
                                En savoir plus
                            </button>
                            <a href="./inscription.php" class="btn btn-primary">Créer un compte</a>
                            <div id="voirPlus" class="collapse">

                                <article>
                                    <section>
                                        <h5><br>Objectifs Atteints</h5>
                                        <p>Nous avons mis en place les fonctionnalités essentielles suivantes :</p>
                                        <ul>
                                            <li>Un système d'inscription et de connexion</li>
                                            <li>L'affichage d'une liste de tâches à accomplir</li>
                                            <li>La possibilité d'ajouter de nouvelles tâches à réaliser</li>
                                            <li>La gestion de l'état des tâches (par exemple : à faire, terminée)</li>
                                        </ul>
                                    </section>
                                    <section>
                                        <h5>Design Professionnel</h5>
                                        <p>Nous avons veillé à ce que notre site soit professionnel tout en restant simple et fonctionnel. Il est conçu de manière à être réactif, assurant une expérience utilisateur optimale, quelle que soit la plateforme utilisée.</p>
                                    </section>

                                    <section>
                                        <h5>Fonctionnalités Additionnelles (Optionnelles)</h5>
                                        <p>En plus des fonctionnalités de base, notre projet offre la possibilité d'aller encore plus loin si nécessaire :</p>
                                        <ul>
                                            <li>La création de plusieurs listes de tâches</li>
                                            <li>L'ajout de dates d'échéance pour les tâches</li>
                                            <!-- <li>L'attribution de tâches à un ou plusieurs utilisateurs</li>
                                            <li>L'ajout de sous-tâches pour une meilleure organisation</li> -->
                                            <li>L'utilisation de tags pour catégoriser les tâches</li>
                                            <!-- <li>Une fonction d'autocomplétion pour les tags</li> -->
                                            <li>La possibilité de prioriser les tâches selon l'importance</li>
                                        </ul>
                                    </section>
                                </article>
                                <section>
                                    <h5>Configuration de la Base de Données :</h5>
                                    <p>Nous avons choisi de créer 4 tables pour ce projet :
                                    <ul>
                                        <li>user : qui contient toutes les informations relatives à un utilisateur</li>
                                        <li>list : qui permet de créer des nouvelles listes de tâches</li>
                                        <li>task : qui permet de créer de nouvelles tâches</li>
                                        <li>list_user : qui vient faire le lien entre les listes et les utilisateurs et par la même, casser la relation many-to-many qui existait entre eux dans la mesure où une liste peut appartenit à plusieurs utilisateurs. </li>
                                    </ul>
                                </section>
                                <section>
                                    <h5>Architecture Model View Controller :</h5>
                                    <p>Nous avons opté pour la mise en place d'une architecture MVC afin de séparer clairement la logique métier de l'affichage, garantissant ainsi une structure de code plus organisée et compréhensible. Cela permet de séparer les conditions et instanciations php du html ainsi que de convoquer uniquement les méthodes spécifiques à la page sur laquelle agit l'utilisateur </p>
                                </section>
                                <section>
                                    <h5>Approche Orientée Objet :</h5>
                                    <p>
                                        Nous avons utilisé la programmation orientée objet (POO) pour développer ce projet. Nous avons créé une classe User pour représenter les utilisateurs, une classe List et une classs Task, ce qui nous a permis de structurer le code de manière efficace et assurer une collaboration fluide.
                                    </p>
                                </section>
                                <section>
                                    <h5>Sécurité :</h5>
                                    <p>
                                        Toutes les requêtes ont été sécurisées pour se prémunir contre d'éventuelles attaques et toutes les données saisies côté client ont été nettoyées avant insertion.
                                    </p>
                                </section>
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