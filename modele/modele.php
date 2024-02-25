<?php 

// connexion à la BD, retourne un lien de connexion
function getConnexionBD() {
	$connexion = mysqli_connect(SERVEUR, UTILISATRICE, MOTDEPASSE, BDD);
	if (mysqli_connect_errno()) {
	    printf("Échec de la connexion : %s\n", mysqli_connect_error());
	    exit();
	}
	mysqli_query($connexion,'SET NAMES UTF8'); // noms en UTF8
	return $connexion;
}

// déconnexion de la BD
function deconnectBD($connexion) {
	mysqli_close($connexion);
}

// nombre d'instances d'une table $nomTable
function countInstances($connexion, $nomTable) {
	$requete = "SELECT COUNT(*) AS nb FROM $nomTable";
	$res = mysqli_query($connexion, $requete);
	if($res != FALSE) {
		$row = mysqli_fetch_assoc($res);
		return $row['nb'];
	}
	return -1;  // valeur négative si erreur de requête (ex, $nomTable contient une valeur qui n'est pas une table)
}

// retourne les instances d'une table $nomTable
function getInstances($connexion, $nomTable, $tri = FALSE, $tricolonne = "") {
	/*
	echo "getInstances";
	echo $nomTable;
	echo $tri;
	echo $tricolonne;
	*/
	$requete = "SELECT * FROM $nomTable";
	//echo $requete;
	if($tri == TRUE){
		$requete .= " ORDER BY $tricolonne";
	}
	//echo $requete;
	$res = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
	return $instances;
}
function getEnfantEcole($connexion) {
	$requete = "SELECT e.nomEnf, e.prénomEnf, l.nomL AS NomEcole FROM Enfant e NATURAL JOIN Classe c NATURAL JOIN Ecole a INNER JOIN Lieu l ON a.idLieu=l.idLieu";
	$res = mysqli_query($connexion, $requete);
	$enfant = mysqli_fetch_all($res, MYSQLI_ASSOC);
	return $enfant;
}

function getEnfantCantine($connexion) {
	$requete = "SELECT e.nomEnf, e.prenomEnf, c.nomCa FROM Ecole e NATURAL LEFT JOIN Cantine c NATURAL LEFT JOIN Repas r WHERE r.debutPeriode > '2024-01-01 00:00:00' AND r.finPeriode < '2009-01-02 00:00:00'";
	$res = mysqli_query($connexion, $requete);
	$enfantcantine = mysqli_fetch_all($res, MYSQLI_ASSOC);
	return $enfantcantine;
	
}

function getPairEnfant($connexion) {
	$requete = "SELECT DISTINCT e1.nomEnf , e1.prénomEnf, e1.idEnfant AS id1, e2.nomEnf AS Nom, e2.prénomEnf AS Prenom, e2.idEnfant AS id2 FROM Enfant e1 INNER JOIN Enfant e2 ON e1.nomEnf = e2.nomEnf INNER JOIN Classe c1 on e1.idClasse = c1.idClasse INNER JOIN Classe c2 on e2.idClasse = c2.idClasse WHERE NOT c1.idEcole = c2.idEcole AND e1.idEnfant < e2.idEnfant";
	$res = mysqli_query($connexion, $requete);
	$pair = mysqli_fetch_all($res, MYSQLI_ASSOC);
	return $pair;
}

function getTopTroisDepartement($connexion) {
	$requete = "SELECT D.nomDep AS nomDep, COUNT(C.idComm) AS nbCommunes FROM Département D NATURAL JOIN Commune C GROUP BY D.nomDep ORDER BY nbCommunes DESC LIMIT 3";
	$res = mysqli_query($connexion, $requete);
	$departements = mysqli_fetch_all($res, MYSQLI_ASSOC);
	return $departements;
}

function getTopTroisDemandeService($connexion) {
	$requete = "SELECT S.libellé AS libellé, COUNT(D.idDmd) AS nbDemande FROM Service S JOIN Demande D ON S.idService = D.idService GROUP BY S.libellé ORDER BY nbDemande DESC LIMIT 3";
	$res = mysqli_query($connexion, $requete);
	$demande = mysqli_fetch_all($res, MYSQLI_ASSOC);
	return $demande;
}

function getTopTroisOffreService($connexion) {
	$requete = "SELECT s.libellé, COUNT(sf.idServiceFT) AS nbOffre FROM Service s JOIN ServiceFreeTrial sf ON s.idService = sf.idService GROUP BY s.libellé ORDER BY nbOffre DESC LIMIT 3";
	$res = mysqli_query($connexion, $requete);
	$offre = mysqli_fetch_all($res, MYSQLI_ASSOC);
	return $offre;
}

