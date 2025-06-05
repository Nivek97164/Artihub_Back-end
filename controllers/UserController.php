<?php
require_once __DIR__ . '/../models/User.php';

class UserController {
    private $user;

    public function __construct($pdo) {
        $this->user = new User($pdo);
    }

    public function index() {
        header('Content-Type: application/json');
        echo json_encode($this->user->getAll());
    }

    public function show($id) {
        header('Content-Type: application/json');
        $user = $this->user->getById($id);
        if ($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Utilisateur introuvable"]);
        }
    }

    public function store($data) {
        header('Content-Type: application/json');
        // Vérifie que tous les champs sont là
        foreach(['username', 'email', 'password', 'role'] as $champ) {
            if (empty($data[$champ])) {
                http_response_code(400);
                echo json_encode(["error" => "Champ '$champ' manquant"]);
                return;
            }
        }
        $success = $this->user->create($data['username'], $data['email'], $data['password'], $data['role']);
        if ($success) {
            echo json_encode(["success" => true]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "User creation failed"]);
        }
    }
}
?>
