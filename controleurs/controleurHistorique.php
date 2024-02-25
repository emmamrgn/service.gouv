<?php 
ajouterActiviteHistorique('consultation historique');

if(isset($_POST['boutonGenHisto'])) {
	// créer un fichier sur le disque
	$nomFichier = session_id() . '.log';
	$cheminFichier = REP_HISTO . DIRECTORY_SEPARATOR . $nomFichier;
	//echo $cheminFichier;
	foreach($_SESSION['historique'] as $activiteDate)
		foreach($activiteDate as $date => $activite)
			file_put_contents($cheminFichier, "$date - $activite\n", FILE_APPEND);
	if(!is_readable($cheminFichier)) {
		$message = "Une erreur s'est produite, le fichier historique n'est pas disponible.";
	}
	else {
		$message = 'Télécharger le <a href="'.$cheminFichier.'">fichier historique généré</a>.';
	}
}

?>
