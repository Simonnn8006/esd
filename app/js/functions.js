// Affichage de la fenêtre de succès ou d'erreur
function showSuccess(message) {
    var popup = document.getElementById('successPopup');
    popup.innerText = message;
    popup.style.display = 'block';  // S'assurer que l'élément devient visible
    popup.style.backgroundColor = '#4CAF50'; // Couleur de succès (vert)

    setTimeout(function() {
        popup.classList.add('fade-out');
    }, 3000);

    setTimeout(function() {
        popup.style.display = 'none';
        popup.classList.remove('fade-out');
    }, 6000);
}

function showError(message) {
    var popup = document.getElementById('successPopup');
    popup.innerText = message;
    popup.style.display = 'block';  // S'assurer que l'élément devient visible
    popup.style.backgroundColor = '#f44336'; // Couleur d'erreur (rouge)

    setTimeout(function() {
        popup.classList.add('fade-out');
    }, 3000);

    setTimeout(function() {
        popup.style.display = 'none';
        popup.classList.remove('fade-out');
    }, 6000);
}


// Vérifier si l'upload a réussi ou échoué
document.addEventListener('DOMContentLoaded', function() {
    const params = new URLSearchParams(window.location.search);
    if (params.has('upload_success')) {
        if (params.get('upload_success') === '1') {
            showSuccess("Le fichier a été uploadé avec succès !");
        } else {
            showError("L'upload a échoué. Vérifiez l'extension ou essayez à nouveau.");
        }
    }

    // Attacher la validation au formulaire
    var form = document.getElementById('uploadForm');
    if (form) {
        form.addEventListener('submit', validateFile);
    }
});

// Validation des fichiers
function validateFile(event) {
    var fileInput = document.getElementById('fileToUpload');
    var file = fileInput.files[0]; // Récupérer le premier fichier
    var filePath = fileInput.value; // Chemin du fichier pour vérifier l'extension

    // Empêcher la soumission initiale
    event.preventDefault();

    if (fileInput.files.length === 0) {
        showError("Aucun fichier sélectionné.");
        return false;
    }

    // Vérifier l'extension du fichier
    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
    if (!allowedExtensions.exec(filePath)) {
        showError('Extension interdite. Seules les extensions .jpg, .jpeg, et .png sont autorisées.');
        fileInput.value = ''; // Réinitialiser le champ de fichier
        return false;
    }

    // Vérification des en-têtes pour vérifier le type MIME via magic number
    var reader = new FileReader();

    reader.onloadend = function(e) {
        var arr = (new Uint8Array(e.target.result)).subarray(0, 4); // Lire les 4 premiers octets
        var header = "";
        for (var i = 0; i < arr.length; i++) {
            header += arr[i].toString(16); // Convertir en hexadécimal
        }

        // Vérification des magic numbers pour PNG et JPEG
        var mimeType;
        switch (header) {
            case "89504e47": // PNG signature
                mimeType = "image/png";
                break;
            case "ffd8ffe0":
            case "ffd8ffe1":
            case "ffd8ffe2":
            case "ffd8ffe3":
            case "ffd8ffe8": // JPEG signatures
                mimeType = "image/jpeg";
                break;
            default:
                mimeType = "unknown"; // Type de fichier inconnu
                break;
        }

        // Si le fichier n'est pas une image valide (PNG ou JPEG)
        if (mimeType === "unknown") {
            showError("Type de fichier interdit. Seuls les fichiers JPEG et PNG sont autorisés.");
            fileInput.value = ''; // Réinitialiser le champ de fichier
        } else {
            // Si tout est correct, permettre la soumission du formulaire après la validation
            document.getElementById('uploadForm').removeEventListener('submit', validateFile); // Désactiver la validation pour permettre la soumission
            document.getElementById('uploadForm').submit(); // Soumettre le formulaire manuellement
        }
    };

    // Lire les premiers octets du fichier pour vérifier son type
    reader.readAsArrayBuffer(file.slice(0, 4));
}
