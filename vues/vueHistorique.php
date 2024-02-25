<h2>Historique des activités (de cette session)</h2>

<?php if(isset($message)) { ?>
	<p class="fond-jaune"><?= $message ?></p>
<?php } ?>

<ul>
<?php
	foreach($_SESSION['historique'] as $activiteDate)
		foreach($activiteDate as $date => $activite)
			echo "<li><strong>$date :</strong> $activite</li>";
?>
</ul>

<form action="#" method="post">
	<input type="submit" name="boutonGenHisto" value="Générer un fichier historique">
</form>
