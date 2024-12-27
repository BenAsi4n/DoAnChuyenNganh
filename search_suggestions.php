<?php
require_once './libraries/Database.php';
$db = new Database();

$query = isset($_GET['query']) ? $_GET['query'] : '';

if ($query) {
    $query = "%" . $query . "%";
    $sql = "SELECT * FROM sanpham WHERE tensp LIKE :query LIMIT 5";
    $params = ['query' => $query];
    $results = $db->fetchAll($sql, $params);
    echo json_encode($results);
} else {
    echo json_encode([]);
}
?>
