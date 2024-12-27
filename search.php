<?php
require_once './libraries/Database.php';
$db = new Database();

if (isset($_GET['query'])) {
    $query = mysqli_real_escape_string($db->link, $_GET['query']);
    $sql = "SELECT * FROM sanpham WHERE tensp LIKE '%$query%' LIMIT 5";
    $result = mysqli_query($db->link, $sql);

    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
    echo json_encode($products);
}
?>
