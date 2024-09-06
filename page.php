<?php
// Reprise de la session existante
session_start();

// Définir le fuseau horaire sur celui de Paris (France)
date_default_timezone_set('Europe/Paris');

// Vérification si 'email' est défini dans la session
$user_email = isset($_SESSION['email']) ? $_SESSION['email'] : "Aucun email dans la session.";

// Affichage de la date et l'heure actuelles
$today = date("Y-m-d H:i:s");

// Récupérer la couleur sélectionnée (par défaut noire)
$selected_color = isset($_POST['color']) ? $_POST['color'] : 'black';

// Fonction pour écrire dans le fichier
function Ecriture_fichier($fichier, $message, $user_email, $today, $color) {
    $ouvfichier = fopen($fichier, 'a+');
    fwrite($ouvfichier, $user_email . " | " . $today . " | " . $message . " | " . $color . "\n");
    fclose($ouvfichier);
}

// Fonction pour afficher le contenu du fichier avec la couleur choisie
function Affichage_fichier($fichier) {
    if (file_exists($fichier) && filesize($fichier) > 0) {
        // Lire tout le contenu du fichier
        $lines = file($fichier, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        // Inverser l'ordre des lignes
        $lines = array_reverse($lines);

        // Afficher chaque ligne
        foreach ($lines as $line) {
            $parts = explode(" | ", $line);

            // S'assurer que la ligne contient bien les 4 éléments
            if (count($parts) === 4) {
                list($user, $date, $message, $color) = $parts;
                echo '<p style="color:' . htmlspecialchars(trim($color)) . ';">' . htmlspecialchars($user) . ' (' . $date . '): ' . htmlspecialchars($message) . '</p>';
            }
        }
    } else {
        echo "Vous n'avez aucun historique de conversation.";
    }
}

// Fonction pour supprimer l'historique
function Supprimer_historique($fichier) {
    if (file_exists($fichier)) {
        unlink($fichier);
    }
}

// Si un message a été envoyé (en utilisant POST) et que le champ message n'est pas vide
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['message'])) {
        Ecriture_fichier('TextChatbot.txt', $_POST['message'], $user_email, $today, $selected_color);
        // Redirection après la soumission du formulaire pour éviter la double soumission
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } elseif (isset($_POST['clear_history'])) {
        Supprimer_historique('TextChatbot.txt');
        // Redirection après la suppression de l'historique pour éviter un rechargement de la page avec l'historique supprimé
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="header">
            <h1>CHATBOT</h1>
        </div>
            <p><?php echo htmlspecialchars($user_email); ?></p>
            <a href="Deconnexion.php" class="button">Déconnexion</a>
        </div>
    </header>

    <main>
        <h1>Bienvenue dans ton nouveau Chatbot</h1>
        <p>Eh oui ! Ton Chatbot préf a fait peau neuve. Plus ergonomique, plus joli, plus sexy 😉 </p>
        <br><br>
        <div style="font-weight: bold;">
            <p>Choisissez la couleur de votre message :</p>
        </div>
        <form action="page.php" method="post">
            <input type="radio" id="black" name="color" value="black" checked>
            <label for="black" style="color: black;">Noir</label>

            <input type="radio" id="red" name="color" value="red">
            <label for="red" style="color: red;">Rouge</label>

            <input type="radio" id="blue" name="color" value="blue">
            <label for="blue" style="color: blue;">Bleu</label>

            <input type="radio" id="green" name="color" value="green">
            <label for="green" style="color: green;">Vert</label>

            <input type="radio" id="purple" name="color" value="purple">
            <label for="purple" style="color: purple;">Violet</label>
            
            <input type="radio" id="orange" name="color" value="orange">
            <label for="orange" style="color: orange;">Orange</label>

            <br><br>
            <input type="text" name="message" placeholder="Votre message..." required>
            <input type="submit" value="Envoyer">
        </form>
        <br><br>
        <form action="page.php" method="post">
            <input type="submit" name="clear_history" value="Supprimer l'historique">
        </form>
        <br><br>
        <div id="historique">
            <?php Affichage_fichier('TextChatbot.txt'); ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Mon Nouveau Chatbot.</p>
    </footer>
</body>
</html>


