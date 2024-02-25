<?php
$nomCommunes = getInstances($connexion, "Commune", true, "nomCo");
$nomDepartements = getInstances($connexion, "Département", true, "nomDep");

if(isset($_POST['beginTrial'])) {
    $nbcommune = rand(5, 20);
    $nbservice = rand(3, 5);
    $periodes = array(3,4,6);
    $services = array();
    $dateNow = getdate();
    for ($i = 1; $i <= $nbcommune; $i ++) {   
        $tmpserv = getRandServices($connexion);
        $row = array();
        foreach($tmpserv as $tmp){     
            $row[] = $tmp;
        }
        $services[] = $row;
    }
    $maxperiode = $_POST['ftperiode'];
    $departement = $_POST['ftdepartement'];
    $kilometre = $_POST['kilometre'];
    $communes = getCommune($connexion, $departement, $kilometre, $nbcommune);
    $erreurFT = FALSE;
    if(sizeof($communes)<$nbcommune){
        $erreurFT = TRUE;
    } else {
        $mois = array();
        for ($i = 1; $i <= $nbcommune; $i ++) {   
            $moi = getNbMois($periodes,$maxperiode);
            $mois[] = $moi;
        }
        $debutFreeTrial = $dateNow['mday'] . "-" . $dateNow['mon'] . "-" . $dateNow['year'];
        $finFreeTrial = array();
        foreach($mois as $moi){
            $tmpMois = array();
            $tmpMois = ($dateNow['mon'] + $moi ) % 12;
            if($tmpMois == 0){
                $tmpMois = 12;
            }
            $tmpAnnee =($dateNow['year']);
            if ($tmpMois<$dateNow['mon']){
                $tmpAnnee++;
            }
            $finFreeTrial[] = $dateNow['mday'] . "-" . $tmpMois . "-" . $tmpAnnee;
        }
        $libellés = array();
        foreach($services as $service){
            $liste = "";
            foreach($service as $libel){
                $liste .= $libel['libellé'] . ', ';
            }
            $liste = substr($liste,0,-2);
            $libellés[] = $liste;
        }
        for ($i = 0; $i < $nbcommune; $i++){
            $ajout = addFreeTrial($connexion, $communes[$i]['nomCo'], $mois[$i], $debutFreeTrial, $finFreeTrial[$i]);
            $idTrial = $ajout[0];
            $res = $ajout[1];
            foreach($services as $service){
                foreach($service as $libell){
                    //$idServAjout = getIDService($connexion,$libell['idService']);
                    $ajout = addServiceFreeTrial($connexion, $libell['libellé'], $libell['idService'], $idTrial);
                }
            }
        }
    }
}
?>