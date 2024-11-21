<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendu Fichier de Base</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
//constante d'environnement.
const NBR_CHANCE = 10;

//variables qui viennent du formulaire
$lettreProposee = "c"; //la lettre proposée qui sera recue via un formulaire plus tard
$isLettreOK = true;


//variable externe, elle viendra d'un fichier reprenant une liste de mots à terme
$motMystere = 'tablette'; //le mot à trouver



//variables qui seront calculées à terme. Pour l'instant on indique "en dure" la valeur
$nbrEchec = 6; // le nombre de faute
$lettres = 't,b'; // les lettres trouvées séparées par une virgule.


$motPropose = "tablette";

?>
    <div class="clues">
        <p>
            <?php 
            echo "Lettres déjà proposées : " . $lettres;
            echo "<br>";
            echo "Il te reste " . NBR_CHANCE . " chance.";
            ?>
        </p>
        <p><?php
            if (strpos($motMystere, $lettreProposee) !== false) {
                echo "Bravo, la lettre \"" . $lettreProposee . "\" fait partie du mot.";
            } else {
                echo "Dommage, la lettre \"" . $lettreProposee . "\" ne fait pas partie du mot.";
            }
        ?></p>
    </div>
<div class="pendu">
    <div class="potence">
        <div class="base <?php echo $nbrEchec >= 1 ? 'visible' : 'hidden'; ?>"></div>
        <div class="pilier <?php echo $nbrEchec >= 2 ? 'visible' : 'hidden'; ?>"></div>
        <div class="barre <?php echo $nbrEchec >= 3 ? 'visible' : 'hidden'; ?>"></div>
        <div class="corde <?php echo $nbrEchec >= 4 ? 'visible' : 'hidden'; ?>"></div>
    </div>
    <div class="bonhomme">
        <div class="tete <?php echo $nbrEchec >= 5 ? 'visible' : 'hidden'; ?>"></div>
        <div class="corps <?php echo $nbrEchec >= 6 ? 'visible' : 'hidden'; ?>"></div>
        <div class="bras bras-gauche <?php echo $nbrEchec >= 7 ? 'visible' : 'hidden'; ?>"></div>
        <div class="bras bras-droit <?php echo $nbrEchec >= 8 ? 'visible' : 'hidden'; ?>"></div>
        <div class="jambe jambe-gauche <?php echo $nbrEchec >= 9 ? 'visible' : 'hidden'; ?>"></div>
        <div class="jambe jambe-droit <?php echo $nbrEchec >= 10 ? 'visible' : 'hidden'; ?>"></div>
    </div>
</div>
<div class="reponse">
    <?php 
    if(NBR_CHANCE == 0) echo '<p>Game Over</p>';
    elseif ($motPropose === $motMystere) echo "<p>Le bon mot était : " . $motMystere . "</p>";
    ?>

</div>
</body>
</html>
