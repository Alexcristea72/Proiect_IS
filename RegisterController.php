<?php
require_once 'database.php';

class RegisterController {

    public function showRegistrationForm() {
        require 'register.php';
    }

    public function register() {
        // Obține conexiunea PDO din Database
        $pdo = Database::getConnection();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nume = filter_input(INPUT_POST, 'nume', FILTER_SANITIZE_SPECIAL_CHARS);


            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['parola'];
            $confirmPassword = $_POST['confirm_parola'];
            $data_nastere = $_POST['data_nastere'];
            $oras = filter_input(INPUT_POST, 'oras', FILTER_SANITIZE_SPECIAL_CHARS);
            // Validări de input
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Adresa de email nu este validă!';
                require 'register.php';
                return;
            }
            if ($password !== $confirmPassword) {
                $error = 'Parolele nu se potrivesc!';
                require 'register.php';
                return;
            }
            if (!preg_match("/^[a-zA-Z-' ]*$/", $nume)) {
                $error = 'Numele poate conține doar litere și spații!';
                require 'register.php';
                return;
            }


            $data_nastere_obj = date_create_from_format('Y-m-d', $data_nastere);
            if (!$data_nastere_obj) {
                $error = 'Data nașterii nu este validă!';
                require 'register.php';
                return;
            }

            // Verifică dacă emailul este deja folosit
            $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if ($user) {
                $error = 'Acest email este deja folosit!';
                require 'register.php';
                return;
            }

            // Criptează parola
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Inseră utilizatorul în baza de date
            $stmt = $pdo->prepare('
                INSERT INTO users (nume, oras, data_nastere, email, parola, rol_id)
                VALUES (:nume, :oras, :data_nastere, :email, :parola, :rol_id)
            ');
            $rol_id = 1; // Presupunând că 1 este ID-ul pentru rolul de client
            $stmt->execute([
                ':nume' => $nume,
                ':oras' => $oras,
                ':data_nastere' => $data_nastere,
                ':email' => $email,
                ':parola' => $hashedPassword,
                ':rol_id' => $rol_id
            ]);

            if ($stmt) {
                header('Location: login.php');
                exit();
            } else {
                // În caz de eroare SQL
                $errorMessage = "Eroare SQL: " . $stmt->errorInfo()[2];

                // Trimite eroarea în consola browserului
                echo "<script>console.log(" . json_encode($errorMessage) . ");</script>";

                $error = 'A apărut o eroare la crearea contului. Vă rugăm să încercați din nou.';
                require 'register.php';
            }
        } else {
            require 'register.php';
        }
    }
}
?>
