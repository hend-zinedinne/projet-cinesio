<?php
$titre = "CinéSIO";
include __DIR__ . "/../src/includes/header.php";
require_once __DIR__ . "/../src/lib/functions.php";
require_once __DIR__ . "/../src/repositories/filmRepository.php";
$films = getDataFromFilms();
$genres = getGenres();
$pays = getPays();

$genreOptions = ["" => "-- Selectionnez un genre --"];

foreach ($genres as $cle => $genre) {
    $genreOptions[$cle] = $genre["nom"];
}

$paysOptions = ["" => "-- Selectionnez un pays --"];

foreach ($pays as $cle => $pays_) {
    $paysOptions[$cle] = $pays_["nom"];
}

// Définir une variable par champs du formulaire
$titre = '';
$genre = '';
$date_sortie = '';
$duree = '';
$synopsis = '';
$image = '';
$pays = '';
$erreurs = []; // Tableau associatif pour les erreurs
$succes = false;

// Détecter la soumission du formulaire.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // le formulaire est soumis.
    // Récupérer chaque champ
    $titre = trim($_POST["titre"] ?? "");
    $genre = trim($_POST["genre"] ?? "");
    $date_sortie = trim($_POST["date_sortie"] ?? "");
    $duree = trim($_POST["duree"] ?? "");
    $synopsis = trim($_POST["synopsis"] ?? "");
    $image = trim($_POST["image"] ?? "");
    $pays = trim($_POST["pays"] ?? "");

    if ($titre == '') {
        $erreurs["titre"] = "Le titre n'a pas été saisi.";
    } elseif (mb_strlen($titre) < 3) {
        $erreurs["titre"] = "Le titre a moins de 3 caractères.";
    }

    if ($genre == '') {
        $erreurs["genre"] = "Aucun genre n'a été séléctionné.";
    } elseif (!array_key_exists($genre, $genreOptions)) {
        $erreurs["genre"] = "Le genre séléctionné est invalide.";
    }

    if ($date_sortie == '') {
        $erreurs["date_sortie"] = "Aucune date n'a été saisie.";
    } elseif (date_create_from_format('Y-m-d', $date_sortie)->format('Y-m-d') != $date_sortie) {
        $erreurs["date_sortie"] = "La date saisie est invalide." .  date_create_from_format('Y-m-d', $date_sortie)->format('Y-m-d');
    }

    if ($duree == '') {
        $erreurs["duree"] = "Aucune durée n'a été saisie.";
    } elseif (!is_numeric($duree)) {
        $erreurs["duree"] = "La durée saisie n'est pas un nombre.";
    }

    if ($synopsis == '') {
        $erreurs["synopsis"] = "Aucun synopsis n'a été saisi.";
    } elseif (mb_strlen($titre) < 5) {
        $erreurs["synopsis"] = "Le synopsis a moins de 5 caractères.";
    }

    if ($image == '') {
        $erreurs["image"] = "Aucune image n'a été ajoutée.";
    } elseif (!filter_var($image, FILTER_VALIDATE_URL)) {
        $erreurs["image"] = "Le lien saisi est invalide.";
    }

    if ($pays == '') {
        $erreurs["pays"] = "Aucun pays n'a été séléctionné.";
    } elseif (!array_key_exists($pays, $paysOptions)) {
        $erreurs["pays"] = "Le pays séléctionné est invalide.";
    }

    // Traitement des données saisies, uniquement dans le cas où aucune erreur n'a été produite.

    if (empty($erreurs)) {
        $succes = true;

        $film = [
            "titre" => $titre,
            "date_sortie" => $date_sortie,
            "duree" => $duree,
            "synopsis" => $synopsis,
            "image" => $image,
            "id_genre" => $genre,
            "id_pays" => $pays
        ];

        addFilm($film);

        // Réinitialiser les variables avec ''
        $titre = '';
        $genre = '';
        $date_sortie = '';
        $duree = '';
        $synopsis = '';
        $image = '';
        $pays = '';
    }
}

