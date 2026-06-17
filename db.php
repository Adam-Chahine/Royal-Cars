<?php
// Configuration de la base de données
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "royal_cars";

// Création de la connexion
$conn = new mysqli($host, $user, $pass, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Optionnel : Forcer l'UTF-8 pour éviter les problèmes d'accents
$conn->set_charset("utf8mb4");
