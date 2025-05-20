<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données envoyées par le formulaire
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    $confirmpassword = htmlspecialchars($_POST["confirmpassword"]);
    
   
    echo "<h1>Registration Successful!</h1>";
    echo "<p><strong>Name:</strong> $name</p>";
    echo "<p><strong>Email:</strong> $email</p>";
    echo "<p><strong>Password:</strong> $password</p>";
    echo "<p><strong>Confirmpassword:</strong> $confirmpassword</p>";
} else {
    echo "<h1>Access Denied</h1>";
}
?>