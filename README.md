1) Application To do list :

Application de gestion de tâches.

2) Prérequis :
- XAMPP (MySQL)
- Navigateur

3) Installation :

1. Cloner le dépôt dans `C:\xampp\htdocs\todo`
2. Importer la base de données
3. Copier `config.example.php` en `config.php` et remplir les identifiants
4. Lancer XAMPP (start Apache et start MySQL + admin MySQL)
5. Taper dans l'url `http://localhost/todo` pour accéder à la page

4) Fonctionnalités :
- Inscription et connexion
- Création, modification, suppression de tâches
- Filtres par statut et par priorité
- Tri et pagination
- Indication des tâches terminées

5) Base de données :

SQL :

CREATE TABLE users (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL
);

CREATE TABLE tasks (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(255) NOT NULL,
    description VARCHAR(255),
    date_echeance DATE NOT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    priorite TEXT NOT NULL,
    terminee TINYINT NOT NULL DEFAULT 0,
    utilisateur_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (utilisateur_id) REFERENCES users(id)
);