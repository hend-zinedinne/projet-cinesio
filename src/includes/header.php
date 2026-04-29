<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$connecte = isset($_SESSION["utilisateur"]);

?>


<!DOCTYPE html>
<html lang="fr" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <title><?= $titre ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <header>
        <nav class="barre-menu">
            <a href="index.php" class="cinesio"><span class="violet"><svg xmlns="http://www.w3.org/2000/svg" width="28"
                        height="28" fill="currentColor" class="bi bi-film" viewBox="0 0 16 16">
                        <path
                            d="M0 1a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm4 0v6h8V1zm8 8H4v6h8zM1 1v2h2V1zm2 3H1v2h2zM1 7v2h2V7zm2 3H1v2h2zm-2 3v2h2v-2zM15 1h-2v2h2zm-2 3v2h2V4zm2 3h-2v2h2zm-2 3v2h2v-2zm2 3h-2v2h2z" />
                    </svg> Ciné</span><span class="noir">SIO</span></a>
            <ul class="boutons-menu">
                <li><a href="index.php"><span class="violet">Accueil</a></li>
                <li><a href="index.php"><span class="gris">Catalogue</span></a></li>
                <?php if ($connecte === false): ?>
                    <li><a href="inscription.php"><span class="gris">Inscription</span></a></li>
                    <li><a href="connexion.php"><span class="gris">Connexion</span></a></li>
                <?php else: ?>
                    <li><a href="creer-film.php"><span class="gris">Ajouter un film</span></a></li>
                    <li><a href="#" class="bouton-compte noir"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                <path
                                    d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                            </svg> <?= htmlspecialchars($_SESSION["utilisateur"]["pseudo"]) ?></a></li>
                    <li><a href="deconnexion.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="red"
                                class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                                <path fill-rule="evenodd"
                                    d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                            </svg></a></li>
                <?php endif; ?>
                <li><a href="#"><span class="gris">Contact</span></a></li>
            </ul>
        </nav>
    </header>