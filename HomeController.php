<?php
class HomeController {
    public function index() {
        require_once 'database.php';
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        // Obține toate produsele (fără limită pentru demo)
        $products = $this->getAllProducts($conn);
        
        // Verifică dacă este cerere AJAX
        if (isset($_GET['ajax'])) {
            header('Content-Type: application/json');
            echo json_encode($products);
            exit;
        }

        $isLoggedIn = isset($_SESSION['user_id']);
        $cartCount = $isLoggedIn ? $this->getCartCount($conn, $_SESSION['user_id']) : 0;
        
        require 'home.php';
    }

    private function getAllProducts($conn) {
        $stmt = $conn->prepare("
            SELECT 
                p.*, 
                COALESCE(COUNT(r.id), 0) AS rating_count, 
                COALESCE(SUM(r.rating), 0) AS total_rating
            FROM products p
            LEFT JOIN ratings r ON p.id = r.product_id
            GROUP BY p.id
        ");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    private function getCartCount($conn, $userId) {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM cart WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_row()[0];
    }
}
?>