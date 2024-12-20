<?php

require_once "config.php";

class DatabaseConnector {
    private $username;
    private $password;
    private $host;
    private $database;
    private static $instance = null;
    private $connection = null;

    private function __construct()
    {
        $this->username = USERNAME;
        $this->password = PASSWORD;
        $this->host = HOST;
        $this->database = DATABASE;
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new DatabaseConnector();
        }
        return self::$instance;
    }

    public function connect()
    {
        if ($this->connection === null) {
            try {
                $this->connection = new PDO(
                    "pgsql:host=$this->host;port=5432;dbname=$this->database",
                    $this->username,
                    $this->password
                );

                // Set the PDO error mode to exception
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                // TODO: error page redirect
                die("Connection failed: " . $e->getMessage());
            }
        }
        return $this->connection;
    }

    // TODO: disconnect()

    private function __clone() {}

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }
}