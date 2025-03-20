<?php
class LoginController {

    public function showLoginForm() {
        require 'login.php';
    }

    public function login() {

        session_start();
        require_once 'database.php'; // asigură-te că ai conectarea corectă la baza de date

        // Obținem conexiunea PDO din Database
        $pdo = Database::getConnection();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = htmlentities($_POST["email"]);
            $password = $_POST['parola'];



            // Căutăm utilizatorul în baza de date
            $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificăm dacă utilizatorul există și dacă parola se potrivește
            if ($user && password_verify($password, $user['parola'])) {
                // Setăm variabilele de sesiune pentru utilizatorul logat
                $_SESSION['user'] = $user;
                header('Location: success.php');
                exit();
            } else {
                // Dacă datele sunt incorecte, setăm un mesaj de eroare
                $error = 'Email sau parolă invalidă!';
                require 'login.php'; // Reîncarcă formularul cu mesajul de eroare
                return;
            }
        } else {

            require 'login.php'; // Dacă nu este POST, doar încarcă formularul de login

        }
    }

    public function logout() {
        session_start();
        session_destroy(); // Închide sesiunea
        header('Location: login.php');
        exit();
    }
}

?>
