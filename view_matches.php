<?php
require 'config.php';
require 'Database.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    echo "Tutaj cię nie mogę wpuścić. Wróć na stronę główną.";
    echo "<a href='index.php'>Wróć</a>";
    $db = new Database();
    $db->logActivity(null, 'Ktoś próbował wejść na stronę view_matches.php bez logowania.');
    header('Location: index.php');
    exit;
}

$db = new Database();
// sanityzacja danych wejściowych czy $_POST['event_id'] jest liczbą

// Pobierz listę wydarzeń
$db->query("SELECT id, name FROM events");
$events = $db->resultset();

$event_id = isset($_POST['event_id']) ? intval($_POST['event_id']) : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST" && $event_id > 0) {
    try {
        echo "Event ID: " . $event_id . "<br>"; // Debugowanie wartości event_id
        // Pobierz wszystkie wzajemne wybory dla konkretnego wydarzenia
        $sql = "
            SELECT LEAST(c1.user_id, c1.choice_id) AS user1_id, GREATEST(c1.user_id, c1.choice_id) AS user2_id
            FROM choices c1
            JOIN choices c2 ON c1.user_id = c2.choice_id AND c1.choice_id = c2.user_id
            JOIN users u1 ON c1.user_id = u1.id
            JOIN users u2 ON c1.choice_id = u2.id
            WHERE u1.event_id = {$event_id} AND u2.event_id = {$event_id}
            GROUP BY LEAST(c1.user_id, c1.choice_id), GREATEST(c1.user_id, c1.choice_id)
        ";
        
        $stmt = $db->getPdo()->prepare($sql);
        // $stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $stmt->execute();
        $matches = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Błąd wykonania: " . $e->getMessage() . "<br>";
        echo "Kod błędu: " . $e->getCode() . "<br>";
        echo "Plik: " . $e->getFile() . "<br>";
        echo "Linia: " . $e->getLine() . "<br>";
    }
} else {
    $matches = [];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Podgląd Par</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Podgląd Par</h1>
        <form method="post" action="">
            <label for="event_id">Wybierz wydarzenie:</label>
            <select id="event_id" name="event_id" required>
                <option value="">-- Wybierz wydarzenie --</option>
                <?php foreach ($events as $event): ?>
                    <option value="<?php echo htmlspecialchars($event['id'], ENT_QUOTES, 'UTF-8'); ?>">
                        <?php echo htmlspecialchars($event['name'], ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Pokaż pary</button>
        </form>
        
        <?php if (!empty($matches)): ?>
            <form method="post" action="mail_init.php">
                <ul>
                    <?php foreach ($matches as $match): ?>
                        <?php
                        $db->query("SELECT name, email, phone FROM users WHERE id = :id");
                        $db->bind(':id', $match['user1_id']);
                        $user1 = $db->single();
                        $db->query("SELECT name, email, phone FROM users WHERE id = :id");
                        $db->bind(':id', $match['user2_id']);
                        $user2 = $db->single();
                        ?>
                        <li>
                            <input type="checkbox" name="matches[]" value="<?php echo htmlspecialchars($user1['phone'] . ',' . $user1['email'] . ',' . $user2['phone'] . ',' . $user2['email'], ENT_QUOTES, 'UTF-8'); ?>">
                            <?php echo htmlspecialchars($user1['name'], ENT_QUOTES, 'UTF-8'); ?> i <?php echo htmlspecialchars($user2['name'], ENT_QUOTES, 'UTF-8'); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <button type="submit">Wyślij Email</button>
            </form>
        <?php endif; ?>
        
        <a href="admin_panel.php">Wróć</a>
    </div>
</body>
</html>
