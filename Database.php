<?php
class Database {
    private $pdo;
    private $error;
    private $stmt;

    public function __construct() {
        $config = require 'dbconfig.php';
        $db = $config['database'];

        $dsn = "mysql:host={$db['host']};dbname={$db['name']};charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $db['username'], $db['password'], $options);
        } catch (PDOException $e) {
            $this->logError($e->getMessage());
            die("Wystąpił błąd połączenia z bazą danych. Spróbuj ponownie później.");
        }
    }

    public function query($sql) {
        $this->stmt = $this->pdo->prepare($sql);
    }

    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute() {
        try {
            return $this->stmt->execute();
        } catch (PDOException $e) {
            $this->logError($e->getMessage());
            return false;
        }
    }

    public function resultset() {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    public function single() {
        $this->execute();
        return $this->stmt->fetch();
    }

    public function rowCount() {
        return $this->stmt->rowCount();
    }

    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }

    public function getError() {
        return $this->error;
    }

    // Funkcja do logowania operacji
    public function logActivity($user_id, $action) {
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $this->query("INSERT INTO logs (user_id, action, ip_address) VALUES (:user_id, :action, :ip_address)");
        $this->bind(':user_id', $user_id);
        $this->bind(':action', $action);
        $this->bind(':ip_address', $ip_address);
        $this->execute();
    }

    // Funkcja do logowania nieudanego logowania
    public function logFailedLogin($email) {
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $this->query("INSERT INTO logs (user_id, action, ip_address) VALUES (NULL, :action, :ip_address)");
        $this->bind(':action', "Nieudane logowanie - Email: $email");
        $this->bind(':ip_address', $ip_address);
        $this->execute();
    }

    // Funkcja do logowania błędów
    private function logError($error) {
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $this->query("INSERT INTO logs (user_id, action, ip_address) VALUES (NULL, :action, :ip_address)");
        $this->bind(':action', "Błąd: $error");
        $this->bind(':ip_address', $ip_address);
        $this->execute();
    }
}
?>
