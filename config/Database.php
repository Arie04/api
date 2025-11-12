<?php

class Database
{
    private $host = "localhost";
    private $db_name = "spk_database";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->exec("set names utf8");

            // Set timezone ke WIB
            $this->conn->exec("SET time_zone = '+9:00';");
        } catch (PDOException $exception) {
            //return BaseResponse::error($exception->getMessage());
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
