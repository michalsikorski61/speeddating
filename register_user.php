<?php
require_once 'config.php';

require_once 'Database.php';

$db = new Database();

// Sprawdzenie statusu sesji i uruchomienie sesji, jeśli nie jest aktywna
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    echo "Tutaj cię nie mogę wpuścić. Działanie zostało zgłoszone. Wróć na stronę główną.";
    echo "<a href='index.php'>Wróć</a>";
    $db->logActivity(null, 'Ktoś próbował wejść na stronę user_panel.php bez logowania .');
    header('Location: index.php');
    exit;
}


?>

<?php

$usr = [
    'name' => '',
    'email' => '',
    'phone' => '',
    'password' =>'',
    'event_id' => ''
];
$errors = [
    'name' => '',
    'email' => '',
    'phone' => '',
    'password' => '',


];
$msg = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
     $name = trim($_POST['name']);
     $email = trim($_POST['email']);
     $phone = trim($_POST['phone']);
     $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
     $event_id = $_POST['event_id'];
    //sanityzacja danych wejściowych
    
    $check_filter['name']['filter'] = FILTER_VALIDATE_REGEXP;
    $check_filter['name']['options']['regexp'] = "/^[a-zA-Z ]*$/";
    $check_filter['email']['filter'] = FILTER_VALIDATE_EMAIL;
    $check_filter['phone']['filter'] = FILTER_VALIDATE_REGEXP;
    $check_filter['phone']['options']['regexp'] = "/^[0-9]{9}$/";
    $check_filter['password']['filter'] = FILTER_VALIDATE_REGEXP;
    $check_filter['password']['options']['regexp'] = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/";

    $usr = filter_input_array(INPUT_POST, $check_filter);
    
    // Walidacja danych wejściowych
    if (empty($name) || empty($email) || empty($phone) || empty($_POST['password']) || empty($event_id)) {
        die("Wszystkie pola są wymagane.");
    }

    if($usr['name'] === false) {
        $errors['name'] = 'Niepoprawna nazwa';
        echo "Nazwa musi składać się z liter i spacji";
    }elseif($usr['email'] === false) {
        $errors['email'] = 'Niepoprawny email';
        echo "Niepoprawny email";
    }elseif($usr['phone'] === false) {
        $errors['phone'] = 'Niepoprawny numer telefonu';
        echo "Numer telefonu musi składać się z 9 cyfr";
    }elseif($usr['password'] === false) {
        $errors['password'] = 'Hasło musi zawierać co najmniej 8 znaków, jedną dużą literę, jedną małą literę i jedną cyfrę';
        echo "Hasło musi zawierać co najmniej 8 znaków, jedną dużą literę, jedną małą literę i jedną cyfrę";
    }else{
        
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
    }

    

    
    ?>
    <a href="index.php">Wróć</a>
<?php

}
