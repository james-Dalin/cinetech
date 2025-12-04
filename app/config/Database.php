<?php

declare(strict_types = 1);

class Database {
    
    private $host = 'localhost';
    private $db_name = 'cinetech';
    private $user = 'root';
    private $password = '';
    private $connection;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $this->connection = new mysqli(
            $this->host,
            $this->user,
            $this->password,
            $this->db_name
        );

        if ($this->connection->connect_error) {
            die('Erreur de connexion: ' . $this->connection->connect_error);
        }

        $this->connection->set_charset('utf8mb4');
    }

    public function getConnection() {
        return $this->connection;
    }
}