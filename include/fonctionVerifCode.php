<?php

// Fonction � disposition qui g�n�re un code al�atoire   -------------------------------------------------------------------
function getCodeAlea()
{
	// cr�ation du code al�atoire
	$code=""; // initialisation de la variable qui contiendra le code

	$lettre="abcdefghijklmnopqrstuvwxyz"; //constante contenant toutes les lettres qui constituront le code al�atoire

	$position=0;

	for ($i=0;$i<=9 ;$i++)
	{
		$position=rand(0,25); // on tire une position al�atoire	
	
		if($i==3||$i==6 ||$i==9) // en cas de nombre impair un chiffre sera ajout�
		{
			$code=$code.$position;
		}
	
		else //sinon on ajoute une lettre au code, tir�e au hasard gr�ce � la fonction rand();	
		{
			$code=$code.substr( $lettre , $position,1);
		}
	}
	return $code; // on retourne le code g�n�r�
}

// Fonction � disposition qui v�rifie l'existence d'un code pass� en param�tres ---------------------------------------------		
function verifExistCode($code)
{
	global $cnx;
	// requ�te de v�rification de l'existence du code al�atoire
	$req_pre = $cnx->prepare("SELECT * FROM mrbs_users WHERE password = :code");
	// liaison de la variable � la requ�te pr�par�e
	$req_pre->bindValue(':code', $code, PDO::PARAM_STR);
	$req_pre->execute();
	//le r�sultat est r�cup�r� sous forme d'objet
	$resultVerif=$req_pre->fetch(PDO::FETCH_OBJ);
	
	// si le code existe d�j�
	if($resultVerif == true)
	{
		return true;
	}
	// si au contraire le code n'existe pas
	else
	{
		return false;
	}
}

// Fonction � disposition appellant la cr�ation et la v�rification d'un code al�atoire ---------------------------
function getCode()
{
	$code=getCodeAlea(); 				// on g�n�re un code al�atoire
	while (verifExistCode($code)==true) // tant que le code cr�� existe d�j� alors on en g�n�re un nouveau
	{
		$code=getCodeAlea(); // g�n�ration d'un nouveau code		
	}
	return $code; // on retourne donc un code al�atoire unique
}

// ATTENTION : on ne met pas de balise de fin de script pour ne pas prendre le risque
// d'enregistrer d'espaces apr�s la balise de fin de script !!!!!!!!!!!!