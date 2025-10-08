<?php

session_start();

// Si l'utilisateur n'est pas connecté, redirection vers login.php
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}

include 'config.php';
include 'header.php'; 
?>


<div class="container text-center mt-5">
<h1 class="welcome-message">Bienvenue sur l'intranet ESDOWN</h1>
    <p class="description">Vous pouvez consulter les procédures et documents internes ou gérer votre compte.</p>

</div>

<?php
include 'footer.php';
?>
