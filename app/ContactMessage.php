<?php
class ContactMessage {
    private $conn;
    private $table_name = "contact_messages";

    public $id;
    public $name;
    public $email;
    public $message;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    function create() {
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, email=:email, message=:message";
        $stmt = $this->conn->prepare($query);
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->message = htmlspecialchars(strip_tags($this->message));
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":message", $this->message);
        return $stmt->execute();
    }

    function read() {
        $query = "SELECT id, name, email, message, created_at FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>
