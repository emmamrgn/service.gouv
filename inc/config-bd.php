<?php

/****************
Modifiez vos paramètres de connexion à la BD ci-dessous (dans le 'else', lignes 10 à 13)
****************/

if(file_exists('../serial-critique-private/config-bd.php'))  // fichier de configuration "privé" (enseignants)
	require('../serial-critique-private/config-bd.php');
else {
	define('SERVEUR', 'localhost');
	define('UTILISATRICE', 'p2021420'); // votre login, par exemple p1234567
	define('MOTDEPASSE', 'Panda40Wobble'); // votre mot de passe, par exemple Abcd12Efgh
	define('BDD', 'p2021420'); // votre BD, par exemple p1234567	
}
?>