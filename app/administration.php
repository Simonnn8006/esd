<?php
session_start();
include 'config.php'; // Connexion à la base de données

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit();
}

// Récupérer l'ID utilisateur connecté
$user_id = $_SESSION['id'];

include 'header.php';

// Récupérer le nom ou login de l'utilisateur depuis la base de données
$stmt = $conn->prepare("SELECT login FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username);
$stmt->fetch();
$stmt->close();

// Traitement du changement de mot de passe
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

    // Mettre à jour le mot de passe dans la base de données pour l'utilisateur correspondant à l'ID dans l'URL
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $hashed_password, $user_id);

    if ($stmt->execute()) {
        echo "Mot de passe mis à jour avec succès!";
    } else {
        echo "Erreur lors de la mise à jour du mot de passe.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <script src="/js/functions.js"></script> <!-- Lien vers le fichier JS -->
    <title>Administration - Changer le mot de passe</title>
</head>
<body>

<h2>Changer le mot de passe de <?= htmlspecialchars($username) ?></h2>

<form action="administration.php" method="post" class="form-container">
    <label for="new_password">Nouveau mot de passe</label>
    <input type="password" name="new_password" id="new_password" required>

    <button type="submit">Changer le mot de passe</button>
</form>

<!-- Formulaire d'upload de photo -->
<form action="upload.php" method="post" enctype="multipart/form-data" id="uploadForm" class="form-container">
    <label for="fileToUpload">Upload your photo:</label>
    <input type="file" name="fileToUpload" id="fileToUpload" required>
    <input type="submit" value="Upload Photo" name="submit">
</form>

<!-- Pop-up pour les messages de succès ou d'erreur -->
<div id="successPopup"></div>

<?php include 'footer.php'; ?>
