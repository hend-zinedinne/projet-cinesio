<?php
$titre = "CinéSIO";
include __DIR__ . "/../src/includes/header.php";
require_once __DIR__ . "/../src/lib/functions.php";
require_once __DIR__ . "/../src/repositories/filmRepository.php";
$films = getDataFromFilms();
?>
<main>
    <div class="catalogue-info">
        <h2>Catalogue des Films</h2>
        <p>Il y a actuellement <span class="violet"><?= count($films) ?></span> films dans le catalogue.</p>
    </div>

    <div class="catalogue">
        <?php foreach ($films as $film): ?>
            <div class="card">
                <img src="<?= $film["image"] ?>" alt="<?= $film["titre"] ?>" class="card-image">
                <div class="card-badge"><?= $film["pays_initiale"] ?></div>
                <div class="card-info">
                    <h3><?= $film["titre"] ?></h3>
                    <p><?= $film["nom_genre"] ?> • <?= convertirMinutes($film['duree']) ?></p>
                    <p><?= $film["synopsis"] ?></p>
                </div>
                <a href="details-film.php?id=<?= $film['id'] ?>" class="card-button">Détails</a>
            </div>
        <?php endforeach; ?>
    </div>
</main>
<?php
include __DIR__ . "/../src/includes/footer.php";
?>