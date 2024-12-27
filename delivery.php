<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once './libraries/Database.php';
$errors = [];
$submitted = false;
$selectedItems = json_decode($_POST['selectedItems'] ?? '[]', true);

if (!empty($selectedItems)) {
    foreach ($selectedItems as $item) {
        $cartItems[] = [
            'id' => htmlspecialchars($item['id']),
            'sanpham_id' => $item['sanpham_id'],
            'name' => htmlspecialchars($item['name']),
            'detail' => htmlspecialchars($item['detail']),
            'quantity' => (int) $item['quantity'],
            'price' => (float) $item['price'],
            'image' => htmlspecialchars($item['image']),
        ];
    }
    
} else {
    $cartItems = [];
}
// echo json_encode($cartItems);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_order'])) {
    $submitted = true;

    $lastName = trim($_POST['last_name'] ?? '');
    $firstName = trim($_POST['first_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $district = trim($_POST['district'] ?? '');
    $ward = trim($_POST['ward'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $ngaydat = date("Y-m-d H:i:s");
    $tinhtrang = "Chờ xác nhận";
    $total_p=intval($_POST['total_price_order']??0);
    if (isset($_SESSION['id_user'])) {
        $user_id = $_SESSION['id_user'];
    }
    if (empty($lastName)) {
        $errors['last_name'] = "Họ là bắt buộc.";
    }

    if (empty($firstName)) {
        $errors['first_name'] = "Tên là bắt buộc.";
    }

    if (empty($phone) || !preg_match('/^\+?[0-9\s-]{10,15}$/', $phone)) {
        $errors['phone'] = "Số điện thoại không hợp lệ.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email không hợp lệ.";
    }

    if (empty($city)) {
        $errors['city'] = "Tỉnh/Thành phố là bắt buộc.";
    }

    if (empty($district)) {
        $errors['district'] = "Quận/Huyện là bắt buộc.";
    }

    if (empty($ward)) {
        $errors['ward'] = "Phường/Xã là bắt buộc.";
    }

    if (empty($address)) {
        $errors['address'] = "Địa chỉ là bắt buộc.";
    }


    if (empty($errors)) {
        $hoadon = [
            'id_user' => $user_id,
            'hoten' => $firstName ." ". $lastName,
            'diachinhan' => $address .",". $district .",". $ward .",". $city,
            'sdt' => $phone,
            'tongtien' => $total_p,
            'ngaydat' => $ngaydat,
            'tinhtrang' => $tinhtrang,
        ];
        $db = new Database();
        $insert_hoadon=$db->insert('hoadon', $hoadon);
        if ($insert_hoadon) {
            $hoadon_id = $db->lastInsertId();

            foreach ($cartItems as $item) {
                $sanpham_id = $item['sanpham_id'];
                $soluong = $item['quantity'];
                $tongtien = $item['price'] * $soluong;
                $description = $item['detail'];

                $chitiethoadon = [
                    'id_hoadon' => $hoadon_id,
                    'masp' => $sanpham_id,
                    'soluong' => $soluong,
                    'gia' => $tongtien,
                    'description' => $description,
                ];

                $insert_chitiethoadon = $db->insert('chitiethoadon', $chitiethoadon);
                if ($insert_chitiethoadon) {
                    $delete_query = "DELETE FROM giohang WHERE user_id = ? AND sanpham_id = ? AND detail = ?";
                    $delete_stmt = $db->link->prepare($delete_query);
                    $delete_stmt->bind_param("iis", $user_id, $sanpham_id, $item['detail']);
                    $delete_stmt->execute();
                }
            }
            if ($insert_chitiethoadon) {
                echo "<script>
                    alert('Đặt hàng thành công!');
                    window.location.href = 'my_orders.php';
                </script>";
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Không thể thêm vào hóa đơn.']);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="./public/img/logo.png">
    <title>DirtyXu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./public/css/delivery.css">

</head>
<body>
    <?php include "./public/component/header.php"; ?>
    <form action="delivery.php" method="POST">
    <input type="hidden" name="selectedItems" value="<?php echo htmlspecialchars(json_encode($cartItems)); ?>">
        <div class="container_delivery">
            <!-- Thông tin giao hàng -->
            <div class="left-section">
            <h3>Thông tin giao hàng</h3>
            <input type="text" name="last_name" placeholder="Họ" value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>">
            <p class="error"><?php echo $errors['last_name'] ?? ''; ?></p>

            <input type="text" name="first_name" placeholder="Tên" value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>">
            <p class="error"><?php echo $errors['first_name'] ?? ''; ?></p>

            <input type="text" name="phone" placeholder="Số điện thoại" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
            <p class="error"><?php echo $errors['phone'] ?? ''; ?></p>

            <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
            <p class="error"><?php echo $errors['email'] ?? ''; ?></p>

            <input type="text" name="city" placeholder="Tỉnh/Thành phố" value="<?php echo htmlspecialchars($_POST['city'] ?? ''); ?>">
                <p class="error"><?php echo $errors['city'] ?? ''; ?></p>

                <input type="text" name="district" placeholder="Quận/Huyện" value="<?php echo htmlspecialchars($_POST['district'] ?? ''); ?>">
                <p class="error"><?php echo $errors['district'] ?? ''; ?></p>

                <input type="text" name="ward" placeholder="Phường/Xã" value="<?php echo htmlspecialchars($_POST['ward'] ?? ''); ?>">
                <p class="error"><?php echo $errors['ward'] ?? ''; ?></p>

            <input type="text" name="address" placeholder="Tòa nhà, số nhà, tên đường" value="<?php echo htmlspecialchars($_POST['address'] ?? ''); ?>">
            <p class="error"><?php echo $errors['address'] ?? ''; ?></p>

            <textarea name="details" placeholder="Chi tiết địa chỉ"><?php echo htmlspecialchars($_POST['details'] ?? ''); ?></textarea>
            </div>

            <!-- Thông tin đơn hàng -->
            <div class="right-section">
                <h3>Đơn hàng</h3>
                <?php if (!empty($cartItems)): ?>
                    <?php foreach ($cartItems as $item): ?>
                        <div class="product">
                        <img class="image" src="<?php echo $item['image']; ?>" alt="Product Image">
                            <div>
                                <strong class="name"><?php echo $item['name']; ?></strong>
                                <p class="detail"><?php echo $item['detail']; ?></p>
                                <div class="product_qt">
                                    <p class="quantity">Số lượng:<?php echo $item['quantity']; ?></p>
                                    <p class="total-price"><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.') . 'đ'; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <hr>

                    <div class="price-summary">
                        <p><span>Tổng giá trị đơn hàng</span> <span><?php echo number_format(array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cartItems)), 0, ',', '.') . 'đ'; ?></span></p>
                        <p><span>Phí vận chuyển</span> <span>20.000đ</span></p>
                        <p><strong>Thành tiền</strong> 
   <strong><?php 
       $totalPrice = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cartItems)) + 20000;
       echo number_format($totalPrice, 0, ',', '.') . 'đ'; 
   ?></strong>
</p>
<input type="hidden" name="total_price_order" value="<?php echo $totalPrice; ?>">
                    </div>
                <?php endif; ?>

                <button class="btn_dathang" type="submit" name="submit_order">Đặt hàng</button>
            </div>
        </div>
    </form>
    <?php if ($submitted && empty($errors)): ?>
        <p style="color: green;"><?php echo $message; ?></p>
    <?php endif; ?> 
    <?php include "./public/component/footer.php"; ?>

</body>
</html>
