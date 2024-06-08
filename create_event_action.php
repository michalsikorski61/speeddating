<?php

require 'Database.php';

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Tutaj cię nie mogę wpuścić. Działanie zostało zgłoszone. Wróć na stronę główną.";
    echo "<a href='index.php'>Wróć</a>";
    $db->logActivity(null, 'Ktoś próbował wejść na stronę create_event_action.php bez wysłania formularza.');
    header('Location: index.php');
    exit;
}else{
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
    

$name = $_POST['name'];
$city = $_POST['city'];

$name = trim($_POST['name']);
$city = trim($_POST['city']);

$check_filter['name']['filter'] = FILTER_VALIDATE_REGEXP;
$check_filter['name']['options']['regexp'] = "/^[a-zA-Z ]*$/";
$check_filter['city']['filter'] = FILTER_VALIDATE_REGEXP;
$check_filter['city']['options']['regexp'] = "/^[a-zA-Z ]*$/";

$usr = filter_input_array(INPUT_POST, $check_filter);
if (empty($name) || empty($city)) {
    die("Wszystkie pola są wymagane.");
}
if($usr['name'] === false) {
    $errors['name'] = 'Niepoprawna nazwa';
    echo "Nazwa musi składać się z liter i spacji";
}elseif($usr['city'] === false) {
    $errors['city'] = 'Niepoprawny city';
    echo "Niepoprawny city";
}else{
    $db->query("INSERT INTO events (name, city) VALUES (:name, :city)");
    $db->bind(':name', $name);
    $db->bind(':city', $city);

    if ($db->execute()) {
        echo "Wydarzenie stworzone pomyślnie!";
    } else {
        echo "Błąd wykonania: " . $db->getError();
    }
}

?>
<a href="index.php">Wróć</a>
<?php
}