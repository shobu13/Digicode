<?php
session_start();
// inclusion des paramètres et de la bibliothéque de fonctions ("include_once" peut être remplacé par "require_once")
include_once ('include/_inc_parametres.php');

// connexion du serveur web à la base MySQL ("include_once" peut être remplacé par "require_once")
include_once ('include/_inc_connexion.php');
$users = $_POST["dest"];

foreach ($users as $i)
{
    echo $i;
    echo '<br/>';
    mail($i, $_POST["sbj"], $_POST["msg"]);
}

header("Location: http://..");
?>
