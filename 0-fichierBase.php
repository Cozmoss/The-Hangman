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

    // Dictionnaire de mots
    $fichier = 'liste_mots_finale.txt';
    
    function getMotMystereDepuisFichier($fichier) {
        // Vérifier si le fichier existe
        if (!file_exists($fichier)) {
            die("Erreur : le fichier $fichier n'existe pas.");
        }
    
        // Lire toutes les lignes du fichier dans un tableau
        $mots = file($fichier, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        // Vérifier si le fichier contient des mots
        if (empty($mots)) {
            die("Erreur : le fichier est vide ou ne contient aucun mot valide.");
        }
        
        return $mots;
    }

    // Tableau des lettres entrée par l'utilisateur
    $lettres = [];


    // Initialisation des différentes variables
    
    if (!isset($_SESSION['motMystere'])) {
        $_SESSION['motMystere'] = $mots[array_rand($mots)];
    }
    $motMystere = $_SESSION['motMystere']; //le mot à trouver
    
    if (!isset($_SESSION['lettres'])) {
        $_SESSION['lettres'] = []; // Lettres proposées
    }
    
    if (!isset($_SESSION['nbrEchec'])) {
        $_SESSION['nbrEchec'] = 0; // Nombre d'échecs
    }
    // Calcul des chances restantes
    $chancesRestante = NBR_CHANCE - $_SESSION['nbrEchec'];
    
    if (!isset($_SESSION['message'])) {
        $_SESSION['message'] = "Il vous reste $chancesRestante chances !"; // Initialiser avec une chaîne vide
    }

    

    // Réinitialisation du jeu
    if (isset($_POST['rejouer'])) {
        session_unset(); // Réinitialiser la session
        header("Location: " . $_SERVER['PHP_SELF']); // Recharger la page
        exit;
    }

    // Récupérer les lettres existantes comme tableau

    if (!empty($_POST['lettres'])) {
        $lettres = $_POST['lettres']; 
    }

    // Vérifier si une nouvelle lettre a été soumise
    if (isset($_POST['lettre'])) {
        $nouvelle_lettre = strtolower(trim($_POST['lettre'])); // Nettoyer et convertir en minuscule
    
        if (!empty($nouvelle_lettre)){ 
            // Vérifier si la lettre n'a pas encore été proposée
            if (!in_array($nouvelle_lettre, $_SESSION['lettres'])) {
                // Vérifier si la lettre proposée ne fait pas partie du mot mystère
                if (!in_array($nouvelle_lettre, str_split($motMystere))) {
                    $_SESSION['nbrEchec']++; 
                    $chancesRestante = NBR_CHANCE - $_SESSION['nbrEchec'];
                    $_SESSION['message'] = "Dommage, la lettre \"$nouvelle_lettre\" ne fait pas partie du mot. Il te reste $chancesRestante chances !";
                }
                else {
                    $_SESSION['message'] = "Bravo, la lettre \"$nouvelle_lettre\" fait partie du mot. Il te reste $chancesRestante chances !";
                }
                $_SESSION['lettres'][] = $nouvelle_lettre; // Ajouter la nouvelle lettre au tableau
            }
        }
    // Vérifier si un mot a été soumis
    } elseif (isset($_POST['mot'])) {
        $motPropose = strtolower(trim($_POST['mot']));

        if (!empty($motPropose)){
            if ($motPropose === $motMystere) {
            $_SESSION['message'] = "Félicitation, vous avez trouvé le bon mot !";
            $_SESSION['lettres'] = str_split($motMystere);
            }
            else {
                $_SESSION['nbrEchec']+=2;
                $chancesRestante = NBR_CHANCE - $_SESSION['nbrEchec'];
                // Ajouter les mauvaises lettre du mot aux lettre proposées
                foreach (str_split($motPropose) as $lettre){
                    if(!in_array($lettre, $_SESSION['lettres'])){
                        $_SESSION['lettres'][] = $lettre;
                    }
                }
                $_SESSION['message'] = "Dommage, \"$motPropose\" n'est pas le bon mot, vous avez perdu 2 chances. Il vous en reste $chancesRestante !";
            }
        } else {
            $_SESSION['message'] = "Veuillez entrer un mot valide.";
        }
    }


    // Vérifier si le mot entier a été trouvé
    $motTrouve = true; // On part du principe que le mot est trouvé
    foreach (str_split($motMystere) as $lettre) {
        if (!in_array($lettre, $_SESSION['lettres'])) {
            $motTrouve = false; // Si une lettre manque, le mot n'est pas encore trouvé
            break;
        }
    }

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
            <input type="text" name="mot" id="mot" placeholder="Proposez un mot" required>
            <button>Envoyer</button>
        </form>
        <p><?= htmlspecialchars($_SESSION['message']) ?></p>               
        <h4>Lettre proposées : </h4>
        <?php if (!empty($_SESSION['lettres'])): ?>
            <p><?= htmlspecialchars(implode(', ', $_SESSION['lettres'])) ?></p>
        <?php else: ?>
            <p>Aucune lettre n'a été prorposée pour le moment.</p>
        <?php endif; ?>
        </p>
    </div>
    <div class="pendu">
        <div class="potence">
            <div class="base <?php echo $_SESSION['nbrEchec'] > 0 ? 'visible' : 'hidden'; ?>"></div>
            <div class="pilier <?php echo $_SESSION['nbrEchec'] > 1 ? 'visible' : 'hidden'; ?>"></div>
            <div class="barre <?php echo $_SESSION['nbrEchec'] > 2 ? 'visible' : 'hidden'; ?>"></div>
            <div class="corde <?php echo $_SESSION['nbrEchec'] > 3 ? 'visible' : 'hidden'; ?>"></div>
        </div>
        <div class="bonhomme">
            <div class="tete <?php echo $_SESSION['nbrEchec'] > 4 ? 'visible' : 'hidden'; ?>"></div>
            <div class="corps <?php echo $_SESSION['nbrEchec'] > 5 ? 'visible' : 'hidden'; ?>"></div>
            <div class="bras bras-gauche <?php echo $_SESSION['nbrEchec'] > 6 ? 'visible' : 'hidden'; ?>"></div>
            <div class="bras bras-droit <?php echo $_SESSION['nbrEchec'] > 7 ? 'visible' : 'hidden'; ?>"></div>
            <div class="jambe jambe-gauche <?php echo $_SESSION['nbrEchec'] > 8 ? 'visible' : 'hidden'; ?>"></div>
            <div class="jambe jambe-droit <?php echo $_SESSION['nbrEchec'] > 9 ? 'visible' : 'hidden'; ?>"></div>
        </div>
    </div>
    <div>
        Mot à trouver : <?php
        // Générer l'affichage du mot en remplaçant les lettres non trouvées par des underscores
        foreach (str_split($motMystere) as $lettre) {
            if (in_array($lettre, $_SESSION['lettres'])) {
                echo strtoupper($lettre) . ' '; // Afficher la lettre trouvée en majuscule
            } else {
                echo '_ '; // Sinon, afficher un underscore
            }
        }
        ?>
    </div>
    <div class="reponse <?php echo $motTrouve ? 'visible' : 'hidden'; ?>">
        <div>
            <?php if ($motTrouve) {
                echo '<h1>You Win !</h1>';
                echo '<p>Félicitations, vous avez trouvé le mot !</p>';
                echo '<form action="" method="POST">
                    <button name="rejouer">Rejouer</button>
                    </form>';
                }elseif ($chancesRestante == 0) {
                    echo '<h1>Game Over</h1>
                    <p>Dommage, vous n\'avez pas trouvé le mot !</p>
                        <p>Le bon mot était : ' . $motMystere . ' !';
                echo '<form action="" method="POST">
                    <button name="rejouer">Rejouer</button>
                    </form>';
                }
            ?>
        </div>
    </div>
</body>

</html>