<?php
session_start();

// Si l'utilisateur n'est pas connecté, redirection vers login.php
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: /login.php');
    exit();
}

include 'config.php';
include 'header.php'; 

// Fonction pour charger et afficher le contenu du fichier XML
function loadXMLFromURL($url) {
    // Activer les entités externes pour permettre l'attaque XXE
    libxml_disable_entity_loader(false);

    // Charger le fichier XML depuis l'URL
    $xmlContent = file_get_contents($url);
    if ($xmlContent === false) {
        return "Erreur : Impossible de charger le fichier XML depuis l'URL spécifiée.";
    }

    // Parse du XML avec SimpleXML (Vulnérable à XXE)
    $xml = simplexml_load_string($xmlContent, 'SimpleXMLElement', LIBXML_NOENT);
    if ($xml === false) {
        return "Erreur lors de l'analyse du fichier XML.";
    }

    // Retourner le XML sous forme de chaîne
    return $xml->asXML();
}

// Conversion du XML en JSON
function convertXMLToJSON($xmlContent) {
    $xml = simplexml_load_string($xmlContent, 'SimpleXMLElement', LIBXML_NOENT);
    if ($xml === false) {
        return "Erreur lors de l'analyse du fichier XML pour la conversion en JSON.";
    }

    // Conversion en JSON
    $json = json_encode($xml);
    return $json;
}

$xmlContent = '';
$jsonContent = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['url'])) {
    $url = $_POST['url'];
    $xmlContent = loadXMLFromURL($url);

    // Si le bouton "Confirmer" est cliqué, convertir en JSON
    if (isset($_POST['confirm'])) {
        $jsonContent = convertXMLToJSON($xmlContent);
    }
}

?>

<h1>Charger et convertir une formule médicale (fichier XML obligatoire)</h1>

<!-- Formulaire pour l'URL -->
<form method="POST" action="">
    <label for="url">Entrez l'URL du fichier XML :</label><br>
    <input type="text" id="url" name="url" required style="width: 100%; padding: 8px;"><br><br>

    <input type="submit" value="Charger le fichier XML" style="padding: 10px 20px; background-color: #28a745; color: white; border: none; cursor: pointer;">
</form>


<p>Template de formule : </p>
<a href="template.xml" download>Télécharger la formule médicale</a>

<?php if ($xmlContent): ?>
    <h2>Contenu du fichier XML</h2>
    <pre style="background-color: #f8f9fa; padding: 15px; border: 1px solid #ddd;"><?php echo htmlentities($xmlContent); ?></pre>

    <!-- Bouton pour confirmer et convertir en JSON -->
    <form method="POST" action="" style="margin-top: 20px;">
        <input type="hidden" name="url" value="<?php echo htmlspecialchars($url); ?>">
        <input type="submit" name="confirm" value="Confirmer et convertir en JSON" style="background-color: #007bff; color: white; padding: 15px 30px; font-size: 18px; border: none; cursor: pointer; margin-bottom: 100px;">
    </form>
<?php endif; ?>

<?php if ($jsonContent): ?>
    <h2>Contenu en JSON</h2>
    <pre style="background-color: #f8f9fa; padding: 15px; border: 1px solid #ddd;"><?php echo htmlspecialchars($jsonContent); ?></pre>
<?php endif; ?>

<?php
include 'footer.php';
?>

