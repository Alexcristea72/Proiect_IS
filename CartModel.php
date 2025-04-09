<?php
class CartModel {
    private $db;

    public function __construct() {
        require_once 'database.php';
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->db->connect_error) {
            die("Conexiune eșuată: " . $this->db->connect_error);
        }
    }

    public function getCartCount($userId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) AS count FROM cart WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['count'];
    }
}