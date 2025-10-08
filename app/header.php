<!DOCTYPE html>
<html lang="fr">
<head>
    <title>TP 6 - Intranet ESDown</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <script src="/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary" id="nava">
    <div class="container-fluid">
        <!-- Menu à gauche -->
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto"> <!-- me-auto pour aligner à gauche -->
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" href="index.php">Accueil</a> <!-- Lien en gras -->
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" href="administration.php">Administration</a> <!-- Lien en gras -->
                <li>
                <a class="nav-link font-weight-bold" href="contacts.php">Contacts</a>
                </li>
                <li>
                <a class="nav-link font-weight-bold" href="formules_dev.php">Formules</a>
                </li>
                <li>
                <a class="nav-link font-weight-bold" href="logout.php">Déconnexion</a>
                </li>

        </div>
        <!-- Logo à droite -->
        <a class="navbar-brand ms-auto" href="../"> <!-- ms-auto pour aligner à droite -->
            <img src="/assets/logo_esd.png" alt="Site Logo" id="logo">
        </a>  
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>
<div class="container mt-5">
    <div class="row justify-content-center">
