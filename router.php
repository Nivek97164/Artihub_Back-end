<?php
// router.php

if (php_sapi_name() === 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false; // Laisser le serveur servir le fichier tel quel
    }
}

// Rediriger toute autre requête vers index.php (ton front controller)
require_once __DIR__ . '/index.php';
