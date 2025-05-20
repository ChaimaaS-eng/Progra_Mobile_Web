<?php
// Page avec formulaire d'ajout
require_once 'config.php';

// Traitement du formulaire si soumis
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST["nom"]);
    $prenom = htmlspecialchars($_POST["prenom"]);
    $email = htmlspecialchars($_POST["email"]);
    $telephone = htmlspecialchars($_POST["telephone"]);

    $sql = "INSERT INTO personnes (nom, prenom, email, telephone) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nom, $prenom, $email, $telephone);

    if ($stmt->execute()) {
        $message = "Personne ajoutée avec succès";
    } else {
        $message = "Erreur: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une personne</title>
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
    width: 450px;
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
    font-size: 28px;
    font-weight: 600;
    position: relative;
}

h1:after {
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

input[type="text"], input[type="email"], input[type="tel"] {
    width: 100%;
    padding: 14px;
    margin-bottom: 22px;
    border: 1px solid #e0c3fc;
    border-radius: 12px;
    background: #fefefe;
    box-sizing: border-box;
    transition: all 0.3s ease;
    font-family: 'Montserrat', sans-serif;
    color: #333;
}

input[type="text"]:focus, input[type="email"]:focus, input[type="tel"]:focus {
    border-color: #9d4edd;
    outline: none;
    box-shadow: 0 0 0 3px rgba(157, 78, 221, 0.15);
}

button {
    width: 100%;
    background: linear-gradient(to right, #c77dff, #9d4edd);
    color: white;
    border: none;
    padding: 15px;
    font-size: 16px;
    font-weight: 500;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-family: 'Montserrat', sans-serif;
}

button:hover {
    background: linear-gradient(to right, #9d4edd, #7b2cbf);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(157, 78, 221, 0.3);
}

.button-secondary {
    margin-top: 16px;
    width: 100%;
    background-color: #f8bcff;
    color: #7b2cbf;
    border: none;
    padding: 14px;
    font-size: 15px;
    font-weight: 500;
    border-radius: 12px;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    display: block;
    transition: all 0.3s ease;
    font-family: 'Montserrat', sans-serif;
}

.button-secondary:hover {
    background-color: #f3dbff;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(248, 188, 255, 0.3);
}
</style>
</head>
<body>
    <div class="container">
        <h1>Ajouter une personne</h1>
        
        <?php if (!empty($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" required>
            
            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email">
            
            <label for="telephone">Téléphone:</label>
            <input type="tel" id="telephone" name="telephone">
            <td>
             <input type="submit" value="Ajouter">
            </td>
            
            
        </form>
        
        <a href="liste.php" class="btn">Voir la liste des personnes</a>
    </div>

    <script>
function modifierElement(id) {
    // Rediriger vers la page de modification
    window.location.href = 'modifier.php?id=' + id;
}

function confirmerSuppression(id) {
    // Afficher une confirmation avant suppression
    if(confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
        window.location.href = 'supprimer.php?id=' + id;
    }
}
</script>
</body>
</html>
