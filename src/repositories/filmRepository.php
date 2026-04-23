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

function addFilm($titreFilm, $genreFilm, $dateFilm, $dureeFilm, $synopsisFilm, $idImageFilm, $idPaysFilm)
{
    $connexion = getConnexion();

    $requeteSQL = "INSERT INTO film(titre,date_sortie,duree,synopsis,image,id_genre,id_pays
    VALUES(
    :titre,
    :date_sortie,
    :duree,
    :synopsis,
    :image,
    :id_genre,
    :id_pays
    )";
    $requete = $connexion->prepare($requeteSQL);
    $requete->bindValue('titre', $titreFilm);
    $requete->bindValue('date_sortie', $genreFilm);
    $requete->bindValue('duree', $dateFilm);
    $requete->bindValue('synopsis', $dureeFilm);
    $requete->bindValue('image', $synopsisFilm);
    $requete->bindValue('id_genre', $idImageFilm);
    $requete->bindValue('id_pays', $idPaysFilm);
    $requete->execute(['titre' => $titreFilm]);

    $films = $requete->fetchAll(PDO::FETCH_ASSOC);
}
function getDataFromPays(): array
{
    $connexion = getConnexion();

    $requeteSQL = "id, nom, initiale
    FROM pays";
    $requete = $connexion->prepare($requeteSQL);
    $requete->execute();

    $films = $requete->fetchAll(PDO::FETCH_ASSOC);

    return $films;
}

function getDataFromGenre(): array
{
    $connexion = getConnexion();

    $requeteSQL = "SELECT id, nom
    FROM genre";
    $requete = $connexion->prepare($requeteSQL);
    $requete->execute();

    $films = $requete->fetchAll(PDO::FETCH_ASSOC);

    return $films;
}

print_r(getDataFromGenre());