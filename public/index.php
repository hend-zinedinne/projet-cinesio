<?php
$titre = "CinéSIO";
include __DIR__ . "/../src/includes/header.php";
include __DIR__ . "/../src/data/data.php";
?>
<main>
    <h2>Catalogue des Films</h2>
    <p>Il y a actuellement <span class="nombre-films"><?= count($films) ?></span> films dans le catalogue.</p>

    <div class="catalogue">
        <?php foreach ($films as $film): ?>
            <div class="card">
                <img src="<?= $film["image"] ?>" alt="<?= $film["titre"] ?>" class="card-image">
                <div class="card-badge"><?= $film["pays"] ?></div>
                <div class="card-info">
                    <h3><?= $film["titre"] ?></h3>
                    <p><?= $film["genre"] ?> - <?= $film["duree"] ?></p>
                    <p class="synopsis"><?= $film["synopsis"] ?></p>
                </div>
                <div class="card-button">Détails</div>
            </div>
        <?php endforeach; ?>
    </div>
</main>
<?php
include __DIR__ . "/../src/includes/footer.php";
?>