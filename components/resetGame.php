<?php

function resetGame(): void {
    session_unset();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

?>