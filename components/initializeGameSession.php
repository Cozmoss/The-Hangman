<?php

function initializeGameSession(array $mots): void {
    if (!isset($_SESSION['motMystere'])) {
        $_SESSION['motMystere'] = $mots[array_rand($mots)];
    }
    if (!isset($_SESSION['lettres'])) {
        $_SESSION['lettres'] = [];
    }
    if (!isset($_SESSION['nbrEchec'])) {
        $_SESSION['nbrEchec'] = 0;
    }
    $chancesRestante = NBR_CHANCE - $_SESSION['nbrEchec'];
    if (!isset($_SESSION['message'])) {
        $_SESSION['message'] = "Il vous reste $chancesRestante chances !";
    }
}

?>