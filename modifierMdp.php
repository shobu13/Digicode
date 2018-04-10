<?php
// cette instruction doit toujours être la première ligne du code pour fonctionner!!!!!!!!!!!!!
session_start();
// inclusion des paramètres et de la bibliothéque de fonctions ("include_once" peut être remplacé par "require_once")
include_once ('include/_inc_parametres.php');

// connexion du serveur web à la base MySQL ("include_once" peut être remplacé par "require_once")
include_once ('include/_inc_connexion.php');
?>
<!DOCTYPE HTML> 
<html lang="fr">

    <head>
        <title>Maison des Ligues</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="styles/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-lg-offset-4 col-lg-4">
                    <img class="responsive" src="images/logo.jpg">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12" style="background-color: lightgray; padding-left: 0px; padding-right: 0px;border: 2px solid black;">
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <div class="navbar-header">
                                <a class="navbar-brand" href="#"><?php echo($_SESSION["nom"]) ?></a>
                            </div>
                            <ul class="nav navbar-nav">
                                <li><a href="gestion.php">Accueil</a></li>
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Utilisateur
                                        <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="modifierMdp.php">Changer mot de passe</a></li>
                                    </ul>
                                </li>
                                <?php if ($_SESSION["level"] == "admin") echo('<li><a href="contact.php">Contact</a></li>') ?>
                                <li><a href="index.php?action=deconnexion">Déconnexion</a></li>
                            </ul>
                        </div>
                    </nav> 
                    <form method="post" action="traitement.php" id="changeMdp" class="form-group">
                        <div class="row" style="padding-left: 15px; padding-right: 15px">
                            <div class="col-lg-3 text-left">
                                Modification du mot de passe :
                            </div>
                            <div class="col-lg-3">
                                <input type="password" name="newMdp" class="form-control" placeholder="entrez votre mot de passe"/>
                            </div>
                            <div class="col-lg-3">
                                <input type="password" name="newMdpConf" class="form-control" placeholder="confirmez votre mot de passe">
                            </div>
                            <div class="col-lg-2">
                                <input type="submit" value="Valider" class="form-control btn btn-primary">
                            </div>
                        </div>
                        <div class="row" style="padding-left: 15px; padding-right: 15px">
                            <div class="col-lg-4 text-left">
                                <?php
                                if (isset($_SESSION['verifMdp'])) {
                                    if ($_SESSION['verifMdp'] == 1) {
                                        $_SESSION['verifMdp'] = 0;
                                        echo "<div style='color:red;'><p> Les deux mots de passe entrés sont différents </p></div>";
                                    }
                                    else if ($_SESSION['verifMdp'] == 2) {
                                        $_SESSION['verifMdp'] = 0;
                                        echo "<div style='color:red;'><p> Vous avez entré le même mot de passe </p></div>";
                                    }
                                }
                                ?>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
    </body>
</html>