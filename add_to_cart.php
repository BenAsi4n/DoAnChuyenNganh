<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
require_once './libraries/Database.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$sanpham_id = intval($input['sanpham_id']);
$soluong = intval($input['soluong']);
$detail = $input['detail'];
$tensp = $input['tensp'] ?? '';
$gia = intval($input['gia'] ?? 0);
$hinh = $input['hinh'] ?? '';

if (!$sanpham_id || !$detail) {
    echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ.']);
    exit();
}

$product = [
    'sanpham_id' => $sanpham_id,
    'soluong' => $soluong,
    'detail' => $detail,
    'tensp' => $tensp,
    'gia' => $gia,
    'hinh' => $hinh
];

// Nếu user chưa đăng nhập, lưu vào session
if (!isset($_SESSION['username'])) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Kiểm tra nếu sản phẩm đã tồn tại trong giỏ hàng
    $productExists = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['sanpham_id'] == $sanpham_id && $item['detail'] == $detail) {
            $item['soluong'] += $soluong; // Tăng số lượng sản phẩm
            $productExists = true;
            break;
        }
    }

    if (!$productExists) {
        $_SESSION['cart'][] = $product;
    }
    echo json_encode(['success' => true, 'message' => 'Thêm vào giỏ hàng thành công (Session).']);
    exit();
}

// Nếu đã đăng nhập, lưu vào bảng giohang
$db = new Database();
$user_id = $_SESSION['id_user'];

$check_query = "SELECT soluong FROM giohang WHERE user_id = ? AND sanpham_id = ? AND detail = ?";
$check_stmt = $db->link->prepare($check_query);
$check_stmt->bind_param("iis", $user_id, $sanpham_id, $detail);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $new_quantity = $row['soluong'] + $soluong;

    $update_query = "UPDATE giohang SET soluong = ? WHERE user_id = ? AND sanpham_id = ? AND detail = ?";
    $update_stmt = $db->link->prepare($update_query);
    $update_stmt->bind_param("iiis", $new_quantity, $user_id, $sanpham_id, $detail);

    if ($update_stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Cập nhật số lượng sản phẩm trong giỏ hàng thành công.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Không thể cập nhật giỏ hàng.']);
    }
} else {
    $data = [
        'user_id' => $user_id,
        'sanpham_id' => $sanpham_id,
        'soluong' => $soluong,
        'detail' => $detail,
    ];

    $insert_id = $db->insert('giohang', $data);

    if ($insert_id) {
        echo json_encode(['success' => true, 'message' => 'Thêm vào giỏ hàng thành công.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Không thể thêm vào giỏ hàng.']);
    }
}
?>
