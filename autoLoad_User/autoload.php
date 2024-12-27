<?php
$servername = "localhost"; // Tên máy chủ (thường là localhost)
$username = "root";        // Tên người dùng MySQL
$password = "";            // Mật khẩu MySQL
$dbname = "db_webquanao";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại!");
}
$conn->set_charset("utf8");
session_start();
require_once __DIR__ . "/../libraries/Database.php";
require_once __DIR__ . "/../libraries/Function.php";
$db = new Database;
define("ROOT_IMG", $_SERVER['DOCUMENT_ROOT'] . "/Web_QuanAo/public/img/");
define('ROOT', dirname(__DIR__));
