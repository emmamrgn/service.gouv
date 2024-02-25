<h2>Intégrer les Communes d'Auvergne-Rhône-Alpes</h2>


<form method="post" action="#">
	<label for="Integrer">Cliquer sur le bouton pour intégrer les communes à la base de données</label>
	<br/><br/>
	<input type="submit" name="boutonIntegrer" value="Intégrer les communes"/>
</form>


<?php if(isset($msgInt)) { ?>
	<p style="background-color: yellow;"><?= $msgInt ?></p>
<?php } ?>