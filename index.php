<?php
session_start();
require_once 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}
?>

<?php
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE utilisateur_id = ?");
$utilisateur = $_SESSION['user_id'];
$stmt->execute([$utilisateur]);
$taches = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <?php foreach ($taches as $tache) { ?>
    <div>
        <h3><?php echo $tache['titre']; ?></h3>
        <p><?php echo $tache['description']; ?></p>
        <p><?php echo $tache['date_echeance']; ?></p>
        <p><?php echo $tache['priorite']; ?></p>
    </div>
    <?php } ?>
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

