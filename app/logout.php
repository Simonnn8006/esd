<?php
session_start(); // Démarrer la session

// Détruire toutes les variables de session
$_SESSION = array();

// Si vous souhaitez détruire complètement la session, aussi bien que les cookies de session, utilisez session_destroy()
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Détruire la session
session_destroy();

// Rediriger l'utilisateur vers la page de connexion ou la page d'accueil
header("Location: login.php");
exit();