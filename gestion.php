<?php
// cette instruction doit toujours être la première ligne du code pour fonctionner!!!!!!!!!!!!!
session_start();
// inclusion des paramètres et de la bibliothéque de fonctions ("include_once" peut être remplacé par "require_once")
include_once ('include/_inc_parametres.php');
include ('include/fonctionRandomDigi.php');
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
        <style>
        </style>
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
                                <li class="active"><a href="gestion.php">Accueil</a></li>
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
                    <div class="col-lg-6">
                        <div class="row responsive" style="padding-left: 15px; padding-right: 10px">
                            <div class="col-lg-8 responsive">
                                vous êtes actuellement authentifié en tant que : 
                            </div>
                        </div>
                        <div class="row responsive" style="padding-left: 15px; padding-right: 10px;">
                            <div class="col-lg-2 responsive">
                                <?= '<b>' . $_SESSION["level"] . '</b>'; ?>
                            </div>
                        </div>
                        <div class="row responsive" style="margin-top: 15px; padding-left: 15px; padding-right: 10px;">
                            <div class="col-lg-8 responsive">
                                <?php
                                $Digicode=[];
                                $req_pre = $cnx->prepare("SELECT DISTINCT room_name, mrbs_entry.id, FROM_UNIXTIME(start_time) AS dateDebut FROM `mrbs_entry`, `mrbs_room` WHERE mrbs_room.`id`=`room_id` AND `create_by`='".$_SESSION['nom']."' AND (SUBSTR(FROM_UNIXTIME(start_time),1,10)=SUBSTR(NOW(), 1, 10) OR SUBSTR(FROM_UNIXTIME(start_time),1,10)=SUBSTR(DATE_ADD(NOW(), INTERVAL 1 DAY), 1, 10))");
                                $req_pre->bindValue(':nom', $_SESSION['nom'], PDO::PARAM_STR);
                                $req_pre->execute();

                                while ($row = $req_pre->fetch(PDO::FETCH_OBJ)) {
                                    $Digicode[] = [$row->id, utf8_encode($row->room_name), $row->dateDebut];
                                }
                                if($Digicode) {
                                    echo "<p>Vos codes :</p>";
                                ?>
                            </div>
                        </div>
                        <div class="row" style="padding-left: 15px; padding-right: 10px;">
                            <div class="col-lg-10">
                                    <div id="tableContainer">
                                        <table id="table_books">
                                            <tr>
                                                <th>Salle</th>
                                                <th>Date</th>
                                                <th>Digicode</th>
                                                <th>Confirmer</th>
                                                <th>Annuler</th>
                                            </tr>
                                        <?php
                                            foreach ($Digicode as $i)
                                            {
                                                $req_pre = $cnx->query("INSERT INTO mrbs_entry_digicode(id) VALUES (".$i[0].")");
                                                $req_pre = $cnx->query("SELECT DISTINCT digicode, confirme FROM `mrbs_entry_digicode` WHERE id=".$i[0]."");

                                                // echo "INSERT INTO mrbs_entry_digicode(id) VALUES (".$i[0].")";

                                                echo '<tr><td>' . $i[1] . '</td>';
                                                echo '<td>' . $i[2] . '</td>';
                                                
                                                while ($conf = $req_pre->fetch(PDO::FETCH_OBJ))
                                                {
                                                    echo '<td>' . $conf->digicode . '</td>';
                                                    if ($conf->confirme == 0)
                                                    {
                                                        ?> <form action="traitement.php" method="POST">
                                                            <td class="text-center"><input type="checkbox" name="book[]"></td>
                                                            <td class="text-center"><input type="checkbox" name="supp[]"></td></tr>
                                                        </form>
                                                        <?php
                                                    }
                                                }
                                            }
                                        ?>
                                        </table>
                                    </div>
                                    <?php }
                                        else
                                            echo '<p>Vous n\'avez pas de réservation</p>'; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="col-lg-offset-5 col-lg-4">
                            <img id="kojima" class="img-fluid responsive" src="../images/Hideo.jpg" style="height: 200px; width: 300px;"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>