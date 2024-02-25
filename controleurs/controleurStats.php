<?php
ajouterActiviteHistorique('affichage des statistiques');

$nbCommune = countInstances($connexion, "Commune");
	$msgCommune = "Nombre de Communes : $nbCommune";
?>

<?php
$nbDep = countInstances($connexion, "Département");
	$msgDep = "Nombre de Départements : $nbDep";
?>

<?php
$nbReg = countInstances($connexion, "Région");
	$msgReg = "Nombre de Régions : $nbReg";
?>

<?php
$enfants = getEnfantEcole($connexion);
?>

<?php
$pairs = getPairEnfant($connexion);
?>

<?php
$departements = getTopTroisDepartement($connexion);
?>

<?php
$demandes = getTopTroisDemandeService($connexion);
?>

<?php
$offres = getTopTroisOffreService($connexion);
?>

<?php
$unions = getTopTroisUnion($connexion);
?>
