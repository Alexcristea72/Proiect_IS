<?php
class ProductModel {
    private $db;

    public function __construct() {
        // Connect to the database
        require_once 'database.php';
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->db->connect_error) {
            die("Conexiune eșuată: " . $this->db->connect_error);
        }
    }

    public static function getProductById($id) {
        global $pdo; // Assuming you have a PDO instance globally available
        $stmt = $pdo->prepare('SELECT * FROM products WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}

?>$produs = ProductModel::getProductById($id_produs);
