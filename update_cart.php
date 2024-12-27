<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once './libraries/Database.php';

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']); 
    $action = $_POST['action'];

    // Lấy số lượng hiện tại
    $cart_item = $db->fetchOne("giohang", "id = {$id}");

    if ($cart_item) {
        $current_quantity = $cart_item['soluong'];

        if ($action === "increase") {
            $new_quantity = $current_quantity + 1;
            $db->update("giohang", ["soluong" => $new_quantity], ["id" => $id]);
        } elseif ($action === "decrease") {
            $new_quantity = $current_quantity - 1;
            if ($new_quantity > 0) {
                $db->update("giohang", ["soluong" => $new_quantity], ["id" => $id]);
            } else {
                $db->delete("giohang", "id = {$id}");
            }
        } elseif ($action === "delete") {
            $db->delete("giohang", "id = {$id}");
        }
        echo "success";
    } else {
        echo "error";
    }
}
?>
