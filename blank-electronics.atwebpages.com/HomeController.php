<?php
class HomeController {
    public function index() {
        // 1. Conectare la baza de date
        require_once 'database.php';
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $limit = 4;

        // 2. Preia produsele cu rating și număr de review-uri
        $products = $this->getFeaturedProductsByLimit($conn, $limit);

        // 3. Verifică autentificarea
        $isLoggedIn = isset($_SESSION['user_id']);

        // 4. Preia numărul de produse din coș
        $cartCount = $isLoggedIn ? $this->getCartCount($conn, $_SESSION['user_id']) : 0;

        // 5. Încarcă View-ul cu variabilele
        require 'home.php';
    }

    private function getFeaturedProductsByLimit($conn, $limit) {
        $stmt = $conn->prepare("
            SELECT 
                p.*, 
                COALESCE(COUNT(r.id), 0) AS rating_count, 
                COALESCE(SUM(r.rating), 0) AS total_rating
            FROM products p
            LEFT JOIN ratings r ON p.id = r.product_id
            GROUP BY p.id
            LIMIT ?
        ");
        $stmt->bind_param("i", $limit);
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
