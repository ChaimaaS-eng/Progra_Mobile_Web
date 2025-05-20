<?php
// Page pour modifier une personne
require_once 'config.php';

// Vérifie si un ID est fourni
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: liste.php");
    exit();
}

$id = intval($_GET['id']);

// Traitement du formulaire si soumis
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST["nom"]);
    $prenom = htmlspecialchars($_POST["prenom"]);
    $email = htmlspecialchars($_POST["email"]);
    $telephone = htmlspecialchars($_POST["telephone"]);

    $sql = "UPDATE personnes SET nom = ?, prenom = ?, email = ?, telephone = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nom, $prenom, $email, $telephone, $id);

    if ($stmt->execute()) {
        $message = "Personne mise à jour avec succès";
    } else {
        $message = "Erreur: " . $stmt->error;
    }
    $stmt->close();
}

// Récupération des données de la personne
$sql = "SELECT * FROM personnes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: liste.php");
    exit();
}

$personne = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une personne</title>
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
    background: #fff;
    padding: 35px;
    border-radius: 20px;
    box-shadow: 0 15px 30px rgba(219, 154, 255, 0.2);
    max-width: 600px;
    margin: 40px auto;
    border: 1px solid rgba(219, 154, 255, 0.3);
}

h2 {
    text-align: center;
    color: #9d4edd;
    font-size: 28px;
    margin-bottom: 30px;
    font-weight: 600;
    position: relative;
}

h2:after {
    content: "";
    position: absolute;
    width: 60px;
    height: 3px;
    background: linear-gradient(to right, #c77dff, #9d4edd);
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #7b2cbf;
    font-size: 15px;
}

input[type="text"], input[type="email"] {
    width: 100%;
    padding: 14px;
    margin-bottom: 22px;
    border: 1px solid #e0c3fc;
    border-radius: 12px;
    box-sizing: border-box;
    font-size: 15px;
    transition: all 0.3s ease;
    font-family: 'Montserrat', sans-serif;
    color: #333;
}

input[type="text"]:focus, input[type="email"]:focus {
    border-color: #9d4edd;
    outline: none;
    box-shadow: 0 0 0 3px rgba(157, 78, 221, 0.15);
}

.button-primary {
    background: linear-gradient(to right, #c77dff, #9d4edd);
    border: none;
    padding: 15px;
    width: 100%;
    border-radius: 12px;
    color: white;
    font-weight: 500;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-family: 'Montserrat', sans-serif;
}

.button-primary:hover {
    background: linear-gradient(to right, #9d4edd, #7b2cbf);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(157, 78, 221, 0.3);
}

.button-secondary {
    margin-top: 16px;
    background: linear-gradient(to right, #ff86c9, #ff5cb0);
    border: none;
    padding: 15px;
    width: 100%;
    border-radius: 12px;
    color: white;
    font-weight: 500;
    font-size: 16px;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
    font-family: 'Montserrat', sans-serif;
}

.button-secondary:hover {
    background: linear-gradient(to right, #ff5cb0, #ff3d99);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 92, 176, 0.3);
}
    </style>
</head>
<body>
    <div class="container">
        <h1>Modifier une personne</h1>
        
        <?php if (!empty($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $id); ?>">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($personne["nom"]); ?>" required>
            
            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($personne["prenom"]); ?>" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($personne["email"]); ?>">
            
            <label for="telephone">Téléphone:</label>
            <input type="tel" id="telephone" name="telephone" value="<?php echo htmlspecialchars($personne["telephone"]); ?>">
            
            
            <input type="submit" value="Mettre à jour">
        </form>
        
        <a href="liste.php" class="btn">Annuler et retourner à la liste</a>
    </div>
</body>
</html>