<?php
//Configuration de la connexion à la base de données
$servername = "localhost";
$username = "root";  
$password = ""; 
$dbname = "gestionPersonnes";

// Création de la connexion
$conn = new mysqli($servername, $username, $password);


// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Création de la base de données si elle n'existe pas
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === FALSE) {
    die("Erreur lors de la création de la base de données : " . $conn->error);
}

// Sélection de la base de données
$conn->select_db($dbname);

// Création de la table personnes si elle n'existe pas
$sql = "CREATE TABLE IF NOT EXISTS personnes (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(50),
    telephone VARCHAR(15),
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === FALSE) {
    die("Erreur lors de la création de la table : " . $conn->error);
}
?>

