<?php
$host = 'https://node234-eu.n0c.com/';
$db   = 'uybhnhcm_artihub';
$user = 'uybhnhcm_Kevin971Bern';
$pass = 'Nivek971426410:)'; // remplace par ton vrai mot de passe si tu en as défini un autre
$charset = 'utf8mb4';

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass, $options);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}
?>
