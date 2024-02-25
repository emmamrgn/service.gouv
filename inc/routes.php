<?php

/*
** Il est possible d'automatiser le routing, notamment en cherchant directement le fichier controleur et le fichier vue.
** ex, pour page=afficher : verification de l'existence des fichiers controleurs/controleurAfficher.php et vues/vueAfficher.php
** Cela impose un nommage strict des fichiers.
*/

$routes = array(
	'afficher' => array('controleur' => 'controleurAfficher', 'vue' => 'vueAfficher'),
	'stats' => array('controleur' => 'controleurStats', 'vue' => 'vueStats'),
	'ajoutservice' => array('controleur' => 'controleurAjoutService', 'vue' => 'vueAjoutService'),
	'freetrial' => array('controleur' => 'controleurFreeTrial', 'vue' => 'vueFreeTrial'),
	'historique' => array('controleur' => 'controleurHistorique', 'vue' => 'vueHistorique'),
	'integration' => array('controleur' => 'controleurIntegration', 'vue' => 'vueIntegration')
);

// fichiers statiques
$pathHeader = 'static/header.php';
$pathMenu = 'static/menu.php';
$pathFooter = 'static/footer.php';
$controleurAccueil = 'controleurAccueil';
$vueAccueil = 'vueAccueil';
?>
