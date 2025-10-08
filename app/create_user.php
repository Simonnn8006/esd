<?php
session_start();
include 'config.php'; // Inclure la configuration de la base de données

// Traitement du formulaire d'ajout d'un utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hacher le mot de passe

    // Vérifier si le login existe déjà
    $stmt = $conn->prepare("SELECT id FROM users WHERE login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Si le login existe déjà, afficher un message d'erreur
        $error = "Le pseudo est déjà pris, veuillez en choisir un autre.";
    } else {
        // Si le login n'existe pas, insérer l'utilisateur
        $stmt->close();

        // Préparer la requête d'insertion
        $stmt = $conn->prepare("INSERT INTO users (login, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $login, $email, $password);

        if ($stmt->execute()) {
            // Récupérer l'ID de l'utilisateur nouvellement créé
            $user_id = $conn->insert_id;

            // Créer la session d'authentification
            $_SESSION['loggedin'] = true;
            $_SESSION['login'] = $login;
            $_SESSION['id'] = $user_id;

            // Rediriger vers la page d'accueil après l'authentification
            header('Location: index.php');
            exit();
        } else {
            $error = "Erreur lors de la création de l'utilisateur.";
        }
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Créer un utilisateur</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <script src="/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary" id="nava">
</nav>

<div class="container text-center mt-5">
    <h2>Créer un utilisateur</h2>
    <?php if (isset($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form action="create_user.php" method="post" class="form-container">
        <label for="login">Login</label>
        <input type="text" name="login" id="login" required>
        
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
        
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Créer l'utilisateur</button>
    </form>
    <p class="mt-3">
        Déjà un compte ? <a href="login.php">Se connecter</a>
    </p>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
