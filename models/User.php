<?php
class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Récupérer tous les utilisateurs
    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT id, username, email, role FROM Users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un utilisateur par ID (public)
    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT id, username, email, role FROM Users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Créer un utilisateur
    public function create($username, $email, $password, $role, $phone = null, $address = null, $postal_code = null, $geolocalisation_enable = false)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("
            INSERT INTO Users (username, email, password, role, phone, address, postal_code, geolocalisation_enable)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $username,
            $email,
            $hash,
            $role,
            $phone,
            $address,
            $postal_code,
            $geolocalisation_enable ? 1 : 0
        ]);
    }

    // Authentification par email ou téléphone
    public function authenticate($login, $password)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Users WHERE email = ? OR phone = ? LIMIT 1");
        $stmt->execute([$login, $login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    // Récupérer un utilisateur par ID (profil complet)
    public function findById($id)
    {
        $sql = "SELECT id, username, email, role, phone, address, postal_code, description, specialite, geolocalisation_enable, created_at 
                FROM Users WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer un utilisateur par email
    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM Users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer un utilisateur par téléphone
    public function findByPhone($phone)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM Users WHERE phone = ? LIMIT 1');
        $stmt->execute([$phone]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer par email OU téléphone (pour login)
    public function findByEmailOrPhone($login)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM Users WHERE email = ? OR phone = ? LIMIT 1');
        $stmt->execute([$login, $login]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer par email ET rôle (pour l'inscription unique par type)
    public function findByEmailAndRole($email, $role)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM Users WHERE email = ? AND role = ? LIMIT 1');
        $stmt->execute([$email, $role]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer par téléphone ET rôle (pour l'inscription unique par type)
    public function findByPhoneAndRole($phone, $role)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM Users WHERE phone = ? AND role = ? LIMIT 1');
        $stmt->execute([$phone, $role]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function findByEmailOrPhoneAndRole($login, $role)
{
    $stmt = $this->pdo->prepare('SELECT * FROM Users WHERE (email = ? OR phone = ?) AND role = ? LIMIT 1');
    $stmt->execute([$login, $login, $role]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

}
?>
