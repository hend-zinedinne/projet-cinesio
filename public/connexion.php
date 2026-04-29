<?php

session_start();

if (isset($_SESSION["utilisateur"])) {
    header("Location: index.php");
    exit;
}

$titre = "CinéSIO";
include __DIR__ . "/../src/includes/header.php";
require_once __DIR__ . "/../src/lib/functions.php";
require_once __DIR__ . "/../src/repositories/utilisateurRepository.php";

// Définir une variable par champs du formulaire
$email = '';
$mot_de_passe = '';
$erreurMDPOuEmail = '';

$erreurs = []; // Tableau associatif pour les erreurs
$succes = false;

// Détecter la soumission du formulaire.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // le formulaire est soumis.
    // Récupérer chaque champ

    $email = trim($_POST["email"] ?? "");
    $mot_de_passe = trim($_POST["mot_de_passe"] ?? "");

    if ($email == '') {
        $erreurs["email"] = "Aucun e-mail n'a été saisi.";
    } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $erreurs["email"] = "L'e-mail saisi est invalide.";
    } elseif (findUtilisateurByEmail($email) == null) {
        $erreurMDPOuEmail = "E-mail ou mot de passe erroné.";
    }

    if ($mot_de_passe == '') {
        $erreurs["mot_de_passe"] = "Aucun mot de passe n'a été saisi.";
    } elseif (mb_strlen($mot_de_passe) < 8) {
        $erreurs["mot_de_passe"] = "Le mot de passe saisi a moins de 8 caractères.";
    } elseif (password_verify($mot_de_passe, findUtilisateurByEmail($email)["mot_de_passe"]) === false) {
        $erreurMDPOuEmail = "E-mail ou mot de passe erroné.";
    }


    // Traitement des données saisies, uniquement dans le cas où aucune erreur n'a été produite.

    if (empty($erreurs) && $erreurMDPOuEmail === '') {
        $succes = true;

        $utilisateur = findUtilisateurByEmail($email);

        $_SESSION['utilisateur'] = [
            'id' => $utilisateur['id'],
            'pseudo' => $utilisateur['pseudo']
        ];

        header("Location: index.php");
        exit;

        // Réinitialiser les variables avec ''
        $email = '';
        $pseudo = '';
        $mot_de_passe = '';
        $confirmation = '';
    }
}

?>

<main>

    <h2>Connexion</h2>
    <p class="gris">Accédez à votre espace membre CinéSIO.</p>

    <div class="card-auth">
        <form action="" method="POST">

            <!-- EMAIL -->
            <div class="card-creer-form">
                <label for="email"><strong>Adresse E-mail</strong><span class="required">*</span></label>
                <input type="email" id="email" name="email" placeholder="Ex: jean.dupont@email.com"
                    value="<?= $email ?>" required>
                <!-- Afficher l'erreur si présente -->
                <?php if (isset($erreurs["email"]) || $erreurMDPOuEmail !== ''): ?>
                    <div class="message-erreur">
                        <?= $erreurs['email'] ?>
                        <?= $erreurMDPOuEmail ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- MOT DE PASSE -->
            <div class="card-creer-form">
                <label for="mot_de_passe"><strong>Mot de passe</strong><span class="required">*</span></label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" value="<?= $mot_de_passe ?>" minlength="8">
                <!-- Afficher l'erreur si présente -->
                <?php if (isset($erreurs["email"]) || $erreurMDPOuEmail !== ''): ?>
                    <div class="message-erreur">
                        <?= $erreurs['mot_de_passe'] ?>
                        <?= $erreurMDPOuEmail ?>
                    </div>
                <?php endif; ?>
                <div class="hint">8 caractères minimum.</div>
            </div>

            <p class="legend">Le caractère <span class="required">*</span> indique un champ obligatoire.</p>

            <button type="submit" class="card-creer-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z" />
                    <path fill-rule="evenodd"
                        d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                </svg>
                Se connecter

            </button>

            <div class="lien-inscription-connexion">
                <p>Pas encore de compte ? <a href="inscription.php" class="noir"><strong>Créer un compte</strong></a>
                </p>
            </div>

        </form>


    </div>

</main>

<?php
include __DIR__ . "/../src/includes/footer.php";
?>