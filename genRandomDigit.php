<html lang="fr">

    <head>
        <title>Maison des Ligues</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <?php
        include_once ('include/fonctionRandomDigi.php');
        include_once ('include/_inc_parametres.php');
// connexion du serveur web à la base MySQL ("include_once" peut être remplacé par "require_once")
        include_once ('include/_inc_connexion.php');

        $req_pre = $cnx->prepare("SELECT COUNT(*) as nbCodes FROM `mrbs_room_digicodes`");
        $req_pre->execute();
        $row = $req_pre->fetch(PDO::FETCH_OBJ);
        $nbCodes = $row->nbCodes;
        echo $nbCodes;
        
        for($i=1; $i<=$nbCodes; $i++)
        {
            $code=RandomDigi();
            $req_pre = $cnx->prepare("UPDATE `mrbs_room_digicodes` SET digicode='$code' WHERE id=$i");
            $req_pre->execute();
        }
        ?>
    </body>
</html>