<?php
$titre = "CinéSIO";
include __DIR__ . "/../src/includes/header.php";
require_once __DIR__ . "/../src/lib/functions.php";
require_once __DIR__ . "/../src/repositories/filmRepository.php";
$films = getDataFromFilms();

$genreOptions =
    [
        "" => "-- Sélectionnez un genre --",
        "1" => "Science-Fiction",
        "2" => "Drame",
        "3" => "Thriller",
        "4" => "Comédie",
        "5" => "Action",
        "6" => "Crime",
        "7" => "Animation",
    ];

$paysOptions =
    [
        "" => "-- Sélectionnez un pays --",
        "1" => "USA",
        "2" => "Corée Du Sud",
        "3" => "France",
        "4" => "Japon",
    ];

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
        $erreurs["genre"] = "Aucune date n'a été saisie.";
    } elseif (DateTime::createFromFormat('d/m/Y', $myString) == false) {
        $erreurs["genre"] = "Le genre séléctionné est invalide.";
    }

    if ($duree == '') {
        $erreurs["genre"] = "Aucune durée n'a été saisie.";
    } elseif (!is_int($duree)) {
        $erreurs["genre"] = "La durée saisie n'est pas un nombre.";
    }

    if ($synopsis == '') {
        $erreurs["synopsis"] = "Aucun synopsis n'a été saisi.";
    } elseif (mb_strlen($titre) < 5) {
        $erreurs["synopsis"] = "Le synopsis a moins de 5 caractères.";
    }

    if ($image == '') {
        $erreurs["image"] = "Aucune image n'a été ajoutée.";
    } elseif (!filter_var($image, FILTER_VALIDATE_URL)) {
        $erreurs["image"] = "Le genre séléctionné est invalide.";
    }

    if ($pays == '') {
        $erreurs["pays"] = "Aucun pays n'a été séléctionné.";
    } elseif (!array_key_exists($pays, $paysOptions)) {
        $erreurs["pays"] = "Le pays séléctionné est invalide.";
    }

    // Traitement des données saisies, uniquement dans le cas où aucune erreur n'a été produite.

    if (empty($erreurs)) {
        $succes = true;

        

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
                <input type="number" id="duree" name="duree" value="<?= $duree ?>" required>
                <!-- Afficher l'erreur si présente -->
                <?php if (isset($erreurs["duree"])): ?>
                    <div class="message-erreur"><?= $erreurs['duree'] ?></div>
                <?php endif; ?>
                <div class="hint">En minutes uniquement</div>
            </div>

            <!-- SYNOPSIS -->
            <div class="card-creer-form">
                <label for="synopsis">Synopsis :<span class="required">*</span> :</label>
                <input type="text" id="synopsis" name="synopsis" placeholder="Il était une fois..."
                    value="<?= $synopsis ?>" required minlength="5">
                <!-- Afficher l'erreur si présente -->
                <?php if (isset($erreurs["synopsis"])): ?>
                    <div class="message-erreur"><?= $erreurs['synopsis'] ?></div>
                <?php endif; ?>
                <div class="hint">5 caractères minimum</div>
            </div>

            <!-- IMAGE -->
            <div class="card-creer-form">
                <label for="image">Image :<span class="required">*</span> :</label>
                <input type="link" id="image" name="image" placeholder="https://lien.fr" value="<?= $image ?>" required
                    minlength="5">
                <!-- Afficher l'erreur si présente -->
                <?php if (isset($erreurs["image"])): ?>
                    <div class="message-erreur"><?= $erreurs['image'] ?></div>
                <?php endif; ?>
                <div class="hint">Lien valide requis</div>
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

            <p class="legend">Le caractère <span class="required">*</span> indique un champ obligatoire.</p>

            <button type="submit" class="card-creer-btn">
                Ajouter le film
            </button>

        </form>

    </div>

</main>
<?php
include __DIR__ . "/../src/includes/footer.php";
?>