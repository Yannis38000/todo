<?php
session_start();
require_once 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}
?>

<?php
$statut = $_GET['statut'] ?? 'toutes';
$priorite_filtre = $_GET['priorite'] ?? 'toutes';
$tri = $_GET['tri'] ?? 'date_creation';

$sql = "SELECT * FROM tasks WHERE utilisateur_id = ?";
$params = [$_SESSION['user_id']];

if ($statut === 'en_cours') {
    $sql .= " AND terminee = 0";
} elseif ($statut === 'terminees') {
    $sql .= " AND terminee = 1";
}

if ($priorite_filtre !== 'toutes') {
    $sql .= " AND priorite = ?";
    $params[] = $priorite_filtre;
}

$sql .= " ORDER BY " . $tri;

$par_page = $_GET['par_page'] ?? '10';
$page = $_GET['page'] ?? 1;

if ($par_page !== 'toutes') {
    $offset = ($page - 1) * (int)$par_page;
    $sql .= " LIMIT " . (int)$par_page . " OFFSET " . $offset;
}

$sql_count = "SELECT COUNT(*) FROM tasks WHERE utilisateur_id = ?";
$params_count = [$_SESSION['user_id']];

if ($statut === 'en_cours') {
    $sql_count .= " AND terminee = 0";
} elseif ($statut === 'terminees') {
    $sql_count .= " AND terminee = 1";
}

if ($priorite_filtre !== 'toutes') {
    $sql_count .= " AND priorite = ?";
    $params_count[] = $priorite_filtre;
}

$stmt_count = $pdo->prepare($sql_count);
$stmt_count->execute($params_count);
$total = $stmt_count->fetchColumn();
$total_pages = $par_page !== 'toutes' ? ceil($total / (int)$par_page) : 1;

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$taches = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes tâches</title>
    <link rel="stylesheet" href="style.css">
    <script src="app.js" defer></script>
</head>
<body>
    <form method="POST" action="api.php" id="form-creer">
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
    <?php foreach ($taches as $tache) { ?>
        <div class="
            <?php echo $tache['terminee'] ? 'terminee' : ''; ?> 
            <?php echo $tache['date_echeance'] < date('Y-m-d') && !$tache['terminee'] ? 'en-retard' : ''; ?>">
            <?php if ($tache['date_echeance'] < date('Y-m-d') && !$tache['terminee']): ?>
                <p style="color: red;">⚠️ En retard !</p>
            <?php endif; ?>
            <h3><?php echo $tache['titre']; ?></h3>
                <p><?php echo $tache['description']; ?></p>
                <p><?php echo $tache['date_echeance']; ?></p>
                <p><?php echo $tache['priorite']; ?></p>
            <form method="POST" action="api.php" id="form-terminer-<?php echo $tache['id']; ?>">
                <input type="hidden" name="action" value="terminer_tache">
                <input type="hidden" name="id" value="<?php echo $tache['id']; ?>">
                <input type="submit" value="<?php echo $tache['terminee'] ? 'Réouvrir' : 'Terminer'; ?>">
            </form>
        </div>
    <div class="action-tache">
        <form method="POST" action="api.php" id="form-modifier-<?php echo $tache['id']; ?>">
            <input type="hidden" name="action" value="modifier_tache">
            <input type="hidden" name="id" value="<?php echo $tache['id']; ?>">
            <input type="text" name="title" value="<?php echo $tache['titre']; ?>">
            <textarea name="description"><?php echo $tache['description']; ?></textarea>
            <input type="date" name="date" value="<?php echo $tache['date_echeance']; ?>">
            <select name="priority">
                <option value="basse">Basse</option>
                <option value="moyenne">Moyenne</option>
                <option value="haute">Haute</option>
            </select>
            <input type="submit" value="Modifier">
        </form>
    </div>
    <form method="POST" action="api.php" id="form-supprimer-<?php echo $tache['id']; ?>">
        <input type="hidden" name="action" value="supprimer_tache">
        <input type="hidden" name="id" value="<?php echo $tache['id']; ?>">
        <input type="submit" value="Supprimer">
    </form>
    <?php } ?>

    <?php if ($total_pages > 1): ?>
    <div id="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>&statut=<?php echo $statut; ?>&priorite=<?php echo $priorite_filtre; ?>&tri=<?php echo $tri; ?>&par_page=<?php echo $par_page; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>

    <form method="GET" action="index.php" id="form-filtres">
        <select name="statut">
            <option value="toutes">Toutes</option>
            <option value="en_cours">En cours</option>
            <option value="terminees">Terminées</option>
        </select>
        <select name="priorite">
            <option value="toutes">Toutes</option>
            <option value="basse">Basse</option>
            <option value="moyenne">Moyenne</option>
            <option value="haute">Haute</option>
        </select>
        <select name="tri">
            <option value="date_creation">Date de création</option>
            <option value="date_echeance">Date d'échéance</option>
            <option value="priorite">Priorité</option>
        </select>
    <input type="submit" value="Filtrer">
    <select name="par_page">
        <option value="10">10 par page</option>
        <option value="25">25 par page</option>
        <option value="50">50 par page</option>
        <option value="100">100 par page</option>
        <option value="toutes">Toutes</option>
    </select>
</form>
</body>
</html>

