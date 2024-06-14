<?php
require_once 'config.php';
require_once 'Database.php';

$db = new Database();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_id'])) {
    echo "Tutaj cię nie mogę wpuścić. Działanie zostało zgłoszone. Wróć na stronę główną.";
    echo "<a href='index.php'>Wróć</a>";
    $db->logActivity(null, 'Ktoś próbował wejść na stronę mail_init.php bez logowania.');
    header('Location: index.php');
    exit;
}

// Funkcja walidacji i sanityzacji danych z formularza
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Sanityzacja danych z $_POST['matches']
function sanitizeMatches($matches) {
    $sanitizedMatches = [];
    foreach ($matches as $match) {
        $sanitizedMatches[] = sanitizeInput($match);
    }
    return $sanitizedMatches;
}

$errors = [];
$matches = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['matches'])) {
        $errors[] = "Brak wybranych par.";
    } else {
        $matches = sanitizeMatches($_POST['matches']);
    }
} else {
    header('Location: index.php');
    exit;
}

// Domyślne wartości
$defaultMessage = "Cześć,

Mamy to!
Wyniki Speed Datingu poniżej 🙂

Prosimy, aby Panowie pierwsi odezwali się do wybranek maksymalnie do piątku.

Połączyłaś/eś się z:";
$defaultFrom = "speeddatingwarsztatytaneczne@gmail.com";
$defaultReplyTo = "speeddatingwarsztatytaneczne@gmail.com";
$defaultSubject = "Wyniki Speed Datingu";

?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel Administratora</title>
    <style>
        body {
            background-color: #333;
            color: #fff;
        }
        form {
            background-color: #888;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        h1, h3 {
            color: #fff;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Wyślij Email</h1>
        <?php if (!empty($errors)): ?>
            <div class="error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form method="post" action="mail_send.php">
            <?php foreach ($matches as $match): ?>
                <?php
                list($user1_phone, $user1_email, $user2_phone, $user2_email) = explode(',', $match);
                ?>
                <div>
                    <h3>Para: <?php echo htmlspecialchars($user1_email, ENT_QUOTES, 'UTF-8'); ?> i <?php echo htmlspecialchars($user2_email, ENT_QUOTES, 'UTF-8'); ?></h3>
                    <input type="hidden" name="matches[]" value="<?php echo htmlspecialchars($match, ENT_QUOTES, 'UTF-8'); ?>">
                    
                    <h4>Email do: <?php echo htmlspecialchars($user1_email, ENT_QUOTES, 'UTF-8'); ?></h4>
                    <label for="from_<?php echo $user1_phone; ?>">Telefon:</label>
                    <input type="tel" id="from_<?php echo $user1_phone; ?>" name="from_<?php echo $user1_phone; ?>" value="<?php echo htmlspecialchars($user1_phone, ENT_QUOTES, 'UTF-8'); ?>" required><br/>
                    <label for="from_<?php echo str_replace('@','_',$user1_email); ?>">Od:</label>
                    <input type="email" id="from_<?php echo $user1_email; ?>" name="from_<?php echo str_replace('@','_',$user1_email); ?>" value="<?php echo htmlspecialchars($defaultFrom, ENT_QUOTES, 'UTF-8'); ?>" required>
                    <br>
                    <label for="replyTo_<?php echo str_replace('@','_',$user1_email); ?>">Odpowiedz do:</label>
                    <input type="email" id="replyTo_<?php echo $user1_email; ?>" name="replyTo_<?php echo str_replace('@','_',$user1_email) ?>" value="<?php echo htmlspecialchars($defaultReplyTo, ENT_QUOTES, 'UTF-8'); ?>" required>
                    <br>
                    <label for="subject_<?php echo str_replace('@','_',$user1_email); ?>">Temat:</label>
                    <input type="text" id="subject_<?php echo $user1_email; ?>" name="subject_<?php echo str_replace('@','_',$user1_email); ?>" value="<?php echo htmlspecialchars($defaultSubject, ENT_QUOTES, 'UTF-8'); ?>" required>
                    <br>
                    <label for="message_<?php echo str_replace('@','_',$user1_email); ?>">Treść wiadomości:</label><br>
                    <textarea id="message_<?php echo $user1_email; ?>" name="message_<?php echo str_replace('@','_',$user1_email); ?>" required cols="60" rows="20"><?php echo htmlspecialchars($defaultMessage, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    <br>
                    
                    <h4>Email do: <?php echo htmlspecialchars($user2_email, ENT_QUOTES, 'UTF-8'); ?></h4>
                    <label for="from_<?php echo $user2_phone; ?>">Telefon:</label>
                    <input type="tel" id="from_<?php echo $user2_phone; ?>" name="from_<?php echo $user2_phone; ?>" value="<?php echo htmlspecialchars($user2_phone, ENT_QUOTES, 'UTF-8'); ?>" required><br/>
                    <label for="from_<?php echo str_replace('@','_',$user2_email); ?>">Od:</label>
                    <input type="email" id="from_<?php echo $user2_email; ?>" name="from_<?php echo str_replace('@','_',$user2_email); ?>" value="<?php echo htmlspecialchars($defaultFrom, ENT_QUOTES, 'UTF-8'); ?>" required>
                    <br>
                    <label for="replyTo_<?php echo str_replace('@','_',$user2_email); ?>">Odpowiedz do:</label>
                    <input type="email" id="replyTo_<?php echo $user2_email; ?>" name="replyTo_<?php echo str_replace('@','_',$user2_email); ?>" value="<?php echo htmlspecialchars($defaultReplyTo, ENT_QUOTES, 'UTF-8'); ?>" required>
                    <br>
                    <label for="subject_<?php echo str_replace('@','_',$user2_email); ?>">Temat:</label>
                    <input type="text" id="subject_<?php echo $user2_email; ?>" name="subject_<?php echo str_replace('@','_',$user2_email); ?>" value="<?php echo htmlspecialchars($defaultSubject, ENT_QUOTES, 'UTF-8'); ?>" required>
                    <br>
                    <label for="message_<?php echo str_replace('@','_',$user2_email); ?>">Treść wiadomości:</label><br>
                    <textarea id="message_<?php echo $user2_email; ?>" name="message_<?php echo str_replace('@','_',$user2_email); ?>" required cols="60" rows="20"><?php echo htmlspecialchars($defaultMessage, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    <br>
                </div>
                <hr>
            <?php endforeach; ?>
            <button type="submit" name="mail_init">Wyślij wszystkie wiadomości</button>
        </form>
        
        <a href="admin_panel.php">Wróć</a>
    </div>
</body>
</html>
