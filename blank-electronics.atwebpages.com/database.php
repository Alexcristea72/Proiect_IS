<?php
const DB_HOST = 'fdb1030.awardspace.net';
const DB_NAME = '4587943_blank';
const DB_USER = '4587943_blank';
const DB_PASS = 'Alex123!';
class Database {
    private static $host = "fdb1030.awardspace.net";  // Schimbă dacă ai alt hostname
    private static $db_name = "4587943_blank"; // Schimbă cu numele bazei tale de date
    private static $username = "4587943_blank";  // Schimbă dacă ai alt user
    private static $password = "Alex123!";
    private static $conn = null;

    public static function getConnection() {
        if (self::$conn === null) {
            try {
                self::$conn = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$db_name . ";charset=utf8",
                    self::$username,
                    self::$password
                );
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Eroare conexiune BD: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}
?>
