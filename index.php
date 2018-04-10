<?php
/* ouverture d'une session */
// cette instruction doit toujours être la première ligne du code pour fonctionner!!!!!!!!!!!!!
session_start();
// inclusion des paramètres et de la bibliothéque de fonctions ("include_once" peut être remplacé par "require_once")
include_once ('include/_inc_parametres.php');
// connexion du serveur web à la base MySQL ("include_once" peut être remplacé par "require_once")
include_once ('include/_inc_connexion.php');
?>
<!DOCTYPE HTML> 
<html lang="fr">
    <!-- début du html (bloc entête) -->
    <head>
        <title>Maison des Ligues</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="styles/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>

    <!-- Début du corps -->  
    <body>

        <div class="container">
            <div class="row">
                <div class="col-lg-offset-4 col-lg-4">
                    <img class="responsive" src="images/logo.jpg">
                </div>
            </div>

            <?php
            /* Vérification de la variable action qui ne contient rien lors de la 1ère exécution */
            if (isset($_GET['action']) && $_GET['action'] == "connexion") {
                /* Vérification des champs vides */
                if ($_POST['txtnom'] == "" OR $_POST['txtmdp'] == "") {
                    /* message d'erreur si les champs sont vides */
                    ?>
                    <div id="connexion">
                        <h3>Erreur de connexion</h3>
                        <div id="erreurCo">
                            Merci de bien vouloir renseigner les champs </br>
                            <a href="index.php"><u>Retour</u></a>
                        </div>
                    </div>
                    <?php
                }

                /* Si les champs sont remplis */ else {
                    /* recherche de l'utilisateur à partir de son nom et de son mot de passe */
                    // préparation de la requête
                    $req_pre = $cnx->prepare("SELECT * FROM mrbs_users WHERE name=:nom AND password=:mdp");
                    // liaison des variables à la requête préparée
                    $req_pre->bindValue(':nom', $_POST['txtnom'], PDO::PARAM_STR);
                    // dans la base de données de l'application VALRES, les mots de passe sont codés en md5 
                    $req_pre->bindValue(':mdp', md5($_POST['txtmdp']), PDO::PARAM_STR);
                    $req_pre->execute();
                    //le résultat est récupéré sous forme d'objet
                    $resultat = $req_pre->fetch(PDO::FETCH_OBJ);


                    //si aucune ligne trouvée
                    if (!$resultat) {
                        ?> <div id='connexion'>
                            <h3>Erreur de connexion</h3>
                            <div id='erreurCo'>
                                <p>Vous n'êtes pas enregistré, veuillez contacter l'administrateur !</p>
                                <a href='index.php'><u>Retour</u></a>
                            </div>
                        </div>
                        <?php
                    } else {
                        /* Si l'utilisateur a été trouvé  */
                        if ($resultat == true) {
                            /* sauvegarde de son nom et de son mot de passe dans des variables de session */
                            $_SESSION['nom'] = $_POST['txtnom'];
                            $_SESSION['password'] = $_POST['txtmdp'];

                            $req = $cnx->query("SELECT * FROM mrbs_room_digicodes;");
                            $req = $req->fetch();
                            $_SESSION['digicode'] = $req['Digicode'];
                            /* si l'utilisateur connecté est un administrateur ou bien un autre utilisateur */
                            if ($resultat->level == 2) {
                                $_SESSION['level'] = 'admin';
                            } else {
                                if ($resultat->level == 1) {
                                    $_SESSION['level'] = 'user';
                                } else {
                                    $_SESSION['level'] = 'none';
                                }
                            }

                            /* appel de la page suivante gestion.php */
                            header("Location:gestion.php");
                        } else {
                            /* affichage de l'erreur */
                            ?>
                            <div id="connexion">
                                <h3>Erreur de connexion</h3>
                                <div id="erreurCo">
                                    Erreur de connexion, informations erronées ! </br>							
                                    <a href="index.php"><u>Retour</u></a>
                                </div>
                            </div>
                            <?php
                        }
                    }
                }
            }
            /* Si l'action est déconnexion */ elseif (isset($_GET['action']) && $_GET['action'] == "deconnexion") {
                /* suppression des variables de session */
                session_unset();
                session_destroy();
                /* retour à la page index.php  */
                header("Location:index.php");
            } else {
                /* affichage du formulaire de saisie lors de la 1ère exécution */
                ?>

                <div class="row">
                    <div class="col-lg-12" style="background-color: lightgray; padding-left: 0px; padding-right: 0px;border: 2px solid black;">
                        <div class="row">
                            <div class="col-lg-offset-2 col-lg-1">
                                <h3>Connexion</h3>
                            </div>
                        </div>

                        <!-- rappel de cette page lors du clic sur le bouton Valider (2ème exécution) -->
                        <form action="index.php?action=connexion" method="post" class="form-group)">
                            <div class="row" style="padding-left: 15px; padding-right: 15px">
                                <div class="col-lg-2">
                                    Utilisateur :  
                                </div>
                                <div class="col-lg-4">
                                    <input type="text" name="txtnom" class='form-control' placeholder="pseudo">
                                </div>
                            </div>
                            <div class="row" style="padding-left: 15px; padding-right: 15px">
                                <div class="col-lg-2">
                                    Mot de passe : 
                                </div>
                                <div class="col-lg-4">
                                    <input type="password" name="txtmdp" class="form-control" placeholder="mot de passe">
                                </div>
                            </div>
                            <div class="row" style="padding-left: 15px; padding-right: 15px; padding-top: 15px;">
                                <div class="col-lg-6">
                                    <a href="forgetMdp.php" ><u>Mot de passe oublié</u></a>
                                    <input id="btn-co" type="submit" value="Valider" class="btn btn-primary">

                                </div>
                                <!-- <div class="col-lg-4" style="padding-left: 155px">
                                </div> -->
                                
                            </div>
                        </form>
                    </div>
            <?php
            }
            ?>
        </div>
    </body>
</html>