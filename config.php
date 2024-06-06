<?php

// Wyłączenie wyświetlania błędów
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

// Włączenie logowania błędów do pliku
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/php-error.log');

// Ukrycie wersji PHP
ini_set('expose_php', 0);
header_remove('X-Powered-By');

// Sprawdzenie, czy sesja nie jest już uruchomiona
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Powrót konfiguracji bazy danych
return [
    'database' => [
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'name' => 'speeddating',
    ],
];
?>
