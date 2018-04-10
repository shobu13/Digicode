<?php

// cette instruction doit toujours être la première ligne du code pour fonctionner!!!!!!!!!!!!!
session_start();
// inclusion des paramètres et de la bibliothéque de fonctions ("include_once" peut être remplacé par "require_once")
include_once ('include/_inc_parametres.php');

// connexion du serveur web à la base MySQL ("include_once" peut être remplacé par "require_once")
include_once ('include/_inc_connexion.php');

// echo '<pre>';
// print_r($_POST);
// echo '</pre>';

$digi = $_POST['digi'];
$newDigi = $_POST['newDigi'];

if (isset($_POST['newDigi']) == true) {
  $newDigi = strtoupper($_POST['newDigi']);
  $test = $cnx->query('SELECT digicode FROM mrbs_room_digicodes WHERE digicode="'.$digi.'"');
  $data = $test->fetch();
  if ($data['digicode'] != $digi)
  {
    if ($digi != "")
    {
      $req = $cnx->prepare('UPDATE mrbs_room_digicodes set digicode = :newDigi WHERE digicode=:digi');
      $req->bindValue(':digi', $digi, PDO::PARAM_STR);
      $req->bindValue(':newDigi', $newDigi, PDO::PARAM_STR);
      $req->execute();

      echo "UPDATE mrbs_room_digicodes set digicode = '".$newDigi."' WHERE digicode=:'".$digi."'";
      header('location: gestion.php');
    }
    else
    {
      $_SESSION['verifDigi'] = 1;
      header('location: modifDigi.php');
    }
  }
  else
  {
    $_SESSION['verifDigi'] = 1;
    header('location: modifDigi.php');
  }
}
if (isset($_POST['newMdp']) == true)
  {
    if ($_POST['newMdp'] == $_POST['newMdpConf'])
    {
      if ($_SESSION['password'] != $_POST['newMdp'])
      {
      $req = $cnx->prepare('UPDATE mrbs_users set password =:pass where name =:nom');
      $req->bindValue(':pass', md5($_POST['newMdp']), PDO::PARAM_STR);
      $req->bindValue(':nom', $_SESSION['nom'], PDO::PARAM_STR);
      $req->execute();

      header('location: gestion.php');
      }
    else
    {
    $_SESSION['verifMdp'] = 2;
    header('location: modifierMdp.php');
    }
  }
  else
  {
    $_SESSION['verifMdp'] = 1;
    header('location: modifierMdp.php');
  }
} 
?>