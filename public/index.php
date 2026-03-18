<?php
$titre = "CinéSIO";
include __DIR__ . "/../src/includes/header.php";
include __DIR__ . "/../src/data/data.php";
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
                <div class="card-badge"><?= $film["pays"] ?></div>
                <div class="card-info">
                    <h3><?= $film["titre"] ?></h3>
                    <p><?= $film["genre"] ?> - <?= $film["duree"] ?></p>
                    <p class="synopsis"><?= $film["synopsis"] ?></p>
                </div>
                <a href="#" class="card-button">Détails</a>
            </div>
        <?php endforeach; ?>
    </div>
</main>
<?php
include __DIR__ . "/../src/includes/footer.php";
?>