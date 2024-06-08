<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Usunięcie wszystkich zmiennych sesji
$_SESSION = array();

// Jeśli to pożądane, usuń także ciasteczko sesji
// Uwaga: usunięcie ciasteczka sesji nie niszczy sesji na serwerze
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Zniszczenie sesji
session_destroy();
?>
