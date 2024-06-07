<?php
require 'config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'Database.php'; // Użycie require_once zamiast require

$db = new Database();

// Sprawdzenie statusu sesji i uruchomienie sesji, jeśli nie jest aktywna
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    echo "Tutaj cię nie mogę wpuścić. Działanie zostało zgłoszone. Wróć na stronę główną.";
    echo "<a href='index.php'>Wróć</a>";
    $db->logActivity(null, 'Ktoś próbował wejść na stronę save_choices.php bez logowania.');
    exit;
}

$user_id = $_SESSION['user_id'];
$choices = $_POST['choices'];

// Usuń wcześniejsze wybory
$db->query("DELETE FROM choices WHERE user_id = :user_id");
$db->bind(':user_id', $user_id);
$db->execute();

// Zapisz nowe wybory
foreach ($choices as $choice_id) {
    $db->query("INSERT INTO choices (user_id, choice_id) VALUES (:user_id, :choice_id)");
    $db->bind(':user_id', $user_id);
    $db->bind(':choice_id', $choice_id);
    $db->execute();
}

// Logowanie operacji zapisu wyborów
$db->logActivity($user_id, 'Zapis wyborów');
header('Location: user_panel.php');
exit;
?>
