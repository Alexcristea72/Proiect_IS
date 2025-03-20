<?php
require_once 'database.php';
session_start();

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($request) {
    case '/':
    case '/home':
        require_once 'HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;
    case '/product':
        require_once 'ProductController.php';
        $controller = new ProductController();
        $controller->index();
        break;
    case '/login':
        require_once 'LoginController.php';
        $controller = new LoginController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->login();
        } else {
            $controller->showLoginForm();
        }
        break;
    case '/add-review':
        require_once 'ProductController.php';
        $controller = new ProductController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->addReview();
        }
        break;
    case '/logout':
        require_once 'LoginController.php';
        $controller = new LoginController();
        $controller->logout();
        break;
    case '/register':
        require_once 'RegisterController.php';
        $controller = new RegisterController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->register();
        } else {
            $controller->showRegistrationForm();
        }
        break;
    case '/cart':
        require_once 'CartController.php';
        $controller = new CartController();
        $controller->index();
        break;

    case '/update-cart':
        require_once 'CartController.php';
        $controller = new CartController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->updateCart();
        }
        break;


    case '/add-to-cart':
        require_once 'CartController.php';
        $controller = new CartController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = intval($_POST['product_id']);
            $quantity = intval($_POST['quantity'] ?? 1);
            $controller->addToCart($productId, $quantity);
        }
        break;

    case '/remove-from-cart':
        require_once 'CartController.php';
        $controller = new CartController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = intval($_POST['product_id']);
            $controller->removeFromCart($productId);
        }
        break;

    case '/clear-cart':
        require_once 'CartController.php';
        $controller = new CartController();
        $controller->clearCart();
        break;

    default:
        http_response_code(404);
        require_once '404.php';
        break;
}