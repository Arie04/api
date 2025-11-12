<?php

class UserProfile {
    private $conn;
    private $table_name = "userprofile";

    public $Username;

    public $UserProfileId;
    public $Name;
    public $ProfileImage;
    public $UserId;
    public $CreatedAt;
    public $UpdateAt;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (Name, UserId) VALUES (?, ?)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->Name);
        $stmt->bindParam(2, $this->UserId);

        return $stmt->execute();
    }

    public function getAll() {
        $query = "SELECT u.Username, u.Email, p.* FROM " . $this->table_name . " p
                  JOIN users u ON p.UserId = u.UserId
                  WHERE u.IsAdmin = false";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get() {
        $query = "SELECT u.Username, u.Email, p.* FROM " . $this->table_name . " p
                  JOIN users u ON p.UserId = u.UserId
                  WHERE p.UserId = :userId";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $this->UserId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
/*
    public function getUserHistory() {
        $query = "SELECT p.*, h.* FROM " . $this->table_name . " "
    }
*/
    public function update() {
        $query = "UPDATE " . $this->table_name . " p
                  JOIN users u ON p.UserId = u.UserId
                  SET u.Username = :username, p.Name = :name, p.ProfileImage = :profileImage 
                  WHERE p.UserId = :userId";

        $stmt = $this->conn->prepare($query);        
        $stmt->bindParam(':username', $this->Username);
        $stmt->bindParam(':name', $this->Name);
        $stmt->bindParam(':profileImage', $this->ProfileImage);
        $stmt->bindParam(':userId', $this->UserId);

        return $stmt->execute();
    }
}