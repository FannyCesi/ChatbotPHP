<?php
session_start();

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['email'])) {
    header("Location: page.php");
    exit();
}

// Vérifier si le formulaire de connexion est soumis
if (isset($_POST['email']) && isset($_POST['password'])) {
    if (empty($_POST['email'])) {
        $error_message = "Le champ email est vide.";
    } elseif (empty($_POST['password'])) {
        $error_message = "Le champ Mot de passe est vide.";
    } else {
        $_SESSION['email'] = $_POST['email'];
        header("Location: page.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Connexion à votre compte</h1>
        <form action="Connexion.php" method="post">
            <label for="email">Email<span class="required-field">*</span></label>
            <input type="email" id="email" name="email" placeholder="Email" required>
            <label for="password">Mot de passe<span class="required-field">*</span></label>
            <input type="password" id="password" name="password" placeholder="Mot de passe" required>
            <br></br>
            <div>
                <input type="submit" value="Connexion" class="button">
            </div>
        </form>
    </div>
</body>
</html>
