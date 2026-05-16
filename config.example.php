<?php
$host = "localhost";
$dbname = "nom_de_la_base_de_donnees";
$username = "nom_de_l_utilisateur";
$password = "mot_de_passe";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}