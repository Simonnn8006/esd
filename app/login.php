<?php
session_start();

// Si l'utilisateur est déjà connecté, redirection vers index.php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: index.php');
    exit();
}

include 'config.php'; // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['username'];
    $motdepasse = $_POST['password'];

    // Utilisation de requêtes préparées pour éviter l'injection SQL
    $stmt = $conn->prepare("SELECT id, password, groupe FROM users WHERE login = ?");

    if ($stmt) {
        // Lier les paramètres
        $stmt->bind_param('s', $login); // 's' signifie que le paramètre est une chaîne (string)

        // Exécuter la requête
        $stmt->execute();

        // Obtenir le résultat
        $result = $stmt->get_result();

        // Vérifier si l'utilisateur existe
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $id = $row['id'];
            $hash = $row['password'];
            $groupe = $row['groupe'];

            // Vérification du mot de passe (hashé dans la base de données)
            if (password_verify($motdepasse, $hash)) {
                // Authentification réussie
                $_SESSION['loggedin'] = true;
                $_SESSION['login'] = $login;
                $_SESSION['groupe'] = $groupe;
                $_SESSION['id'] = $id;

                header("Location: index.php");
                exit();
            } else {
                // Mot de passe incorrect
                $error = "Identifiant ou mot de passe incorrect.";
            }
        } else {
            // Aucun utilisateur trouvé avec cet identifiant
            $error = "Identifiant ou mot de passe incorrect.";
        }

        // Fermer la requête préparée
        $stmt->close();
    } else {
        // Erreur lors de la préparation de la requête
        $error = "Erreur lors de la connexion à la base de données.";
    }

    // Fermer la connexion
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>connexion</title>
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
    <h2>Connexion</h2>
    <?php if (isset($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>
    <form action="login.php" method="post" class="form-container">
        <label for="username">Identifiant</label>
        <input type="text" name="username" id="username" required>
        
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>
        
        <button type="submit">Se connecter</button>
    </form>
    <p class="mt-3">
        Pas encore de compte ? <a href="create_user.php">Créer un utilisateur</a>
    </p>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
