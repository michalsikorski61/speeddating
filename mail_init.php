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
    $db->logActivity(null, 'Ktoś próbował wejść na stronę admin_panel.php bez logowania .');
    header('Location: index.php');
    exit;
}

//here we will add the admin panel about mails to pared users

?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel Administratora</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        body {
            background-color: #333;
        }
        form{
            background-color: #888;
        }
        h1{
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>content</h1>
        
    </div>
        
</body>
</html>
