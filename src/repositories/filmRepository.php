<?php

require_once __DIR__ . "/../database/connection.php";


function getDataFromFilms(): array
{
    $connexion = getConnexion();

    $requeteSQL = "SELECT film.id, film.titre, film.date_sortie, film.duree, film.synopsis, film.image, genre.nom AS nom_genre, pays.nom AS nom_pays, pays.initiale AS pays_initiale
    FROM film, genre, pays
    WHERE genre.id = film.id_genre
    AND film.id_pays = pays.id";
    $requete = $connexion->prepare($requeteSQL);
    $requete->execute();

    $films = $requete->fetchAll(PDO::FETCH_ASSOC);

    return $films;
}
function getFilmFromID($idFilm): ?array
{
    $connexion = getConnexion();

    // Requête paramétrée
    $requeteSQL = "SELECT film.id, film.titre, film.date_sortie, film.duree, film.synopsis, film.image, genre.nom AS nom_genre, pays.nom AS nom_pays, pays.initiale AS pays_initiale
    FROM film, genre, pays
    WHERE genre.id = film.id_genre
    AND film.id_pays = pays.id
    AND film.id = :id";
    $requete = $connexion->prepare($requeteSQL);
    $requete->bindValue("id", $idFilm);
    $requete->execute();

    $nomFilm = $requete->fetch(PDO::FETCH_ASSOC);

    if (!$nomFilm) {
        return null;
    } else {
        return $nomFilm;
    }
}

function addFilm($titreFilm, $genreFilm, $dateFilm, $dureeFilm, $synopsisFilm, $idImageFilm, $idPaysFilm): {
}