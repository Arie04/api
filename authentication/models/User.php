<?php
class User {
    private $conn;
    private $table_name = "users";

    public $UserId;
    public $Username;
    public $Email;
    public $Password;
    public $IsAdmin;
    public $CreatedAt;

    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function findByUsername() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE Username = :username";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $this->Username);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByEmail() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE Email = :email";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->Email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByUsernameOrEmail() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE Username = :username OR Email = :username";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $this->Username);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByUsernameAndEmail() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE Username = :username OR Email = :email";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $this->Username);
        $stmt->bindParam(":email", $this->Email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (Username, Email, Password) VALUES (:username, :email, :password)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $this->Username);
        $stmt->bindParam(":email", $this->Email);
        $stmt->bindParam(":password", $this->Password);

        return $stmt->execute();
    }

    public function resetPassword(){
        $query = "UPDATE " . $this->table_name . " SET Password = :newPassword WHERE UserId = :userId";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":newPassword", $this->Password);
        $stmt->bindParam(":userId", $this->UserId);
        
        return $stmt->execute();
    }
}
?>
