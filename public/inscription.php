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
$pseudo = '';
$mot_de_passe = '';
$confirmation = '';

$erreurs = []; // Tableau associatif pour les erreurs
$succes = false;

// Détecter la soumission du formulaire.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // le formulaire est soumis.
    // Récupérer chaque champ

    $email = trim($_POST["email"] ?? "");
    $pseudo = trim($_POST["pseudo"] ?? "");
    $mot_de_passe = trim($_POST["mot_de_passe"] ?? "");
    $confirmation = trim($_POST["confirmation"] ?? "");

    if ($email == '') {
        $erreurs["email"] = "Aucun e-mail n'a été saisi.";
    } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $erreurs["email"] = "L'e-mail saisi est invalide.";
    } elseif (findUtilisateurByEmail($email)["email"] === $email) {
        $erreurs["email"] = "Cet e-mail est déjà utilisé par un autre utilisateur.";
    }

    if ($pseudo == '') {
        $erreurs["pseudo"] = "Aucun pseudonyme n'a été saisi.";
    } elseif (mb_strlen($pseudo) < 3) {
        $erreurs["pseudo"] = "Le pseudonyme a moins de 3 caractères.";
    } elseif (findUtilisateurByPseudo($pseudo)["pseudo"] === $pseudo) {
        $erreurs["pseudo"] = "Ce pseudonyme est déjà utilisé par un autre utilisateur.";
    }

    if ($mot_de_passe == '') {
        $erreurs["mot_de_passe"] = "Aucun mot de passe n'a été saisi.";
    } elseif (mb_strlen($mot_de_passe) < 8) {
        $erreurs["mot_de_passe"] = "Le mot de passe saisi a moins de 8 caractères.";
    }

    if ($confirmation == '') {
        $erreurs["confirmation"] = "Veuillez confirmer votre mot de passe.";
    } elseif ($mot_de_passe !== $confirmation) {
        $erreurs["confirmation"] = "Les mots de passe ne sont pas identiques.";
    }

    // Traitement des données saisies, uniquement dans le cas où aucune erreur n'a été produite.

    if (empty($erreurs)) {
        $succes = true;

        $utilisateur = [
            "email" => htmlspecialchars($email),
            "pseudo" => htmlspecialchars($pseudo),
            "mot_de_passe" => htmlspecialchars($mot_de_passe),
        ];

        addUtilisateur($utilisateur);

        // Réinitialiser les variables avec ''
        $email = '';
        $pseudo = '';
        $mot_de_passe = '';
        $confirmation = '';
    }
}

?>

<main>

    <h2>Créer un compte</h2>
    <p class="gris">Rejoignez la communauté CinéSIO pour accéder à toutes les fonctionnalités.</p>

    <?php if ($succes): ?>
        <div class="message-succes">Votre compte a été ajouté avec succès.</div>
    <?php endif; ?>

    <div class="card-auth">
        <form action="" method="POST">
            <!-- EMAIL -->
            <div class="card-creer-form">
                <label for="email"><strong>Adresse E-mail</strong><span class="required">*</span> :</label>
                <input type="email" id="email" name="email" placeholder="Ex: jean.dupont@email.com"
                    value="<?= $email ?>" required>
                <!-- Afficher l'erreur si présente -->
                <?php if (isset($erreurs["email"])): ?>
                    <div class="message-erreur"><?= $erreurs['email'] ?></div>
                <?php endif; ?>
            </div>

            <!-- PSEUDO -->
            <div class="card-creer-form">
                <label for="pseudo"><strong>Pseudonyme</strong><span class="required">*</span> :</label>
                <input type="text" id="pseudo" name="pseudo" value="<?= $pseudo ?>" placeholder="Ex: JeanD88"
                    minlength="3" required>
                <!-- Afficher l'erreur si présente -->
                <?php if (isset($erreurs["pseudo"])): ?>
                    <div class="message-erreur"><?= $erreurs['pseudo'] ?></div>
                <?php endif; ?>
                <div class="hint">3 caractères minimum.</div>
            </div>



            <div class="card-creer-2">
                <!-- MOT DE PASSE -->
                <div class="card-creer-form">
                    <label for="mot_de_passe"><strong>Mot de passe</strong><span class="required">*</span> :</label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe" value="<?= $mot_de_passe ?>"
                        minlength="8">
                    <!-- Afficher l'erreur si présente -->
                    <?php if (isset($erreurs["mot_de_passe"])): ?>
                        <div class="message-erreur">
                            <?= $erreurs['mot_de_passe'] ?>
                        </div>
                    <?php endif; ?>
                    <div class="hint">8 caractères minimum.</div>
                </div>


                <!-- CONFIRMATION DU MOT DE PASSE -->
                <div class="card-creer-form">
                    <label for="confirmation"><strong>Confirmation</strong><span class="required">*</span> :</label>
                    <input type="password" id="confirmation" name="confirmation" value="<?= $confirmation ?>" required>
                    <!-- Afficher l'erreur si présente -->
                    <?php if (isset($erreurs["confirmation"])): ?>
                        <div class="message-erreur"><?= $erreurs['confirmation'] ?></div>
                    <?php endif; ?>
                    <div class="hint">Doit être identique au mot de passe</div>
                </div>
            </div>

            <p class="legend">Le caractère <span class="required">*</span> indique un champ obligatoire.</p>

            <button type="submit" class="card-creer-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                    class="bi bi-person-add" viewBox="0 0 16 16">
                    <path
                        d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4" />
                    <path
                        d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z" />
                </svg>
                M'inscrire maintenant

            </button>

            <div class="lien-inscription-connexion">
                <p>Déjà un compte ? <a href="connexion.php" class="noir"><strong>Connectez-vous</strong></a></p>
            </div>

        </form>


    </div>

</main>

<?php
include __DIR__ . "/../src/includes/footer.php";
?>