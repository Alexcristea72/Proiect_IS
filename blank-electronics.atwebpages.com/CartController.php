<?php
require_once 'ProductController.php';

class CartController {

    public function index() {
        session_start();

        // Inițializează coșul dacă nu există
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $cartItems = $this->getCartProducts();

        require 'shopping_cart.php';
    }

    public function updateCart() {
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'], $_POST['action'])) {
        $productId = $_POST['product_id'];
        $action = $_POST['action'];

        // Verifică existența produsului ca array
        if (!isset($_SESSION['cart'][$productId]) {
            header('Location: /cart');
            exit;
        }

        // Actualizează cantitatea
        if ($action === 'increase') {
            $_SESSION['cart'][$productId]['quantity']++;
        } elseif ($action === 'decrease') {
            if ($_SESSION['cart'][$productId]['quantity'] > 1) {
                $_SESSION['cart'][$productId]['quantity']--;
            } else {
                unset($_SESSION['cart'][$productId]);
            }
        }

        header('Location: /cart'); // Corectat aici
        exit;
    }




    public function addToCart($productId, $quantity = 1) {
    session_start();

    // Asigură-te că produsul este salvat ca un array
    if (!isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = [
            'id' => $productId,
            'quantity' => 0,
        ];
    }

    // Adaugă cantitatea
    $_SESSION['cart'][$productId]['quantity'] += $quantity;

    header("Location: /shopping_cart.php");
    exit();
}


    private function getCartProducts() {
        require_once 'database.php';
        $pdo = Database::getConnection();

        $productController = new ProductController();
        $cartItems = [];

        foreach ($_SESSION['cart'] as $productId => $quantity) {
            $product = $productController->getProductById($pdo, $productId);
            if ($product) {
                $product['quantity'] = $quantity;
                $cartItems[] = $product;
            }
        }

        return $cartItems;
    }

    public function removeFromCart($productId) {
        session_start();
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }

        header("Location: /cart");
        exit();
    }

    public function clearCart() {
        session_start();
        $_SESSION['cart'] = [];

        header("Location: /cart");
        exit();
    }
}
