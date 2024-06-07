<?php
require 'config.php';

if (!isset($_SESSION['admin_id']) && !isset($_SESSION['user_id'])) {
    // Przekierowanie na stronę index.php, jeśli nie jest zalogowany
    header('Location: index.php');
    exit;
}
?>

<?php
require 'Database.php';

$event_id = $_GET['event_id'];

$db = new Database();
$db->query("SELECT * FROM users WHERE event_id = :event_id");
$db->bind(':event_id', $event_id);
$users = $db->resultset();

$matched = [];
$unmatched = $users;

// Prosta logika dopasowania (dla demonstracji)
while (count($unmatched) > 1) {
    $user1 = array_shift($unmatched);
    $user2 = array_shift($unmatched);
    $db->query("INSERT INTO matches (user1_id, user2_id) VALUES (:user1_id, :user2_id)");
    $db->bind(':user1_id', $user1['id']);
    $db->bind(':user2_id', $user2['id']);
    $db->execute();
    $matched[] = [$user1, $user2];

    // Wysyłanie e-maili
    $to1 = $user1['email'];
    $to2 = $user2['email'];
    $subject = "Masz dopasowanie!";
    $message1 = "Dopasowano Cię z " . $user2['name'] . ". Numer telefonu: " . $user2['phone'];
    $message2 = "Dopasowano Cię z " . $user1['name'] . ". Numer telefonu: " . $user1['phone'];
    mail($to1, $subject, $message1);
    mail($to2, $subject, $message2);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dopasowania</title>
</head>
<body>
    <h1>Dopasowania</h1>
    <h2>Dopasowane pary</h2>
    <ul>
        <?php foreach ($matched as $pair) {
            echo "<li>" . $pair[0]['name'] . " i " . $pair[1]['name'] . "</li>";
        } ?>
    </ul>
    <h2>Osoby bez pary</h2>
    <ul>
        <?php foreach ($unmatched as $user) {
            echo "<li>" . $user['name'] . "</li>";
        } ?>
    </ul>
    <a href="index.php">Wróć</a>
</body>
</html>
