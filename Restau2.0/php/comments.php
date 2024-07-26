<?php
$servername = "mysql"; // nom du service Docker pour MySQL
$username = "root";
$password = "pass"; // mot de passe MySQL
$dbname = "comments";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Vérifier si l'ID est passé en paramètre pour la suppression
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);

    // Supprimer le commentaire
    $sql = "DELETE FROM comments WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Commentaire supprimé avec succès";
    } else {
        echo "Erreur : " . $conn->error;
    }

    $stmt->close();
}

// Récupérer les commentaires
$sql = "SELECT id, name, email, comment, created_at FROM comments";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commentaires</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
        tr:hover { background-color: #f5f5f5; }
    </style>
</head>
<body>
    <h1>Commentaires des clients</h1>
    <table>
        <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Commentaire</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row["name"]) . "</td>
                        <td>" . htmlspecialchars($row["email"]) . "</td>
                        <td>" . htmlspecialchars($row["comment"]) . "</td>
                        <td>" . htmlspecialchars($row["created_at"]) . "</td>
                        <td><a href='comments.php?delete_id=" . $row["id"] . "' onclick='return confirm(\"Voulez-vous vraiment supprimer ce commentaire ?\");'>Supprimer</a></td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Aucun commentaire trouvé</td></tr>";
        }
        ?>
    </table>
    <?php $conn->close(); ?>
</body>
</html>
