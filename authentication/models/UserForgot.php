<?php
class UserForgot {
    private $conn;
    private $table_name = "userforgotpassword";

    public $UserForgotId;
    public $UserId;
    public $Code;
    public $IsUsed;
    public $ExpireAt;
    public $CreatedAt;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function forgotPassword() {
        $query = "INSERT INTO " . $this->table_name . " (UserId, Code, ExpireAt) VALUES (:userId, :code, DATE_ADD(CURRENT_TIMESTAMP(), INTERVAL 1 DAY))";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId", $this->UserId);
        $stmt->bindParam(":code", $this->Code);

        return $stmt->execute();
    }

    public function findByCode() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE Code = :code AND ExpireAt > NOW()";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":code", $this->Code);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function useCode() {
        $query = "UPDATE " . $this->table_name . " SET IsUsed = true WHERE Code = :code AND ExpireAt > NOW()";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":code", $this->Code);

        return $stmt->execute();
    }
}