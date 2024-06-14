<?php
require 'config.php';
require 'Database.php';
//wyłączanie wyświetlania błędów
// error_reporting(0);
//mailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//add smtp
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


$db = new Database();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_id'])) {
    echo "Tutaj cię nie mogę wpuścić. Działanie zostało zgłoszone. Wróć na stronę główną.";
    echo "<a href='index.php'>Wróć</a>";
    $db->logActivity(null, 'Ktoś próbował wejść na stronę mail_send.php bez logowania.');
    header('Location: index.php');
    exit;
}
// var_dump($_POST);

//jeśli przesłano dane metodą post i zawiera klucz mail_init
if (!isset($_POST['mail_init'])) {
    echo "Nieprawidłowe dane przekierowania.";
    exit;
}else{
    // Pobierz dane z przekierowania
    $matches = $_POST['matches'];
    $mail = new PHPMailer(true);
    // echo '<pre>';
    // var_dump($_POST);
    // echo '</pre>';
    // echo '<hr>';
    //sanityzacja danych wejściowych z całej tablicy post
    // echo "Po sanityzacji";
    // echo '<pre>';
    
    // echo '</pre>';
    // echo '<hr>';
    
    try {
        // Konfiguracja serwera SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // serwer smtp google
        $mail->SMTPAuth = true;
        $mail->Username = 'speeddatingwarsztatytaneczne@gmail.com'; // nasz adres email
        $mail->Password = 'ttekcnmxgsmhfrpi'; // hasło do skrzynki email
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // szyfrowanie ssl
        $mail->Port = 465; // port serwera
        
        foreach ($matches as $match) {
            list($user1_phone, $user1_email, $user2_phone, $user2_email) = explode(',', $match);
            $subject1 = filter_var($_POST['subject_' . str_replace('.','_',str_replace('@','_',$user1_email))],FILTER_SANITIZE_SPECIAL_CHARS);
            $body1 = filter_var($_POST['message_' . str_replace('.','_',str_replace('@','_',$user1_email))],FILTER_SANITIZE_SPECIAL_CHARS);
            $subject2 = filter_var($_POST['subject_' . str_replace('.','_',str_replace('@','_',$user2_email))],FILTER_SANITIZE_SPECIAL_CHARS);
            $body2 = filter_var($_POST['message_' . str_replace('.','_',str_replace('@','_',$user2_email))],FILTER_SANITIZE_SPECIAL_CHARS);
            $user1_phone = filter_var($user1_phone, FILTER_SANITIZE_NUMBER_INT);
            $user2_phone = filter_var($user2_phone, FILTER_SANITIZE_NUMBER_INT);
            $user1_email = filter_var($user1_email, FILTER_SANITIZE_EMAIL);
            $user2_email = filter_var($user2_email, FILTER_SANITIZE_EMAIL);

            // $user1_email = 'michalsikorski61@gmail.com';
            // $user2_email = 'michalsikorski61@gmail.com';

            // Wysyłanie e-maila do user1
            $mail->setFrom('speeddatingwarsztatytaneczne@gmail.com');
            $mail->addReplyTo('speeddatingwarsztatytaneczne@gmail.com');
            $mail->addAddress($user1_email);
            $mail->isHTML(true);
            $mail->Subject = $subject1;
            $mail->Body = $body1 . ' ' . $user1_phone . ' ' . $user1_email;
            $mail->send();
            $mail->clearAddresses();

            // Wysyłanie e-maila do user2
            $mail->setFrom('speeddatingwarsztatytaneczne@gmail.com');
            $mail->addReplyTo('speeddatingwarsztatytaneczne@gmail.com');
            $mail->addAddress($user2_email);
            $mail->isHTML(true);
            $mail->Subject = $subject2;
            $mail->Body = $body2 . ' ' . $user2_phone . ' ' . $user2_email;
            $mail->send();
            $mail->clearAddresses();
        }

        echo 'Wszystkie wiadomości zostały wysłane. Sprawdź skrzynkę odbiorczą na mailu.';
    } catch (Exception $e) {
        echo "Wiadomości nie mogły zostać wysłane. Mailer Error: {$mail->ErrorInfo}";
    }
}
//powrót do admn_panel.php
echo '<a href="admin_panel.php">Wróć</a>';
?>
