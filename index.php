<?php
echo json_encode([
    "message" => "Bienvenue sur l'API Artihub",
    "routes" => [
        "GET /routes/user.php" => "Liste des utilisateurs",
        "POST /routes/user.php" => "Créer un utilisateur",
        "GET /routes/project.php" => "Liste des projets",
        "POST /routes/project.php" => "Créer un projet",
        "GET /routes/service_request.php" => "Liste des demandes",
        "POST /routes/service_request.php" => "Créer une demande",
        "POST /auth/login.php" => "Connexion",
        "POST /auth/register.php" => "Inscription",
        "GET /auth/logout.php" => "Déconnexion"
    ]
]);
?>
