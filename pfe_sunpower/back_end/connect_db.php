<?php
$host = 'localhost';
$db   = 'sun_power';
$user = 'root'; // ou ton utilisateur MySQL
$pass = '';     // mot de passe, souvent vide en local


try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connexion réussie";
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
