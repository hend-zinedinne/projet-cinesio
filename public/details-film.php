<?php

require_once __DIR__ . "/../src/lib/functions.php";
require_once __DIR__ . "/../src/repositories/filmRepository.php";
require_once __DIR__ . "/../src/repositories/utilisateurRepository.php";


$titreErreur = "";
$messageErreur = "";
$filmRecherche = null;
$id = $_GET['id'] ?? '';

$filmRecherche = getFilmFromID($id);

if ($id === '') {
    $titreErreur = "Identifiant incorrect";
    $messageErreur = "Aucun identifiant n'a été fourni.";
} elseif (filter_var($id, FILTER_VALIDATE_INT) === false) {
    $titreErreur = "Identifiant incorrect";
    $messageErreur = "L'identifiant du film doit être une valeur numérique.";
} elseif ($id <= 0) {
    $titreErreur = "Identifiant incorrect";
    $messageErreur = "L'identifiant du film doit être une valeur positive.";
} else {
    if ($filmRecherche === null) {
        $titreErreur = "Film introuvable";
        $messageErreur = "Désolé, le film que vous cherchez n'existe pas ou n'est plus disponible dans le catalogue.";
    }
}

if ($messageErreur === "") {
    $titre = "CinéSIO - " . $filmRecherche['titre'];
} else {
    $titre = "CinéSIO - Erreur";
}

include __DIR__ . "/../src/includes/header.php";

?>

<main>
    <a href="index.php" class="bouton-retour gris"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
            fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
        </svg> Retour au catalogue</a>

    <?php if ($messageErreur === ""): ?>

        <div class="card-details">
            <img src="<?= $filmRecherche['image'] ?>" alt="<?= $filmRecherche['titre'] ?>" class="card-details-image">
            <div class="card-details-info">
                <p><span class="card-details-badge violet"><?= $filmRecherche['pays_initiale'] ?></span> •
                    <?= $filmRecherche['nom_genre'] ?>
                    •
                    <?= substr($filmRecherche['date_sortie'], 0, 4) ?>
                </p>
                <p>Ajouté par <?= findUtilisateurFromFilmID($id)["pseudo"] ?></p>
                <h1 class="card-details-titre"><?= $filmRecherche['titre'] ?></h1>
                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="purple" class="bi bi-clock"
                        viewBox="0 0 16 16" class="violet">
                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0" />
                    </svg> <span class="card-details-duree"><?= convertirMinutes($filmRecherche['duree']) ?></span></p>
                <h3>Synopsis</h3>
                <p class="card-details-synopsis gris"><?= $filmRecherche['synopsis'] ?></p>
                <a href="#" class="card-button-details">On verra plus tard...</a>
            </div>
        </div>

    <?php else: ?>

        <div class="card-error">
            <h1 class="error-title"><?= $titreErreur ?></h1>

            <p class="error-info"><?= $messageErreur ?></p>

            <a href="index.php" class="btn-error">Explorer le catalogue</a>
        </div>

    <?php endif; ?>

</main>

<?php
include __DIR__ . "/../src/includes/footer.php";
?>