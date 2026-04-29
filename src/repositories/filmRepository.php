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

function addFilm(array $film)
{
    $connexion = getConnexion();

    $requeteSQL = "INSERT INTO film(titre,date_sortie,duree,synopsis,image,id_genre,id_pays, id_cree_utilisateur)
    VALUES(
    :titre,
    :date_sortie,
    :duree,
    :synopsis,
    :image,
    :id_genre,
    :id_pays,
    :id_user
    )";
    $requete = $connexion->prepare($requeteSQL);

    foreach ($film as $cle => $valeurFilm) {
        $requete->bindValue($cle, $valeurFilm);
    }

    $requete->execute();
}
function getPays(): array
{
    $connexion = getConnexion();

    $requeteSQL = "SELECT id, nom, initiale
    FROM pays";
    $requete = $connexion->prepare($requeteSQL);
    $requete->execute();

    $pays = $requete->fetchAll(PDO::FETCH_ASSOC);

    return $pays;
}

function getGenres(): array
{
    $connexion = getConnexion();

    $requeteSQL = "SELECT id, nom
    FROM genre";
    $requete = $connexion->prepare($requeteSQL);
    $requete->execute();

    $genre = $requete->fetchAll(PDO::FETCH_ASSOC);

    return $genre;
}

function getFilmDataByUserID(int $id): ?array
{
    $connexion = getConnexion();

    $requeteSQL = "SELECT film.id, film.titre, film.date_sortie, film.duree, film.synopsis, film.image, genre.nom AS nom_genre, pays.nom AS nom_pays, pays.initiale AS pays_initiale, film.id_cree_utilisateur
    FROM film, genre, pays, utilisateur
    WHERE genre.id = film.id_genre
    AND film.id_pays = pays.id
    AND film.id_cree_utilisateur = utilisateur.id
    AND :id = utilisateur.id";
    $requete = $connexion->prepare($requeteSQL);
    $requete->bindValue("id", $id);
    $requete->execute();

    $filmData = $requete->fetchAll(PDO::FETCH_ASSOC);

    if (!$filmData) {
        return null;
    } else {
        return $filmData;
    }

}