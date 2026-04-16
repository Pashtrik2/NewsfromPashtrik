<?php
class News {
    private $conn;
    private $table_name = "news";

    public $id;
    public $title;
    public $content;
    public $image;
    public $created_by;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create news
    function create() {
        $query = "INSERT INTO " . $this->table_name . " SET title=:title, content=:content, image=:image, created_by=:created_by";

        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->image = htmlspecialchars(strip_tags($this->image));
        $this->created_by = htmlspecialchars(strip_tags($this->created_by));

        // bind values
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":content", $this->content);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":created_by", $this->created_by);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Read all news
    function read() {
        $query = "SELECT id, title, content, image, created_by, created_at FROM " . $this->table_name . " ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Read one news
    function readOne() {
        $query = "SELECT id, title, content, image, created_by, created_at FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->title = $row['title'];
        $this->content = $row['content'];
        $this->image = $row['image'];
        $this->created_by = $row['created_by'];
        $this->created_at = $row['created_at'];
    }

    // Update news
    function update() {
        $query = "UPDATE " . $this->table_name . " SET title = :title, content = :content, image = :image WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->image = htmlspecialchars(strip_tags($this->image));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind values
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":content", $this->content);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Delete news
    function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Display news dynamically (returns HTML)
    function displayNews() {
        $query = "SELECT id, title, content, image, created_by, created_at FROM " . $this->table_name . " ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $output = "";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $output .= "<div class='news-item'>";
            $output .= "<h2>" . $row['title'] . "</h2>";
            if ($row['image']) {
                $output .= "<img src='" . $row['image'] . "' alt='News Image' />";
            }
            $output .= "<p>" . $row['content'] . "</p>";
            $output .= "<small>Created by: " . $row['created_by'] . " on " . $row['created_at'] . "</small>";
            $output .= "</div>";
        }

        return $output;
    }
}
?>
