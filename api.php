<?php
session_start();

require_once 'config.php';

$action = $_POST['action'];

header('Content-Type: application/json');

switch ($action) {
    case 'connexion':
        $email_connexion = $_POST['email'];
        $mot_de_passe_connexion = $_POST['password'];
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email_connexion]);
        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($utilisateur && password_verify($mot_de_passe_connexion, $utilisateur['mot_de_passe'])) {
        $_SESSION['user_id'] = $utilisateur['id'];
        header("Location: index.php");
        exit();
        } else {
        http_response_code(401);
        echo json_encode(['erreur' => 'Email ou mot de passe incorrect']);
        exit();
        }
        break;
    case 'inscription':
        $email_inscription = $_POST['email'];
        $mot_de_passe_inscription = $_POST['password'];
        $confirmation_mot_de_passe = $_POST['password_confirm'];

        if ($mot_de_passe_inscription !== $confirmation_mot_de_passe) {
            http_response_code(400);
            echo json_encode(['erreur' => 'Les mots de passe ne correspondent pas']);
            exit();
        } else {
            $mot_de_passe_hashe = password_hash($mot_de_passe_inscription, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (email, mot_de_passe) VALUES (?, ?)");
            $stmt->execute([$email_inscription, $mot_de_passe_hashe]);
            $_SESSION['message'] = "Bienvenue parmi nous !";
            header("Location: connexion.php");
            exit();
        }
        break;
    case 'deconnexion':
        session_destroy();
        header("Location: connexion.php");
        exit();
        break;
    case 'creer_tache':
        $titre_tache = $_POST['title'];
        $description_tache = $_POST['description'];
        $date_echeance = $_POST['date'];
        $priorite = $_POST['priority'];
        $user_id = $_SESSION['user_id'];
        $stmt = $pdo->prepare("INSERT INTO tasks (titre, description, date_echeance, priorite, utilisateur_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$titre_tache, $description_tache, $date_echeance, $priorite, $user_id]);
        http_response_code(201);
        echo json_encode(['message' => 'Tache creee !']);
        header("Location: index.php");
        exit();
        break;
    case 'supprimer_tache':
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ? AND utilisateur_id = ?");
        $id_tache = $_POST['id'];
        $user_id = $_SESSION['user_id'];
        $stmt->execute([$id_tache, $user_id]);
        http_response_code(200);
        echo json_encode(['message' => 'Tache suprimee !']);
        header("Location: index.php");
        exit();
        break;
    case 'modifier_tache':
        $stmt = $pdo->prepare("UPDATE tasks SET titre = ?, description = ?, date_echeance = ?, priorite = ? WHERE id = ? AND utilisateur_id = ?");
        $titre_tache = $_POST['title'];
        $description_tache = $_POST['description'];
        $date_echeance = $_POST['date'];
        $priorite = $_POST['priority'];
        $id_tache = $_POST['id'];
        $user_id = $_SESSION['user_id'];
        $stmt->execute([$titre_tache, $description_tache, $date_echeance, $priorite, $id_tache, $user_id]);
        http_response_code(200);
        echo json_encode(['message' => 'Tache modifiee !']);
        header("Location: index.php");
        exit();
        break;
}