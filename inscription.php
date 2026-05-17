<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'inscription</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="POST" action="api.php">
        <input type="email" name="email">
        <input type="password" name="password">
        <input type="password" name="password_confirm">
        <input type="submit" name="submit">
        <input type="hidden" name="action" value="inscription">
    </form>
    <a href="connexion.php">Déjà inscris ? Passe donc par là</a>
</body>
</html>