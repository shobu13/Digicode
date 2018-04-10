<?php
// cette instruction doit toujours être la première ligne du code pour fonctionner!!!!!!!!!!!!!
session_start();
// inclusion des paramètres et de la bibliothéque de fonctions ("include_once" peut être remplacé par "require_once")
include_once ('include/_inc_parametres.php');

// connexion du serveur web à la base MySQL ("include_once" peut être remplacé par "require_once")
include_once ('include/_inc_connexion.php');

//liste des admins
$users = [];
$query = "SELECT * FROM mrbs_users WHERE name != '".$_SESSION["nom"]."' ORDER BY name";

$reponse = $cnx->query($query);
while ($data = $reponse->fetch()) {
    $users[] = [$data["name"], $data["email"]];
}
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
                                <?php if ($_SESSION["level"] == "admin") echo('<li class="active"><a href="contact.php">Contact</a></li>') ?>
                                <li><a href="index.php?action=deconnexion">Déconnexion</a></li>
                            </ul>
                        </div>
                    </nav> 
                    <form class="form-group" action="mail.php" method="post">
                        <div class="row" style="padding-left: 15px; padding-right: 15px">
                            <div class="col-lg-2 text-left">
                                liste des destinataires :
                            </div>
                            <div class="col-lg-4">
                                <select multiple class="form-control" name="dest[]">
                                    <?php
                                    foreach ($users as $i) {
                                        echo('<option value='.$i[1].'>' . $i[0] . '</option>');
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="padding-left: 15px; padding-right: 15px">
                            <div class="col-lg-2 text-left">
                                Sujet :
                            </div>
                            <div class="col-lg-4">
                                <input required type="text" class="form-control" placeholder="objet du message" name="sbj"/>
                            </div>
                        </div>
                        <div class="row" style="padding-left: 15px; padding-right: 15px">
                            <div class="col-lg-2 text-left">
                                Message :
                            </div>
                            <div class="col-lg-4">
                                <textarea required class="form-control" placeholder="votre message" name="msg"></textarea>
                            </div>
                        </div>
                        <div class="row" style="margin: 5px;padding-left: 15px; padding-right: 15px">
                            <div class="col-lg-offset-4 col-lg-2 text-left">
                                <input type="submit" class="form-control btn btn-primary"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>