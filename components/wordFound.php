<?php

function isWordFound(string $motMystere): bool {
    foreach (str_split($motMystere) as $lettre) {
        if (!in_array($lettre, $_SESSION['lettres'])) {
            return false;
        }
    }
    return true;
}

?>