<?php

// Wyłączenie wyświetlania błędów


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
