<?php
class UserToken {
    private $conn;
    private $table_name = "usertokens";

    public $TokenId;
    public $UserId;
    public $Token;
    public $ExpireAt;
    public $CreatedAt;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createToken() {
        $query = "INSERT INTO " . $this->table_name . " (UserId, Token, ExpireAt) VALUES (:userId, :token, DATE_ADD(CURRENT_TIMESTAMP(), INTERVAL 1 DAY))";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId", $this->UserId);
        $stmt->bindParam(":token", $this->Token);

        return $stmt->execute();
    }

    public function findToken() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE Token = :token AND ExpireAt > NOW() AND IsLogout = false";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":token", $this->Token);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserIdByToken() {
        $query = "SELECT UserId FROM " . $this->table_name . " WHERE Token = :token AND ExpireAt > NOW() AND IsLogout = false";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":token", $this->Token);
        $stmt->execute();
        $userId =$stmt->fetch(PDO::FETCH_ASSOC);
        
        return $userId ? $userId['UserId'] : null;
    }

    public function logoutToken() {
        $query = "UPDATE " . $this->table_name . " SET IsLogout = true WHERE Token = :token";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":token", $this->Token);
        
        return $stmt->execute();
    }
}
?>
