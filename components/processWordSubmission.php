<?php

function processWordSubmission(string $motPropose, string $motMystere): void {
    if (!empty($motPropose)) {
        if ($motPropose === $motMystere) {
            $_SESSION['message'] = "Félicitation, vous avez trouvé le bon mot !";
            $_SESSION['lettres'] = str_split($motMystere);
        } else {
            $_SESSION['nbrEchec'] += 2;
            $chancesRestante = NBR_CHANCE - $_SESSION['nbrEchec'];
            foreach (str_split($motPropose) as $lettre) {
                if (!in_array($lettre, $_SESSION['lettres'])) {
                    $_SESSION['lettres'][] = $lettre;
                }
            }
            $_SESSION['message'] = "Dommage, \"$motPropose\" n'est pas le bon mot, vous avez perdu 2 chances. Il vous en reste $chancesRestante !";
        }
    } else {
        $_SESSION['message'] = "Veuillez entrer un mot valide.";
    }
}

?>