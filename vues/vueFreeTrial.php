<h2> Formulaire de période d'essai </h2>
<form method="post" action="#">
    <label for="frdepartement"> Veuillez renseigner votre département : </label>

    <select name="ftdepartement" id="ftdepartement">
        <?php foreach ($nomDepartements as $departement) { ?>
            <option value=<?php echo $departement['idDep']; ?>> <?php echo $departement['codeINSEE_Dep']; ?> - <?php echo $departement['nomDep']; ?> </option>
        <?php } ?>
    </select> </br> </br>

    <label for="ftperiode"> Periode d'essai (3 à 6 mois): </label>
        <input type="number" name="ftperiode" id="ftperiode" min="3" max="6" placeholder="ex: 4" required />
    </br> </br>

    <label for="ftkm"> Proximité des communes (km) : </label>
        <input type="number" name="kilometre" id="kilometre" min="1" max= "1000000" placeholder="ex: 150" required/>
    </br> </br>
    <input type="reset" value="Remettre à zéro" size="12" />
    <input type="submit" name="beginTrial" value="Commencer la période d'essai" size="12"/>

</form>
    <?php if(isset($_POST['beginTrial'])) { ?>
        <br>
        <?php if($erreurFT==FALSE){ ?>
            <label>Liste des périodes d'essai : </label>
            <div class="essais">
                <div class="essaicommune">
                    <?php foreach ($communes as $commune) { ?>
                        <div class="contentfreetrial">
                            <br><br>
                            La commune :<br>
                            <div class="info">
                                <?php echo $commune['nomCo']; ?> 
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="essaiservice">
                    <?php foreach ($libellés as $libellé) {?>
                        <div class="contentfreetrial">
                            <div class="info">
                                   <br><br> a accès aux services : <br>
                                   <?php echo $libellé; ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="essaimois">
                    <?php foreach ($mois as $moi) {?>
                        <div class="contentfreetrial">
                            <br><br>
                            pour une durée de : <br>
                            <div class="info">
                            <?php echo $moi; ?> mois.
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <br><br>
        <?php } else {
            echo "<h2> Attention: Il n'y a pas suffisamment de communes étant situés dans le rayon soumis (" . $kilometre . "km(s)).<h2>";
        } ?>
    <?php } ?>