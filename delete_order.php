<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once './libraries/Database.php';
$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id']) && isset($_SESSION['id_user'])) {
    $order_id = intval($_POST['order_id']);
    $user_id = $_SESSION['id_user'];

    // Kiểm tra trạng thái đơn hàng
    $sql = "SELECT tinhtrang FROM hoadon WHERE id_hoadon = ? AND id_user = ?";
    $stmt = $db->link->prepare($sql);
    $stmt->bind_param("ii", $order_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();

    if ($order) {
        if (trim($order['tinhtrang']) === 'Chờ xác nhận') {
            // Xóa hóa đơn và chi tiết hóa đơn
            $db->link->begin_transaction();
            try {
                $delete_chitiet = "DELETE FROM chitiethoadon WHERE id_hoadon = ?";
                $stmt = $db->link->prepare($delete_chitiet);
                $stmt->bind_param("i", $order_id);
                $stmt->execute();

                $delete_hoadon = "DELETE FROM hoadon WHERE id_hoadon = ?";
                $stmt = $db->link->prepare($delete_hoadon);
                $stmt->bind_param("i", $order_id);
                $stmt->execute();

                $db->link->commit();
                header("Location: my_orders.php?message=deleted");
                exit;
            } catch (Exception $e) {
                $db->link->rollback();
                die("Error: " . $e->getMessage());
            }
        } else {
            // Không cho phép xóa đơn hàng
            header("Location: my_orders.php?message=cannot_delete");
            exit;
        }
    } else {
        die("Đơn hàng không tồn tại hoặc không thuộc quyền của bạn.");
    }
} else {
    die("Invalid request.");
}
?>
