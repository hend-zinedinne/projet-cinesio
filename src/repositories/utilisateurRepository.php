<?php

require_once __DIR__ . "/../database/connection.php";


function createUtilisateur(array $utilisateur)
{
    $connexion = getConnexion();

    $requeteSQL = "INSERT INTO utilisateur(email,pseudo, mot_de_passe)
    VALUES(
    :email,
    :pseudo,
    :mot_de_passe,
    )";
    $requete = $connexion->prepare($requeteSQL);

    foreach ($utilisateur as $cle => $valeurUtilisateur) {
        $requete->bindValue($cle, $valeurUtilisateur);
    }

    $requete->execute();
}

function findUtilisateurByEmail(string $email): ?array
{
    $connexion = getConnexion();

    // Requête paramétrée
    $requeteSQL = "SELECT *
    FROM utilisateur
    WHERE :email = email";
    $requete = $connexion->prepare($requeteSQL);
    $requete->bindValue("email", $email);
    $requete->execute();

    $resultat = $requete->fetch(PDO::FETCH_ASSOC);

    if (!$resultat) {
        return null;
    } else {
        return $resultat;
    }
}


function findUtilisateurByPseudo(string $pseudo): ?array
{
    $connexion = getConnexion();

    // Requête paramétrée
    $requeteSQL = "SELECT *
    FROM utilisateur
    WHERE :pseudo = pseudo";
    $requete = $connexion->prepare($requeteSQL);
    $requete->bindValue("pseudo", $pseudo);
    $requete->execute();

    $resultat = $requete->fetch(PDO::FETCH_ASSOC);
    if (!$resultat) {
        return null;
    } else {
        return $resultat;
    }
}

function addUtilisateur(array $data)
{
    $connexion = getConnexion();

    $requeteSQL = "INSERT INTO utilisateur(email, pseudo, mot_de_passe)
    VALUES(:email,:pseudo, :mot_de_passe)";
    $requete = $connexion->prepare($requeteSQL);

    $requete->bindValue("email", $data["email"]);
    $requete->bindValue("pseudo", $data["pseudo"]);
    $requete->bindValue("mot_de_passe", password_hash($data["mot_de_passe"], PASSWORD_DEFAULT));

    $requete->execute();
}

function findUtilisateurFromFilmID(int $filmID): ?array
{
    $connexion = getConnexion();

    // Requête paramétrée
    $requeteSQL = "SELECT *
    FROM utilisateur, film
    WHERE film.id_cree_utilisateur = utilisateur.id
    AND :filmID = film.id";
    $requete = $connexion->prepare($requeteSQL);
    $requete->bindValue("filmID", $filmID);
    $requete->execute();

    $resultat = $requete->fetch(PDO::FETCH_ASSOC);
    if (!$resultat) {
        return null;
    } else {
        return $resultat;
    }
}