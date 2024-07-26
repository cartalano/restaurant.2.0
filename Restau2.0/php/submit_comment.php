<?php
ob_start(); // Démarre la mise en tampon de sortie

$servername = "mysql"; // Nom du service Docker pour MySQL
$username = "root";
$password = "pass"; // Mot de passe MySQL
$dbname = "comments";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Vérifie que les données du formulaire ont été envoyées
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['name'], $_POST['email'], $_POST['comment'])) {
        // Récupére les données du formulaire
        $name = $_POST['name'];
        $email = $_POST['email'];
        $comment = $_POST['comment'];

        // Débogage : afficher les valeurs des champs du formulaire
        echo "Nom : " . htmlspecialchars($name) . "<br>";
        echo "Email : " . htmlspecialchars($email) . "<br>";
        echo "Commentaire : " . htmlspecialchars($comment) . "<br>";

        // Prépare et exécute la requête SQL
        $sql = "INSERT INTO comments (name, email, comment) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $comment);

        if ($stmt->execute()) {
            echo "Commentaire enregistré avec succès";
        } else {
            echo "Erreur : " . $sql . "<br>" . $conn->error;
        }

        // Ferme la connexion
        $stmt->close();
    } else {
        echo "Tous les champs sont requis.";
    }
} else {
    echo "Méthode de requête non valide.";
}

$conn->close();

// Redirection vers la page des commentaires
header("Location: comments.php");
ob_end_flush(); // Envoyer la sortie et désactiver la mise en tampon
exit();
?>
