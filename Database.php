<?php
class Database {
    private $pdo;
    private $stmt;
    private $error;

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
            $this->error = $e->getMessage();
            echo 'Błąd połączenia: ' . $this->error;
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
            $this->error = $e->getMessage();
            echo 'Błąd wykonania: ' . $this->error;
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
        $this->bind(':user_id', $user_id ? $user_id : null);
        $this->bind(':action', $action);
        $this->bind(':ip_address', $ip_address);

        if (!$this->execute()) {
            echo 'Błąd logowania aktywności: ' . $this->getError();
        } else {
            echo 'Aktywność zalogowana pomyślnie.';
        }
    }

    // Funkcja do logowania nieudanego logowania
    public function logFailedLogin($email) {
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $this->query("INSERT INTO logs (user_id, action, ip_address) VALUES (NULL, :action, :ip_address)");
        $this->bind(':action', "Nieudane logowanie - Email: $email");
        $this->bind(':ip_address', $ip_address);

        if (!$this->execute()) {
            echo 'Błąd logowania nieudanego logowania: ' . $this->getError();
        } else {
            echo 'Nieudane logowanie zalogowane pomyślnie.';
        }
    }
}
?>
