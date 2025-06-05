<?php
$host = 'gondola.proxy.rlwy.net';
$port = 56629;
$db   = 'railway';
$user = 'root';
$pass = 'kCneUUOPuBkkISAvWiIspBcEUDMFYBlo';
$charset = 'utf8mb4';

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=$charset", $user, $pass, $options);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed', 'details' => $e->getMessage()]);
    exit;
}
?>
