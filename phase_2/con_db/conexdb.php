<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>connexion_db</title>
</head>
<body>

<?php

session_start();

// Configuration de la base de données
$host = "localhost"; // Hôte de la base de données
$dbuser = "root";    // Nom d'utilisateur de la base de données
$dbpass = "";        // Mot de passe de la base de données
$dbname = "streamDB"; // Nom de la base de données

// URL de base pour les liens relatifs dans l'application
$base_url = 'http://localhost:8081/';

// Établissement de la connexion à la base de données
$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

?>

</body>
</html>