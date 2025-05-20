<?php
// Page de liste des personnes avec options de suppression et modification
require_once 'config.php';

// Traitement de la suppression
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM personnes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: liste.php"); // Redirection pour éviter les soumissions multiples
    exit();
}

// Récupération des données
$sql = "SELECT * FROM personnes ORDER BY date_creation DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des personnes</title>
    <style>
   @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap');

body {
    background: linear-gradient(135deg, #fdf4ff, #ede9fe, #ddd6fe);
    font-family: 'Montserrat', sans-serif;
    margin: 0;
    padding: 20px;
    min-height: 100vh;
}

.container {
    width: 90%;
    max-width: 950px;
    margin: 40px auto;
    background: #fff;
    padding: 35px;
    border-radius: 20px;
    box-shadow: 0 15px 30px rgba(219, 154, 255, 0.2);
    border: 1px solid rgba(219, 154, 255, 0.3);
}

h1 {
    text-align: center;
    color: #9d4edd;
    margin-bottom: 30px;
    font-size: 30px;
    font-weight: 600;
    position: relative;
}

h1:after {
    content: "";
    position: absolute;
    width: 70px;
    height: 3px;
    background: linear-gradient(to right, #c77dff, #9d4edd);
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
}

table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background-color: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(219, 154, 255, 0.1);
}

th {
    background: linear-gradient(to right, #c77dff, #9d4edd);
    color: white;
    padding: 16px;
    text-align: center;
    font-weight: 500;
    font-size: 16px;
    letter-spacing: 0.5px;
}

td {
    padding: 16px;
    text-align: center;
    border-bottom: 1px solid #f3dbff;
    font-size: 15px;
    color: #444;
}

tr:last-child td {
    border-bottom: none;
}

tr:hover {
    background-color: #fdf4ff;
}

.action-btn {
    display: inline-block;
    padding: 10px 20px;
    margin: 4px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 500;
    text-align: center;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    color: white;
    font-family: 'Montserrat', sans-serif;
}

.modify-btn {
    background: linear-gradient(to right, #c77dff, #9d4edd);
    color: white;
}

.modify-btn:hover {
    background: linear-gradient(to right, #9d4edd, #7b2cbf);
    transform: translateY(-2px);
    box-shadow: 0 3px 10px rgba(157, 78, 221, 0.3);
}

.delete-btn {
    background-color: #ff86c9;
    color: white;
}

.delete-btn:hover {
    background-color: #ff5cb0;
    transform: translateY(-2px);
    box-shadow: 0 3px 10px rgba(255, 92, 176, 0.3);
}

.add-btn {
    margin-top: 25px;
    background: linear-gradient(to right, #c77dff, #9d4edd);
    color: white;
    padding: 14px 25px;
    font-size: 16px;
    border-radius: 12px;
    text-align: center;
    display: block;
    width: fit-content;
    margin-left: auto;
    margin-right: auto;
    border: none;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    font-family: 'Montserrat', sans-serif;
}

.add-btn:hover {
    background: linear-gradient(to right, #9d4edd, #7b2cbf);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(157, 78, 221, 0.3);
}

</style>

</head>
<body>
    <div class="container">
        <h1>Liste des personnes</h1>
        
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["nom"]); ?></td>
                        <td><?php echo htmlspecialchars($row["prenom"]); ?></td>
                        <td><?php echo htmlspecialchars($row["email"]); ?></td>
                        <td><?php echo htmlspecialchars($row["telephone"]); ?></td>
                        <td>
                            <a href="editer.php?id=<?php echo $row["id"]; ?>" class="btn btn-edit">Modifier</a>
                            <a href="liste.php?delete=<?php echo $row["id"]; ?>" class="btn btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette personne?')">Supprimer</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="empty-message">Aucune personne enregistrée pour le moment.</p>
        <?php endif; ?>
        
        <a href="index.php" class="btn btn-add">Ajouter une nouvelle personne</a>
    </div>
</body>
</html>