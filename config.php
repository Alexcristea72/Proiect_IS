<?php
// Inițializează sesiunea
session_start();

// Setări generale ale aplicației
define("BASE_URL", "http://localhost/blank_electronics");  // Schimbă dacă ai alt URL

// Activare raportare erori în modul dev (dezactivează în producție)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include conexiunea la BD
require_once 'database.php';
?>
