<?php

session_start();

//Supprimer le prénom de la session

if (isset($_SESSION)) {
    unset($_SESSION["utilisateur"]);
}

header("Location:index.php");
exit;
