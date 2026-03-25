<?php

require_once __DIR__ . "/../config/database.php";

function getConnexion(): PDO
{
    try { // Try permet de surveiller un bloc de code et la détecte.
        $dsn =
            "pgsql:host=" . DB_HOST .
            ";port=" . DB_PORT .
            ";dbname=" . DB_NAME
        ;

        $connexion = new PDO($dsn, DB_USER, password: DB_PASS);
        return $connexion;
    } catch (PDOException $erreur) { // En cas d'erreur, catch mettera l'erreur dans la variable $erreur.
        // Afficher le message d'erreur.
        echo "Erreur : " . $erreur->getMessage();
        exit;
    }
}