<?php
require 'config.php';
// Reszta kodu
?>

<?php
require 'Database.php';

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$event_id = $_POST['event_id'];

// Walidacja danych wejściowych
if (empty($name) || empty($email) || empty($phone) || empty($_POST['password']) || empty($event_id)) {
    die("Wszystkie pola są wymagane.");
}

$db = new Database();

$db->query("INSERT INTO users (name, email, phone, password, event_id) VALUES (:name, :email, :phone, :password, :event_id)");
$db->bind(':name', $name);
$db->bind(':email', $email);
$db->bind(':phone', $phone);
$db->bind(':password', $password);
$db->bind(':event_id', $event_id);

if ($db->execute()) {
    // Logowanie operacji rejestracji
    $db->logActivity($db->lastInsertId(), 'Rejestracja użytkownika');
    echo "Rejestracja zakończona sukcesem!";
} else {
    echo "Wystąpił błąd podczas rejestracji. Spróbuj ponownie później.";
}
?>
<a href="index.php">Wróć</a>
