<?php
session_start();
include 'config.php'; // Connexion à la base de données

// Désactiver l'affichage des erreurs PHP pour la production
error_reporting(0);
ini_set('display_errors', 0);

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit();
}

header('Content-Type: text/html; charset=utf-8');
include 'header.php';

// Activer le rapport d'erreurs MySQLi
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$message = '';  // Variable pour stocker les messages d'erreur
$results_found = false; // Variable pour déterminer si une recherche a été effectuée

if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    // Récupérer la recherche de l'utilisateur si elle est présente et non vide
    $search = trim($_GET['search']);

    try {
        // Requête SQL préparée pour chercher les utilisateurs
        $stmt = $conn->prepare("SELECT login, email, photo_path FROM users WHERE login LIKE ? OR email LIKE ?");
        $search_param = "%" . $search . "%";
        $stmt->bind_param("ss", $search_param, $search_param);

        // Exécuter la requête
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $results_found = true; // Marquer que des résultats ont été trouvés
        } else {
            // Si aucun utilisateur n'est trouvé
            $message = "Aucun utilisateur trouvé.";
        }
    } catch (mysqli_sql_exception $e) {
        // En cas d'erreur SQL, afficher un message d'erreur dans le tableau
        $message = "Erreur lors de la recherche.";
    }
} else {
    // Pas de recherche effectuée
    $message = "Veuillez saisir un terme de recherche.";
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <title>Liste des utilisateurs</title>
</head>
<body>

<h2>Liste des utilisateurs</h2>

<!-- Barre de recherche -->
<form method="GET" action="contacts.php">
    <label for="search">Rechercher un utilisateur :</label>
    <input type="text" name="search" id="search" value="<?= htmlspecialchars($search ?? '') ?>">
    <button type="submit">Rechercher</button>
</form>

<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>Login</th>
            <th>Email</th>
            <th>Photo</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Si des résultats sont trouvés, les afficher
        if ($results_found) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['login']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td><img src='" . htmlspecialchars($row['photo_path']) . "' alt='Photo de " . htmlspecialchars($row['login']) . "' width='100' height='100'></td>";
                echo "</tr>";
            }
        } else {
            // Afficher un message si aucun résultat n'a été trouvé ou pas de recherche effectuée
            echo "<tr><td colspan='3'>" . htmlspecialchars($message) . "</td></tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>

<?php
include 'footer.php';
// Fermer la connexion à la base de données
$conn->close();
?>
