<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

require 'Database.php';
$db = new Database();

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
?>