function getTopTroisUnion($connexion) {
	$requete = "SELECT c.nomCo AS nom FROM Commune c NATURAL LEFT JOIN Service NATURAL LEFT JOIN Demande NATURAL LEFT JOIN ServiceUnionCivile ORDER BY COUNT(c.idComm) LIMIT 3";
	$res = mysqli_query($connexion, $requete);
	$unions = mysqli_fetch_all($res, MYSQLI_ASSOC);
	return $unions;
}

function integrerCommunes($connexion) {
    $requeteReg = "INSERT INTO p2021420.Région(nomR,codeINSEE_R) SELECT DISTINCT C.nom_region, C.code_region FROM dataset.Communes C WHERE C.nom_region='Auvergne-Rhône-Alpes' AND C.code_region NOT IN (SELECT codeINSEE_R FROM Région) ";
    mysqli_query($connexion,$requeteReg);

    $requeteDep = "INSERT INTO p2021420.Département(nomDep,codeINSEE_Dep,idReg) SELECT DISTINCT C.nom_departement, C.code_departement, R.idReg FROM dataset.Communes C INNER JOIN p2021420.Région R ON C.nom_region=R.nomR WHERE R.nomR='Auvergne-Rhône-Alpes' AND C.code_region NOT IN (SELECT codeINSEE_R FROM Région)";
    mysqli_query($connexion,$requeteDep);

    $requeteCom = "INSERT INTO p2021420.Commune(codeP,nomCo,longCo,latCo,codeINSEE_Co,idDep) SELECT DISTINCT C.code_postal, C.nom_commune_complet,C.longitude,C.latitude,C.code_commune_INSEE, D.idDep FROM dataset.Communes C INNER JOIN p2021420.Département D ON C.nom_departement=D.nomDep INNER JOIN p2021420.Région R ON D.idReg=R.idReg WHERE R.nomR='Auvergne-Rhône-Alpes'AND C.code_commune_INSEE NOT IN (SELECT Co.codeINSEE_Co FROM Commune Co)";
    mysqli_query($connexion,$requeteCom);

}

function getIDComm($connexion, $nomCommune) {
	$requete = "SELECT idComm FROM Commune WHERE nomCo ='" . $nomCommune . "'";
	$res = mysqli_query($connexion, $requete);
	$id = mysqli_fetch_array($res, MYSQLI_ASSOC);
	return $id;
}

function getRandServices($connexion) {
    $nb = rand(3, 5);
    $services = "SELECT idService, libellé FROM Service ORDER BY RAND() LIMIT " . $nb;
    $res = mysqli_query($connexion, $services);
	$service = mysqli_fetch_all($res, MYSQLI_ASSOC);
	return $service;
}

function getCommuneCentre($connexion, $departement) {
	$centre = "SELECT latCo, longCo FROM Commune WHERE idDep = " . $departement . " ORDER BY RAND() LIMIT 1";
	$res = mysqli_query($connexion, $centre);
	$communecentre = mysqli_fetch_array($res, MYSQLI_ASSOC);
	return $communecentre;
}

function getCommune($connexion, $departement, $kilometre, $nbcommune) {
	$communecentre = getCommuneCentre($connexion, $departement);
	$long = $communecentre['longCo'];
	$lat = $communecentre['latCo'];
	$commune = "SELECT nomCo FROM Commune WHERE idDep = " . $departement . " AND ST_DISTANCE_SPHERE(ST_GeomFromText(CONCAT('POINT(', longCo, ' ', latCo, ')')),ST_GeomFromText(CONCAT('POINT(', " . $long . ", ' ', " . $lat . ", ')'))) / 1000 < " . $kilometre . " ORDER BY RAND() LIMIT " . $nbcommune;
	$res = mysqli_query($connexion, $commune);
	$communes = mysqli_fetch_all($res, MYSQLI_ASSOC);
	return $communes;
}
//SELECT nomCo FROM (SELECT nomCo, latCo, longCo FROM Commune WHERE idDep = 1) AS C WHERE ST_DISTANCE_SPHERE(ST_GeomFromText(CONCAT('POINT(', C.longCo, ' ', C.latCo, ')')),ST_GeomFromText('POINT(0 0)')) / 1000 < 1000000
//SELECT nomCo FROM (SELECT nomCo, latCo, longCo FROM Commune WHERE idDep = 1) WHERE ST_DISTANCE_SPHERE(ST_GeomFromText('POINT(latCo longCo)'),ST_GeomFromText('POINT(@lat @long)')) / 1000 < 1000 LIMIT 21


