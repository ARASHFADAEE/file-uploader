<?php

// بارگذاری فایل .env
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();


$servername = $_ENV['DB_HOST'];
$username  = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$dbname=$_ENV['DB_NAME'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=".$dbname, $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    echo "Connected successfully";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

