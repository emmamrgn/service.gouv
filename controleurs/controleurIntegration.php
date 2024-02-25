<?php 
ajouterActiviteHistorique('consultation intégration des communes');
if(isset($_POST['boutonIntegrer'])) { // formulaire soumis

	$verifR = countInstances($connexion, "Région");
    $verifD = countInstances($connexion, "Département");
    $verifC = countInstances($connexion, "Commune");

	if($verifR==0 && $verifD==0 && $verifC==0) {            // si les tables sont vides 
		integrerCommunes($connexion);
		$msgInt = "la table a été peuplée.";
        ajouterActiviteHistorique('les communes ont été intégrées');
	}
	else {
		$msgInt = "Tables déjà peuplées.";
	}
}
?>

