<h2> Ajout d'un Service </h2>

<form method="post" action="#">
<label for="nomCommune"> <b> Commune : </b> </label>
<select name="nomCommune" id="nomCommune" required="required" >
<option value="">Sélectionner une commune</option>
	<?php foreach ($nomCommunes as $commune) { ?>
		<option value="<?php echo $commune['nomCo']; ?>"> <?php echo $commune['nomCo'];  echo ' ' ; echo $commune['codeP']; ?> </option>
	<?php } ?>
</select>
</br></br><br/>

<div> <b> Service : </b> </div>
<label> Service existants : </label>
<select name="libelle" id="libelle">
<option value="">Sélectionner un service</option>
	<?php foreach ($Services as $service) { ?>
		<option value="<?php echo $service['libellé']; ?>"> <?php echo $service['libellé']; ?> </option>
	<?php } ?>
</select>
<br/><br/>

<label for="nomS"> <b> OU </b> </br></br> Ajouter votre propre Service* :  </label>
<input type="text" name="nomS" id="nomS" placeholder="ex : Ramassage Scolaire" size="30"> (* Laisser VIDE si service choisi au-dessus) </input>
<br/><br/><br/>

<label for="description"> <b> Description du Service : </b> </label> </br>
<textarea name="description" id="description" rows="3" cols="35" placeholder= "Ce service sert à..." required="required"></textarea>
<br/><br/><br/>

<label for="colonnes"> Indiquer les informations liées au service demande si nouveau service (séparées par des espaces) : </label>
<input type="text" name="colonnes" id="colonnes" placeholder="bus chauffeur ..." size="50" required ></input>
<br><br><br>

<label for="ouverture"> <b> Période d'ouverture : </b> </label></br></br>
<label> Du : </label>
<input type="date" name="ouverture" id="ouverture" required="required" /> 
<label> Au : </label>
<input type="date" name="fermeture" id="fermeture" required="required" />

</br></br><br/>

<label> <b> Coût du Service : </b> </label>
<input type="number" name="cout" id="cout" min="0" max="500" placeholder="ex: 50" required="required"> € (0 si gratuit)</input>

<br/><br/><br/><br/>

<input type="reset" value="Réinitialiser toutes les valeurs" size="12" />
<input type="submit" name="boutonAddService" value="Confirmer" size="12"/>
</form>



<?php if(isset($msgDate)) { ?>
	<a class="fond-jaune"><?= $msgDate ?> </a>	
<?php } ?>



<?php if(isset($_POST['boutonAddService'])) { ?>

	<h2> Recap du Service </h2>

	<?php 
	$commune = mysqli_real_escape_string($connexion, $_POST['nomCommune']);
	if(isset($commune)) { ?>
		<p>Commune :  <?= $commune ?></p>
	<?php } ?>

	<?php if(isset($nomS)) { ?>
		<p> Nom du Service :  <?= $nomS . " " .  $libelle ?></p>
	<?php } ?>

	<?php if(isset($description)) { ?>
		<p> Description du Service :  <?= $description ?></p>
	<?php } ?>

	<?php if(isset($debutOuverture)) { ?>
		<?php if(isset($finOuverture)) { ?>
			<p> Ouverture :  <?= $debutOuverture ?> au <?= $finOuverture ?></p>
	<?php }} ?>

	<?php if(isset($cout)) { ?>
		<p> Coût du Service :  <?= $cout ?> € </p>
	<?php } ?>

	<?php if(isset($msgAddService)) { ?>
	<p class="fond-jaune"><?= $msgAddService ?> </p>	
	<?php } ?>

<?php } ?>