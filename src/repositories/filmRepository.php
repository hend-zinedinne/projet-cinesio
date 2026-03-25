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
function getPaysAbregeFromFilm($idFilm): int
{
    $connexion = getConnexion();

    // Requête paramétrée
    $requeteSQL = "SELECT initiale
    FROM film, pays
    WHERE film.id_pays = pays.id
    AND nom_etudiant = :id";
    $requete = $connexion->prepare($requeteSQL);
    // Execution : donner une valeur au paramètre :nom
    $requete->bindValue("id", $idFilm);
    $requete->execute();

    $pays = $requete->fetchAll(PDO::FETCH_ASSOC);

    if (!$pays) {
        return null;
    } else {
        return $pays;
    }
}