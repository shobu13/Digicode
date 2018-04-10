<?php
function dateFrancais($Date) {
		// extraction des 3 sous-chaines
		$jour = substr($Date,8,2);
		$mois = substr($Date,5,2);
		$annee = substr($Date,0,4);
		// renvoi de la concaténation de la date au format français
		return $jour.'/'.$mois.'/'.$annee;;
}
?>