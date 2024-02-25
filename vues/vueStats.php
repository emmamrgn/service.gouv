<h2>Statistiques :</h2>

<?php if(isset($msgCommune)) { ?>
    <p><?= $msgCommune ?></p>
<?php } ?>

<?php if(isset($msgDep)) { ?>
    <p><?= $msgDep ?></p>
<?php } ?>

<?php if(isset($msgReg)) { ?>
    <p><?= $msgReg ?></p>
<?php } ?>

<p>Liste des enfants et leur école : </p>
<?php if(!empty($enfants) && isset($enfants)) { ?>
    <ul>
        <?php foreach($enfants as $enfant) { ?>
            <li><?= $enfant['prénomEnf'] ?> <?= $enfant['nomEnf'] ?>, <?= $enfant['NomEcole'] ?></li>
        <?php } ?>
    </ul>
<?php } else { ?> <li> $enfants not set or empty </li> <?php } ?>

<p>Paires d'enfants d'école différente : </p>
<?php if(!empty($pairs) && isset($enfants)) { ?>
    <ul class='pair'>
        <?php foreach($pairs as $pair) { ?>
            <li><?= $pair['Nom'] ?> <?= $pair['Prenom'] ?>, idEnfant : <?= $pair['id1'] ?>, <?= $pair['id2'] ?></li>
        <?php } ?>
    </ul>
<?php } else { ?> <li> $pairs not set or empty </li> <?php } ?>

<p>Top 3 départements par nombre de communes : </p>
<?php if(!empty($departements) && isset($departements)) { ?>
    <ul class='top3'>
        <?php foreach($departements as $departement) { ?>
            <li><?= $departement['nomDep'] ?> avec <?= $departement['nbCommunes'] ?> communes.</li>
        <?php } ?>
    </ul>
<?php } else { ?> <li> $departements not set or empty</li> <?php } ?>

<p>Top 3 services les plus demandés : </p>
<?php if(!empty($demandes) && isset($demandes)) { ?>
    <ul class='top3'>
        <?php foreach($demandes as $demande) { ?>
            <li><?= $demande['libellé'] ?> avec <?= $demande['nbDemande'] ?> demandes.</li>
        <?php } ?>
    </ul>
<?php } else { ?> <li> $demandes not set or empty</li> <?php } ?>

<p>Top 3 services les plus proposés : </p>
<?php if(!empty($offres) && isset($offres)) { ?>
    <ul class='top3'>
        <?php foreach($offres as $offre) { ?>
            <li><?= $offre['libellé'] ?> avec <?= $offre['nbOffre'] ?> offres.</li>
        <?php } ?>
    </ul>
<?php } else { ?> <li> $offres not set or empty</li> <?php } ?>

<p>Top 3 des communes les plus maquées : </p>
<?php if(!empty($unions) && isset($unions)) { ?>
    <ul class='top3'>
        <?php foreach($unions as $union) { ?>
            <li><?= $union['nom'] ?></li>
        <?php } ?>
    </ul>
<?php } else { ?> <li> $unions not set or empty</li> <?php } ?>
