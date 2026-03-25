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

function getNombreFilms(): int
{
    $connexion = getConnexion();

    $requeteSQL = "SELECT COUNT(*) FROM film";
    $requete = $connexion->prepare($requeteSQL);
    $requete->execute();

    $nombreFilms = $requete->fetchColumn();

    return $nombreFilms;
}
function getPaysAbregeFromFilm($idFilm): ?string
{
    $connexion = getConnexion();

    // Requête paramétrée
    $requeteSQL = "SELECT initiale
    FROM film, pays
    WHERE film.id_pays = pays.id
    AND film.id = :id";
    $requete = $connexion->prepare($requeteSQL);
    // Execution : donner une valeur au paramètre :nom
    $requete->bindValue("id", $idFilm);
    $requete->execute();

    $pays = $requete->fetchColumn();

    if (!$pays) {
        return null;
    } else {
        return $pays;
    }
}

function getGenreFromFilm($idFilm): ?string
{
    $connexion = getConnexion();

    // Requête paramétrée
    $requeteSQL = "SELECT genre.nom
    FROM film, genre
    WHERE film.id_genre = genre.id
    AND film.id = :id";
    $requete = $connexion->prepare($requeteSQL);
    // Execution : donner une valeur au paramètre :nom
    $requete->bindValue("id", $idFilm);
    $requete->execute();

    $pays = $requete->fetchColumn();

    if (!$pays) {
        return null;
    } else {
        return $pays;
    }
}