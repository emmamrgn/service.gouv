<?php 

ajouterActiviteHistorique('consultation ajout d\'un service');
$msgAddService = " ";
$nomCommunes = getInstances($connexion, "Commune", true, "nomCo");
$Services = getInstances($connexion, "Service", true, "libellé");

$isSetBoutonAjouter=isset($_POST['boutonAddService']);

if($isSetBoutonAjouter) { 
	$commune = mysqli_real_escape_string($connexion, $_POST['nomCommune']);
	$nomS = "";
	$nomS = $_POST['nomS'];
	$libelle = $_POST['libelle'];
	$description = $_POST['description'];
	$colonnes = $_POST['colonnes'];
	$colonnes = explode(" ",$colonnes);
	$nomServiceTable = "Service" . $nomS;
	$newServ = FALSE;
	if(isset($nomS)){
		$newServ = TRUE;
	}
	$dateO = mysqli_real_escape_string($connexion, $_POST['ouverture']);
	$dateF = mysqli_real_escape_string($connexion, $_POST['fermeture']);
	if($dateO>=$dateF){
		$msgDate = "ERREUR DATE : Veuillez séléctionner des dates cohérentes";
	}
	else {
			$debutOuverture = $dateO ;
			$finOuverture = $dateF;
	}
	$cout = $_POST['cout'];
	$idComm = getIDComm($connexion,$commune);

	$verification = getServiceByCommune($connexion, $libelle, $idComm['idComm']);

	if($verification == TRUE) {
		$msgAddService = "Il existe déjà un service avec ce nom ($libelle) à $commune";
		
	}
	if($verification == FALSE) {
		$insertService = addService($connexion,$libelle,$description,$dateO, $dateF, $cout, $idComm['idComm'], $colonnes, $newServ, $nomServiceTable, $nomS);
		$insertService;
	}	
	if ($insertService==TRUE) {
		$msgAddService = "Le Service $libelle a bien été ajouté !";
		ajouterActiviteHistorique("service $libelle ajouté");
	}
	else {
		$msgAddService = "Erreur lors de l'ajout du service $libelle.";
		ajouterActiviteHistorique("erreur ajout service $libelle");
	}
}	
?>

