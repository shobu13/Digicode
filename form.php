exemple de mail : <br/>
objet : <?php echo($_POST["objet"]); ?><br/>
destinataire : <?php echo($_POST["mail"]); ?><br/>
de : <?php echo($_POST["nom"]); ?> <br/>
Message : <?php echo($_POST["msg"]); ?>

<?php mail($_POST["mail"], $_POST["objet"], "Message le ".date("d-m-Y")." à ".date("g-i-s")."\r\r"."Message de : ".$_POST["nom"]." ".$_POST["prenom"]."\r\rMessage : ".$_POST["msg"]); 
header("Location: http://..");
?>