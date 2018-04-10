<!-- Onglets du menu -->
<?php
	if ($_SESSION['level'] != "admin")
	{ ?>
		<ul>
			<a href="gestion.php"><li style="-webkit-border-top-left-radius: 5px;
										-moz-border-radius-topleft: 5px;border-top-left-radius: 5px;">Accueil</li></a>
			<a href="modifier.php"><li>Modifier</li></a>
			<a href="index.php?action=deconnexion"><li style="-webkit-border-top-right-radius: 5px;
														-moz-border-radius-topright: 5px;border-top-right-radius: 5px;">Déconnexion</li></a>
		</ul>
		<br/>
	<?php }
	else
	{ ?>
		<ul>
			<a href="gestion.php"><li style="-webkit-border-top-left-radius: 5px;
										-moz-border-radius-topleft: 5px;border-top-left-radius: 5px;">Accueil</li></a>
			<a href="modifier.php"><li>Modifier</li></a>
			<a href="contact.php"><li>Contact</li></a>
			<a href="index.php?action=deconnexion"><li style="-webkit-border-top-right-radius: 5px;
														-moz-border-radius-topright: 5px;border-top-right-radius: 5px;">Déconnexion</li></a>
		</ul>
		<br/>

	<?php } ?>
