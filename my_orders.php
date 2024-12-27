<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once './libraries/Database.php';
$db = new Database();

if (isset($_SESSION['id_user'])) {
    $user_id = $_SESSION['id_user'];

    $sql = "SELECT h.id_hoadon, h.tinhtrang, h.ngaydat, s.tensp, s.hinh, c.description, c.gia, c.soluong
            FROM chitiethoadon c
            INNER JOIN hoadon h ON c.id_hoadon = h.id_hoadon
            INNER JOIN sanpham s ON s.masp = c.masp
            WHERE h.id_user = ?
            ORDER BY h.ngaydat DESC";

    $stmt = $db->link->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $orders = [];

    // Nhóm sản phẩm theo id_hoadon
    while ($row = $result->fetch_assoc()) {
        $orders[$row['id_hoadon']]['tinhtrang'] = $row['tinhtrang'];
        $orders[$row['id_hoadon']]['ngaydat'] = $row['ngaydat'];
        $orders[$row['id_hoadon']]['products'][] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Summary</title>
    <link rel="stylesheet" href="./public/css/myorders.css">
</head>
<body>
<?php include "./public/component/header.php"; ?>

<div class="container_my_order">
    <div class="header_myorder">Đơn hàng</div>

    <?php if (!empty($orders)): ?>
        <?php foreach ($orders as $order_id => $order): ?>
            <div class="order">
                <div class="order-header">
                    <div class="order-id">Mã đơn hàng: <?= htmlspecialchars($order_id) ?></div>
                    <div class="order-date">Ngày đặt: <?= htmlspecialchars($order['ngaydat']) ?></div>
                    <div class="order-status <?= $order['tinhtrang'] === 'Chờ xác nhận' ? 'pending' : 'completed' ?>">
                        <?= htmlspecialchars($order['tinhtrang']) ?>
                    </div>
                </div>
                <div class="order-products">
                    <?php foreach ($order['products'] as $product): ?>
                        <div class="product-item">
                            <img class="image" src="<?= htmlspecialchars($product['hinh']) ?>" alt="<?= htmlspecialchars($product['tensp']) ?>">
                            <div class="product-details">
                                <div class="name"><?= htmlspecialchars($product['tensp']) ?></div>
                                <div class="description"><?= htmlspecialchars($product['description']) ?></div>
                                <div class="price">đ <?= number_format($product['gia'], 0, ',', '.') ?></div>
                                <div class="quantity">Số lượng: <?= htmlspecialchars($product['soluong']) ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Nút hủy đơn hàng -->
                <?php if ($order['tinhtrang'] === 'Chờ xác nhận'): ?>
                    <form method="POST" action="delete_order.php" class="cancel-form">
                        <input type="hidden" name="order_id" value="<?= htmlspecialchars($order_id) ?>">
                        <button type="submit" class="cancel-button">Hủy đơn hàng</button>
                    </form>
                <?php else: ?>
                    <div class="no-cancel">Không thể hủy đơn hàng.</div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="no-items">Bạn chưa có đơn hàng nào.</div>
    <?php endif; ?>
</div>

<?php include "./public/component/footer.php"; ?>

</body>
</html>
