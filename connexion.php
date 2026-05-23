<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de connexion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="header">
        <h1>De retour parmi nous ?</h1>
    </div>
    <form method="POST" action="api.php">
        <input type="email" name="email">
        <input type="password" name="password">
        <input type="submit" name="submit">
        <input type="hidden" name="action" value="connexion">
    </form>
    <a href="inscription.php">Pas encore parmi nous ? Inscris toi !</a>
</body>
</html>