<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déconnexion</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <p>Vous avez été déconnecté</p>
    <a href="Connexion.php" class="button">Connexion </a>
</body>
</html>
