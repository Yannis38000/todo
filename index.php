<?php
session_start();
    if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes tâches</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="POST" action="api.php">
        <input type="text" name="title">
        <textarea name="description"></textarea>
        <input type="date" name="date">
        <select name="priority">
        <option value="basse">Basse</option>
        <option value="moyenne">Moyenne</option>
        <option value="haute">Haute</option>
        </select>
        <input type="submit" name="submit">
        <input type="hidden" name="action" value="creer_tache">
    </form>
</body>
</html>

