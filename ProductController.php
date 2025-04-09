<?php
class ProductController {

    public function index() {
        require_once 'database.php';
        $pdo = Database::getConnection();

        $id_produs = intval($_GET['id']);
$product = $this->getProductById($pdo, $id_produs);
        $reviews = $this->getReviewsByProductId($pdo, $id_produs);

        // Obține rating_count și total_rating pentru produs
        $product_reviews = $this->getProductReviews($pdo, $id_produs);
        $product['rating_count'] = $product_reviews['rating_count'];
        $product['total_rating'] = $product_reviews['total_rating'];

        if (!$product) {
            echo "Produsul nu a fost găsit.";
            exit;
        }

        require 'product_page.php';
    }

    public function addToCart() {
        session_start();

        // Inițializează coșul dacă nu există
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Obține ID-ul și cantitatea produsului
        $product_id = intval($_POST['product_id']);
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

        // Validare: asigură-te că id-ul și cantitatea sunt valide
        if ($product_id <= 0 || $quantity <= 0) {
            header("Location: /product?id=$product_id&error=invalid_input");
            exit();
        }

        // Dacă produsul există deja în coș, actualizăm cantitatea
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }

        // Redirecționează înapoi la pagina produsului
        header("Location: /product?id=$product_id&success=added_to_cart");
        exit();
    }


    public function getProductById($pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getReviewsByProductId($pdo, $id) {
        $stmt = $pdo->prepare("SELECT r.*, u.nume FROM ratings r JOIN users u ON r.user_id = u.id WHERE product_id = ? ORDER BY r.created_at DESC");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductReviews($pdo, $id) {
        $stmt = $pdo->prepare("
            SELECT 
                COUNT(r.id) AS rating_count, 
                SUM(r.rating) AS total_rating 
            FROM ratings r 
            WHERE r.product_id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addReview() {
        session_start();
        if (!isset($_SESSION['user'])) {
            echo "Trebuie să fii logat pentru a adăuga un review.";
            exit;
        }

        require_once 'database.php';
        $pdo = Database::getConnection();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user']['id'];
            $product_id = intval($_POST['product_id']);
            $rating = intval($_POST['rating']);
            $review_text = trim($_POST['review_text']);

            if ($rating < 1 || $rating > 5) {
                echo "Rating invalid!";
                exit;
            }

            $stmt = $pdo->prepare("INSERT INTO ratings (user_id, product_id, rating, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$user_id, $product_id, $rating]);

            header("Location: /product?id=" . $product_id);
            exit();
        }
    }
}
