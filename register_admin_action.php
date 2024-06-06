<?php
require 'Database.php';

$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

$db = new Database();

$db->query("INSERT INTO admins (name, email, password) VALUES (:name, :email, :password)");
$db->bind(':name', $name);
$db->bind(':email', $email);
$db->bind(':password', $password);

if ($db->execute()) {
    // Logowanie operacji rejestracji administratora
    $db->logActivity($_SESSION['admin_id'], 'Rejestracja administratora');
    echo "Administrator został dodany pomyślnie!";
} else {
    echo "Błąd: " . $db->getError();
}
?>
<a href="admin_panel.php">Wróć</a>