?>
<main>

    <?php if ($succes): ?>
        <div class="message-succes">Le profil a été créé avec succès.</div>
    <?php endif; ?>

    <a href="index.php" class="bouton-retour gris"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
            fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
        </svg> Retour au catalogue</a>

    <div class="card-creer">

        <form action="" method="POST" autocomplete="off" novalidate>

            <!-- TITRE -->
            <div class="card-creer-form">
                <label for="titre">Titre :<span class="required">*</span> :</label>
                <input type="text" id="titre" name="titre" placeholder="Ex: The Green Line" value="<?= $titre ?>"
                    required minlength="3">
                <!-- Afficher l'erreur si présente -->
                <?php if (isset($erreurs["titre"])): ?>
                    <div class="message-erreur"><?= $erreurs['titre'] ?></div>
                <?php endif; ?>
                <div class="hint">3 caractères minimum</div>
            </div>


            <div class="card-creer-2">
                <!-- DATE -->
                <div class="card-creer-form">
                   <label for="date_sortie">Date de sortie :<span class="required">*</span> :</label>
                        <input type="date" id="date_sortie" name="date_sortie" value="<?= $date_sortie ?>">
                        <!-- Afficher l'erreur si présente -->
                        <?php if (isset($erreurs["date_sortie"])): ?>
                            <div class="message-erreur">
                                <?= $erreurs['date_sortie'] ?>
                            </div>
                        <?php endif; ?>
                </div>
            

            <!-- DUREE -->
                <div class="card-creer-form">
                    <label for="duree">Durée :<span class="required">*</span> :</label>
                        <input type="number" id="duree" name="duree" value="<?= $duree ?>" placeholder="Ex: 165" required>
                        <!-- Afficher l'erreur si présente -->
                        <?php if (isset($erreurs["duree"])): ?>
                            <div class="message-erreur"><?= $erreurs['duree'] ?></div>
                        <?php endif; ?>
                    <div class="hint">En minutes uniquement</div>
                </div>

            </div>

            <!-- SYNOPSIS -->
            <div class="card-creer-form">
                <label for="synopsis">Synopsis :<span class="required">*</span> :</label>
                <input type="textarea" id="synopsis" name="synopsis" placeholder="Il était une fois..."
                    value="<?= $synopsis ?>" required minlength="10">
                <!-- Afficher l'erreur si présente -->
                <?php if (isset($erreurs["synopsis"])): ?>
                    <div class="message-erreur"><?= $erreurs['synopsis'] ?></div>
                <?php endif; ?>
                <div class="hint">10 caractères minimum</div>
            </div>

            <!-- IMAGE -->
            <div class="card-creer-form">
                <label for="image">Affiche web (URL de l'image) :<span class="required">*</span> :</label>
                <input type="link" id="image" name="image" placeholder="https://exemple.com/image.jpg" value="<?= $image ?>" required
                    minlength="5">
                <!-- Afficher l'erreur si présente -->
                <?php if (isset($erreurs["image"])): ?>
                    <div class="message-erreur"><?= $erreurs['image'] ?></div>
                <?php endif; ?>
                <div class="hint">Lien valide requis</div>
            </div>

            <div class="card-creer-2">
                        <!-- GENRE -->
            <div class="card-creer-form">
                <label for="genre">Genre :<span class="required">*</span> :</label>
                <select id="genre" name="genre" " required>
                    <?php foreach ($genreOptions as $valeur => $genreOption): ?>
                            <option value=" <?= $valeur ?>"
                        <?php if ($valeur == $genreOption): ?>selected<?php endif; ?>>
                        <?= $genreOption ?> </option> <?php endforeach; ?> <!-- remplissage dynamique des options -->
                </select>
                <?php if (isset($erreurs["genre"])): ?>
                    <div class="message-erreur"><?= $erreurs['genre'] ?></div>
                <?php endif; ?>
            </div>

            <!-- PAYS -->
            <div class="card-creer-form">
                <label for="pays">Pays :<span class="required">*</span> :</label>
                <select id="pays" name="pays" " required>
                    <?php foreach ($paysOptions as $valeur => $paysOption): ?>
                                                                                            <option value=" <?= $valeur ?>"
                        <?php if ($valeur == $paysOption): ?>selected<?php endif; ?>>
                        <?= $paysOption ?> </option> <?php endforeach; ?> <!-- remplissage dynamique des options -->
                </select>
                <?php if (isset($erreurs["pays"])): ?>
                    <div class="message-erreur"><?= $erreurs['pays'] ?></div>
                <?php endif; ?>
            </div>

            </div>

            <p class="legend">Le caractère <span class="required">*</span> indique un champ obligatoire.</p>

            <button type="submit" class="card-creer-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
            </svg>    
            Ajouter ce film au catalogue

            </button>

        </form>

    </div>

</main>
<?php
include __DIR__ . "/../src/includes/footer.php";
?>