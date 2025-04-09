<?php

require_once "config.php";
require_once "database.php";

$pdo = new PDO(
    'mysql:host=DB_HOST;port=3306;dbname='.$config['db_name'],
    $config['db_user'],
    $config['db_password']
);
// See the "errors" folder for details...
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>