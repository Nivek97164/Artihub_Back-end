<?php
// GÈRE LE PRE-FLIGHT (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: https://artihubfront-end-production-3c59.up.railway.app");
    header("Access-Control-Allow-Credentials: true"); // AJOUTE MOI ÇA !
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Access-Control-Max-Age: 86400");
    http_response_code(200);
    exit;
}

// CES HEADERS DOIVENT ÊTRE AUSSI PRÉSENTS SUR TOUTES LES AUTRES RÉPONSES
header("Access-Control-Allow-Origin: https://artihubfront-end-production-3c59.up.railway.app");
header("Access-Control-Allow-Credentials: true"); // ÇA ICI AUSSI
header('Content-Type: application/json');


// Affichage erreurs (désactive en prod)
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../utils/jwt.php';

// Récupération des données JSON
$rawInput = file_get_contents("php://input");
$data = json_decode($rawInput, true);

// Vérification des champs obligatoires
$champs = ['username', 'email', 'password', 'role'];
$missing = array_filter($champs, fn($k) => empty($data[$k]));
if (!empty($missing)) {
    http_response_code(400);
    echo json_encode([
        "error" => "Champs requis manquants : " . implode(', ', $missing),
        "reçu" => $data
    ]);
    exit;
}

$userModel = new User($pdo);

// Vérifier l'unicité de l'email pour le même rôle
if ($userModel->findByEmailAndRole($data['email'], $data['role'])) {
    http_response_code(409); // Conflit
    echo json_encode([
        "error" => "Un compte existe déjà avec cet email pour ce type de profil."
    ]);
    exit;
}

// Vérifier l'unicité du téléphone pour le même rôle
if (!empty($data['phone']) && $userModel->findByPhoneAndRole($data['phone'], $data['role'])) {
    http_response_code(409); // Conflit
    echo json_encode([
        "error" => "Un compte existe déjà avec ce numéro pour ce type de profil."
    ]);
    exit;
}


// Création utilisateur
try {
    $success = $userModel->create(
        $data['username'],
        $data['email'],
        $data['password'],
        $data['role'],
        $data['phone'] ?? null,
        $data['address'] ?? null,
        $data['postal_code'] ?? null,
        !empty($data['geolocalisation_enable'])
    );

    if ($success) {
        $userData = $userModel->findByEmail($data['email']);
        if (!$userData) {
            http_response_code(500);
            echo json_encode(["error" => "Utilisateur créé mais introuvable"]);
            exit;
        }

        // Génère le token JWT
        $jwt = generate_jwt($userData['id']);

        // Pose le cookie JWT
        setcookie('jwt', $jwt, [
            'httponly' => true,
            'samesite' => 'Lax',
            'path' => '/',
            'secure' => false, // true si HTTPS
            'expires' => time() + 3600*24*7
        ]);

        echo json_encode(["success" => true]);
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Échec de l'enregistrement"]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "error" => "Erreur serveur",
        "details" => $e->getMessage()
    ]);
}
