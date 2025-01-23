<?php

function enleverAccents($texte) {
        $recherche  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
    $remplace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');
    
    return str_replace($recherche, $remplace, $texte);
}

function convertirFichierSansAccents($fichierEntree, $fichierSortie) {
    // Vérifier si le fichier d'entrée existe
    if (!file_exists($fichierEntree)) {
        die("Erreur : Le fichier $fichierEntree n'existe pas.");
    }

    // Ouvrir le fichier d'entrée en lecture
    $handleEntree = fopen($fichierEntree, 'r');
    if (!$handleEntree) {
        die("Erreur : Impossible d'ouvrir le fichier $fichierEntree.");
    }

    // Ouvrir le fichier de sortie en écriture
    $handleSortie = fopen($fichierSortie, 'w');
    if (!$handleSortie) {
        fclose($handleEntree);
        die("Erreur : Impossible de créer le fichier $fichierSortie.");
    }

    // Lire chaque ligne du fichier d'entrée, enlever les accents, et écrire dans le fichier de sortie
    while (($ligne = fgets($handleEntree)) !== false) {
        $ligneSansAccents = enleverAccents(trim($ligne)); // Supprimer les accents et nettoyer
        fwrite($handleSortie, $ligneSansAccents . PHP_EOL); // Écrire dans le fichier de sortie
    }

    // Fermer les fichiers
    fclose($handleEntree);
    fclose($handleSortie);

    echo "Conversion terminée. Les mots sans accents ont été écrits dans $fichierSortie.\n";
}

// Exemple d'utilisation
$fichierEntree = 'liste_francais_simplifé_utf8.txt'; // Fichier source avec accents
$fichierSortie = 'liste_mots_finale.txt'; // Fichier cible sans accents

convertirFichierSansAccents($fichierEntree, $fichierSortie);


?>