<?php

class DatabaseConnector {
    private $username;
    private $password;
    private $host;
    private $database;
    private $port;
    private static $instance = null;
    private $connection = null;

    private function __construct()
    {
        $this->username = $_ENV['POSTGRES_USER'];
        $this->password = $_ENV['POSTGRES_PASSWORD'];
        $this->host = 'db'; //name of docker service
        $this->database = $_ENV['POSTGRES_DB'];
        $this->port = $_ENV['DB_PORT'];
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
                    "pgsql:host=$this->host;port=$this->port;dbname=$this->database",
                    $this->username,
                    $this->password
                );

                // Set the PDO error mode to exception
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                header("Location: /public/errors/ErrorDB.php");
                exit;
            }
        }
        return $this->connection;
    }

    public function disconnect()
    {
        $this->connection = null;
    }

    private function __clone() {}

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }
}