<?php

require_once __DIR__ . "/../database/connection.php";


function getAllFilms(): array
{
    $connexion = getConnexion();

    $requeteSQL = "SELECT * FROM film";
    $requete = $connexion->prepare($requeteSQL);
    $requete->execute();

    $films = $requete->fetchAll(PDO::FETCH_ASSOC);

    return $films;
}