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
    session_start();

    //constante d'environnement.
    const NBR_CHANCE = 10;


    //Dictionnaire de mots
    $mots = ["tablette", "ordinateur", "souris", "clavier", "portable", "smartphone"];


    // Choisir un mot aléatoire dans le tableau
    if (!isset($_SESSION['motMystere'])) {
        $_SESSION['motMystere'] = $mots[array_rand($mots)];
    }
    $motMystere = $_SESSION['motMystere']; //le mot à trouver
    
    // Réinitialiser le jeu si le bouton "Rejouer" est cliqué
    if (isset($_POST['rejouer'])) {
        session_unset(); // Réinitialiser la session
        header("Location: " . $_SERVER['PHP_SELF']); // Recharger la page
        exit;
    }

    //variables qui seront calculées à terme. Pour l'instant on indique "en dure" la valeur
    $nbrEchec = 0; // le nombre de faute
    $lettres = []; // les lettres trouvées séparées par une virgule.
    
    if (!empty($_POST['lettres'])) {
        $lettres = $_POST['lettres']; // Récupérer les lettres existantes comme tableau
    }

    // Vérifier si une nouvelle lettre a été soumise
    if (isset($_POST['lettre'])) {
        $nouvelle_lettre = $_POST['lettre'];
        if (!empty($nouvelle_lettre)) { // Vérifier si c'est une seule lettre
            $lettres[] = $nouvelle_lettre; // Ajouter la nouvelle lettre au tableau
        }
    }



    // Vérifier si le mot entier a été trouvé
    $motTrouve = true; // On part du principe que le mot est trouvé
    foreach (str_split($motMystere) as $lettre) {
        if (!in_array($lettre, $lettres)) {
            $motTrouve = false; // Si une lettre manque, le mot n'est pas encore trouvé
            break;
        }
    }



    $motPropose = "tablette";

    ?>
    <div class="clues">

        <h3>Proposez une lettre</h3>
        <form method="POST">
            <input type="text" name="lettre" id="lettre" maxlength="1" placeholder="Proposez une lettre" required>
            <?php if (!empty($lettres)): ?>
                <?php foreach ($lettres as $index => $lettre): ?>
                    <input type="hidden" name="lettres[]" value="<?= htmlspecialchars($lettre) ?>">
                <?php endforeach; ?>
            <?php endif; ?>
            <button>Envoyer</button>
        </form>
        <h3>Proposez un mot</h3>
        <form method="POST">
            <input type="text" name="motpropose" id="motpropose" placeholder="Proposez un mot" required>
            <button>Envoyer</button>
        </form>
        <h3>Lettre proposées : </h3>
        <?php if (!empty($lettres)): ?>
            <p><?= htmlspecialchars(implode(', ', $lettres)) ?></p>
        <?php else: ?>
            <p>Aucune lettre ajoutée pour le moment.</p>
        <?php endif; ?>
        <?php
        echo "Il te reste " . NBR_CHANCE . " chance.";
        ?>
        </p>
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
    <div>
        Mot à trouver : <?php
        // Générer l'affichage du mot en remplaçant les lettres non trouvées par des underscores
        foreach (str_split($motMystere) as $lettre) {
            if (in_array($lettre, $lettres)) {
                echo strtoupper($lettre) . ' '; // Afficher la lettre trouvée en majuscule
            } else {
                echo '_ '; // Sinon, afficher un underscore
            }
        }

        if ($motTrouve) {
            echo '<p>Félicitations, vous avez trouvé le mot !</p>';
            echo '<form action="" method="POST">
                    <button name="rejouer">Rejouer</button>
                    </form>';
        }
        ?>
    </div>
    <div class="reponse">

    </div>
</body>

</html>