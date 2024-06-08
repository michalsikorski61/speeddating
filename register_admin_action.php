<?php
require 'config.php';

require 'Database.php';

$db = new Database();

// Sprawdzenie statusu sesji i uruchomienie sesji, jeśli nie jest aktywna
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Sprawdzenie, czy użytkownik jest zalogowany jako administrator
if (!isset($_SESSION['admin_id'])) {
    echo "Tutaj cię nie mogę wpuścić. Musisz być zalogowany jako administrator, aby wykonać tę operację.";
    echo "<a href='admin_login.php'>Wróć</a>";
    header('Location: index.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Tutaj cię nie mogę wpuścić. Działanie zostało zgłoszone. Wróć na stronę główną.";
    echo "<a href='index.php'>Wróć</a>";
    $db->logActivity(null, 'Ktoś próbował wejść na stronę register_admin_action.php bez wysłania forma .');
    header('Location: index.php');
    exit;
}else{
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Walidacja danych wejściowych
    if (empty($name) || empty($email) || empty($_POST['password'])) {
        die("Wszystkie pola są wymagane.");
    }



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
<?php
}



