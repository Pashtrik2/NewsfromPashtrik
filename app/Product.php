<?php
class Product {
    private $conn;
    private $table_name = "products";

    public $id;
    public $name;
    public $description;
    public $price;
    public $image;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create product
    function create() {
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, description=:description, price=:price, image=:image";
        $stmt = $this->conn->prepare($query);
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->image = htmlspecialchars(strip_tags($this->image));
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":image", $this->image);
        return $stmt->execute();
    }

    // Read all products
    function read() {
        $query = "SELECT id, name, description, price, image, created_at FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Read one product
    function readOne() {
        $query = "SELECT id, name, description, price, image, created_at FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->name = $row['name'];
        $this->description = $row['description'];
        $this->price = $row['price'];
        $this->image = $row['image'];
        $this->created_at = $row['created_at'];
    }

    // Update product
    function update() {
        $query = "UPDATE " . $this->table_name . " SET name = :name, description = :description, price = :price, image = :image WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->image = htmlspecialchars(strip_tags($this->image));
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }

    // Delete product
    function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        return $stmt->execute();
    }

    // Display products dynamically (returns HTML)
    function displayProducts() {
        $query = "SELECT id, name, description, price, image, created_at FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $output = "";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $output .= "<div class='product-item'>";
            $output .= "<h3>" . $row['name'] . "</h3>";
            if ($row['image']) {
                $output .= "<img src='" . $row['image'] . "' alt='Product Image' />";
            }
            $output .= "<p>" . $row['description'] . "</p>";
            $output .= "<strong>Price: $" . number_format($row['price'], 2) . "</strong><br>";
            $output .= "<small>Added: " . $row['created_at'] . "</small>";
            $output .= "</div>";
        }
        return $output;
    }
}
?>
