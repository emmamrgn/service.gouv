<?php
$nomSite = "SERVICES.GOUV";
$baseline = "Informations et gestion de services communaux";
$styleCSS = "css/style.css";

define('REP_HISTO', 'historiques');  // répertoire des fichiers d'historique

// ajout d'une activité d'historique (avec date) à la session 
function ajouterActiviteHistorique($activite) {
	$_SESSION['historique'][] = array(date("Y-m-d H:i:s") => $activite);
}
?>
