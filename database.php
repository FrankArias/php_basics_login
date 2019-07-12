<?php
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'php_login_database';

try {
    $conn = new PDO("mysql:host=$server;dbname=$database;",$username, $password);

} catch (PDOExeption $e) {
    die('Connected failed: '.$e->getMessage());
}

?>