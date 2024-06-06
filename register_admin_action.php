<?php
require 'config.php';
// Sprawdzenie, czy użytkownik jest zalogowany jako admin lub user
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['user_id'])) {
    // Przekierowanie na stronę index.php, jeśli nie jest zalogowany
    header('Location: index.php');
    exit;
}
?>

<?php
session_start();
require 'Database.php';

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

// Walidacja danych wejściowych
if (empty($name) || empty($email) || empty($_POST['password'])) {
    die("Wszystkie pola są wymagane.");
}

$db = new Database();

$db->query("INSERT INTO admins (name, email, password) VALUES (:name, :email, :password)");
$db->bind(':name', $name);
$db->bind(':email', $email);
$db->bind(':password', $password);

if ($db->execute()) {
    // Sprawdzenie, czy zmienna sesji admin_id jest ustawiona
    if (isset($_SESSION['admin_id'])) {
        // Logowanie operacji rejestracji administratora
        $db->logActivity($_SESSION['admin_id'], 'Rejestracja administratora');
    }
    echo "Administrator został dodany pomyślnie!";
} else {
    echo "Wystąpił błąd podczas dodawania administratora. Spróbuj ponownie później.";
}
?>
<a href="admin_panel.php">Wróć</a>