function getNbMois($periodes,$maxperiode) {
	$listemois = array_filter($periodes, fn($var) => $var <= $maxperiode);
	$chiffre = random_int(0,sizeof($listemois)-1);
	return $listemois[$chiffre];
}

function getServiceByCommune($connexion,$libellé, $idComm){	
	$requete = "SELECT a.libellé,a.idComm FROM Service a NATURAL JOIN Commune c WHERE a.libellé = '" . $libellé . "' AND a.idComm = " . $idComm;
	$services = mysqli_query($connexion, $requete);
	return $services;
}

function addService($connexion, $libellé, $description, $debutOuverture, $finOuverture, $coût, $idComm, $colonnes, $newServ, $nomService){
	$libellé = mysqli_real_escape_string($connexion, $libellé); // vient d'un form
	$description = mysqli_real_escape_string($connexion, $description);
	$debutOuverture = mysqli_real_escape_string($connexion, $debutOuverture);
	$finOuverture = mysqli_real_escape_string($connexion, $finOuverture);
	$coût = mysqli_real_escape_string($connexion, $coût);
	$colonne = "";
	foreach($colonnes as $variables){
		$colonne .= $variables . " VARCHAR(50), ";
	}
	if($newServ==TRUE){
		$newTableService = "CREATE TABLE " . $nomService . " ( idService INT NOT NULL," . $colonne . "PRIMARY KEY(idService), FOREIGN KEY(idService) REFERENCES Service(idService))";
		mysqli_query($connexion, $newTableService);
		$libellé = $nomService;
	}
	$nomCo = "SELECT nomCo FROM Commune WHERE idComm = '" . $idComm . "'"; 
	$idServ = "SELECT idService FROM Service WHERE libellé = '" . $libellé . "'";
	$result = mysqli_query($connexion, $nomCo);
	$row = mysqli_fetch_assoc($result);
	$nomCo = $row['nomCo'];
	$donnees = addFreeTrial($connexion, $nomCo, 0, $debutOuverture, $finOuverture);
	$idTrial = $donnees[0];
	$ajout = addServiceFreeTrial($connexion, $libellé, $idServ, $idTrial);
	$requete= 'INSERT INTO `Service`(libellé,`description`,debutOuverture,finOuverture,coût) 
		VALUES("' . $libellé . '","' .  $description . '","' . $debutOuverture . '","' . $finOuverture . '",' . $coût . ')';
	$res= mysqli_query($connexion, $requete);

	return $res;

}

function addFreeTrial($connexion, $nomCo, $duréeFreeTrial, $debutFreeTrial, $finFreeTrial){
    $nomCo = mysqli_real_escape_string($connexion, $nomCo); 
    $duréeFreeTrial = mysqli_real_escape_string($connexion, $duréeFreeTrial);
    $debutFreeTrial = mysqli_real_escape_string($connexion, $debutFreeTrial);
    $finFreeTrial = mysqli_real_escape_string($connexion, $finFreeTrial);
    
    $ajout = "INSERT INTO FreeTrial(nomCo, duréeFreeTrial, debutFreeTrial, finFreeTrial) 
        VALUES ('" . $nomCo . "',$duréeFreeTrial,'" . $debutFreeTrial . "','" . $finFreeTrial . "')";
    $res = mysqli_query($connexion, $ajout);
    $idTrial = mysqli_insert_id($connexion); // recupere la dernière clé primaire ajoutée de FreeTrial
    $tmp = array();
    $tmp[] = $idTrial;
    $tmp[] = $res;
    return $tmp;
}

function addServiceFreeTrial($connexion, $libellé, $idservice, $idTrial){
	$libellé = mysqli_real_escape_string($connexion, $libellé);
	$idservice = mysqli_real_escape_string($connexion, $idservice);
	$ajoutserviceft = "INSERT INTO ServiceFreeTrial(libellé, idService, idTrial)
		VALUES ('" . $libellé . "'," . $idservice . "," . $idTrial . ")";
	$res = mysqli_query($connexion, $ajoutserviceft);
	return $res;
}
/*
function getIDService($connexion, $libellé){
	$libellé = mysqli_real_escape_string($connexion, $libellé);
	$id = "SELECT idService FROM Service WHERE libellé = '" . $libellé . "'";
	$res = mysqli_query($connexion,$id);
	return $res;
}
*/
?>
