<?php

function processLetterSubmission(string $nouvelle_lettre, string $motMystere): void {
    if (!empty($nouvelle_lettre)) {
        if (!in_array($nouvelle_lettre, $_SESSION['lettres'])) {
            if (!in_array($nouvelle_lettre, str_split($motMystere))) {
                $_SESSION['nbrEchec']++;
                $chancesRestante = NBR_CHANCE - $_SESSION['nbrEchec'];
                $_SESSION['message'] = "Dommage, la lettre \"$nouvelle_lettre\" ne fait pas partie du mot. Il te reste $chancesRestante chances !";
            } else {
                $_SESSION['message'] = "Bravo, la lettre \"$nouvelle_lettre\" fait partie du mot. Il te reste $chancesRestante chances !";
            }
            $_SESSION['lettres'][] = $nouvelle_lettre;
        }
    }
}

?>