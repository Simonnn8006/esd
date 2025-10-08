<?php
// Start session
session_start();

// Connect to the database
include 'config.php'; 

$target_dir = "uploads/";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == 0) {
        $file_name = $_FILES["fileToUpload"]["name"];

        // Vérifier si le fichier se termine par .png, .jpg ou .jpeg
        if (preg_match('/\.(png|jpg|jpeg)$/i', $file_name)) {  // Protection stricte sur l'extension
            $new_file_name = uniqid() . "_" . basename($file_name);
            $target_file = $target_dir . $new_file_name;

            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                // Mettre à jour le chemin de l'image dans la base de données
                $user_id = $_SESSION['id'];
                $stmt = $conn->prepare("UPDATE users SET photo_path = ? WHERE id = ?");
                $stmt->bind_param("si", $target_file, $user_id);

                if ($stmt->execute()) {
                    // Rediriger avec succès
                    header("Location: administration.php?upload_success=1");
                    exit();
                } else {
                    // Problème de base de données
                    header("Location: administration.php?upload_success=0");
                    exit();
                }
            } else {
                // Erreur lors du déplacement du fichier
                header("Location: administration.php?upload_success=0");
                exit();
            }
        } else {
            // Extension de fichier invalide
            header("Location: administration.php?upload_success=0&error=invalid_extension");
            exit();
        }
    } else {
        // Erreur lors de l'upload
        header("Location: administration.php?upload_success=0&error=upload_error");
        exit();
    }
}
?>
