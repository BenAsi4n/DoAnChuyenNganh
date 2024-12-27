<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
require_once './libraries/Database.php';

$db = new Database();


if (isset($_SESSION['id_user'])) {
    $user_id = $_SESSION['id_user'];
    
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $check_query = "SELECT * FROM giohang WHERE user_id = ? AND sanpham_id = ? AND detail = ?";
            $stmt = $db->link->prepare($check_query);
            $stmt->bind_param("iis", $user_id, $item['sanpham_id'], $item['detail']);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Nếu sản phẩm đã có trong giỏ hàng của người dùng, cập nhật số lượng
                $update_query = "UPDATE giohang SET soluong = soluong + ? WHERE user_id = ? AND sanpham_id = ? AND detail = ?";
                $update_stmt = $db->link->prepare($update_query);
                $update_stmt->bind_param("iiis", $item['soluong'], $user_id, $item['sanpham_id'], $item['detail']);
                $update_stmt->execute();
            } else {
                // Nếu sản phẩm chưa có trong giỏ hàng của người dùng, thêm vào giỏ hàng
                $insert_query = "INSERT INTO giohang (user_id, sanpham_id, soluong, detail) VALUES (?, ?, ?, ?)";
                $insert_stmt = $db->link->prepare($insert_query);
                $insert_stmt->bind_param("iiis", $user_id, $item['sanpham_id'], $item['soluong'], $item['detail']);
                $insert_stmt->execute();
            }
        }
        
        unset($_SESSION['cart']);
        

    }
    $sql = "SELECT g.id, g.sanpham_id, g.soluong, g.detail, s.tensp, s.gia, s.hinh
        FROM giohang g
        INNER JOIN sanpham s ON g.sanpham_id = s.masp
        WHERE g.user_id = ?";
        $stmt = $db->link->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $cart_items = $result->fetch_all(MYSQLI_ASSOC);
}
else if(!isset($_SESSION['id_user'])){
    $cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

}



?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="./public/img/logo.png">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="./public/css/cart.css">
</head>
<body>
<?php include "./public/component/header.php"; ?>

<div class="container_cart">
    <div class="cart-section">
        <h2>Giao Hàng</h2>
        <?php if (!empty($cart_items)): ?>
        <div class="cart-header">
            <label>
                <input type="checkbox" id="select-all" checked> Chọn tất cả
            </label>
        </div>

        <?php
        $total_amount = 0;
        foreach ($cart_items as $item):
            $subtotal = $item['gia'] * $item['soluong'];
            $total_amount += $subtotal;
        ?>
        <div class="cart-item">
            <input type="checkbox" class="item-checkbox" data-id="<?php echo $item['id']; ?>" checked>
            <img class="product-image" src="<?php echo htmlspecialchars($item['hinh']); ?>" alt="Hình sản phẩm" data-id="<?php echo $item['id']; ?>">

            <div class="product-info" >
                
                <h3 class="product_name" data-id="<?php echo $item['id']; ?>"><?php echo htmlspecialchars($item['tensp']); ?></h3>
                <p class="product_id" data-id="<?php echo $item['id']; ?>">Mã sản phẩm: <?php echo htmlspecialchars($item['sanpham_id']); ?></p>
                <p class="product_detail" data-id="<?php echo $item['id']; ?>"><?php echo htmlspecialchars($item['detail']); ?></p>
            </div>
            <div class="quantity">
                <button class="btn-decrease" data-id="<?php echo $item['id']; ?>">-</button>
                <input type="text" class="quantity-input" data-id="<?php echo $item['id']; ?>" value="<?php echo $item['soluong']; ?>">
                <button class="btn-increase" data-id="<?php echo $item['id']; ?>">+</button>
            </div>
            <button class="remove-btn" data-id="<?php echo $item['id']; ?>">🗑</button>

            <strong class="item-total" data-price="<?php echo $item['gia']; ?>" data-id="<?php echo $item['id']; ?>"><?php echo number_format($subtotal, 0, ',', '.') . "đ"; ?></strong>
        </div>
        <?php endforeach; ?>

        <div class="cart-footer">
            Tổng đơn hàng: <span id="total-amount"><?php echo number_format($total_amount, 0, ',', '.') . "đ"; ?></span>
        </div>
        <?php else: ?>
        <p>Giỏ hàng của bạn đang trống.</p>
    <?php endif; ?>
    </div>

    <div class="summary-section">
        <h3>Tổng đơn hàng</h3>
        <div class="summary-total">
            <span>Tổng đơn hàng</span>
            <span id="summary-total"><?php echo number_format($total_amount, 0, ',', '.') . "đ"; ?></span>
        </div>
        <div class="summary-buttons">
            <button class="checkout">THANH TOÁN</button>
            <button class="continue" onclick="location.href='./index.php'">TIẾP TỤC MUA SẮM</button>
        </div>
    </div>
</div>

<?php include "./public/component/footer.php"; ?>
<script src="./public/js/cart.js"></script>

<script>
    
// Lắng nghe sự kiện khi chọn hoặc bỏ chọn "Chọn tất cả"
document.getElementById('select-all').addEventListener('change', function() {
    let checkboxes = document.querySelectorAll('.item-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    updateTotal();
});

// Lắng nghe sự kiện khi chọn hoặc bỏ chọn từng sản phẩm
document.querySelectorAll('.item-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        // Cập nhật trạng thái checkbox "Chọn tất cả"
        let allCheckboxes = document.querySelectorAll('.item-checkbox');
        let selectAllCheckbox = document.getElementById('select-all');
        selectAllCheckbox.checked = Array.from(allCheckboxes).every(cb => cb.checked);

        updateTotal();
    });
});

// Lắng nghe sự kiện tăng hoặc giảm số lượng sản phẩm
document.querySelectorAll('.btn-increase, .btn-decrease').forEach(button => {
    button.addEventListener('click', function() {
        let itemId = this.getAttribute('data-id');
        let quantityInput = document.querySelector(`.quantity-input[data-id="${itemId}"]`);
        let quantity = parseInt(quantityInput.value);

        // Xử lý tăng hoặc giảm số lượng
        if (this.classList.contains('btn-increase')) {
            quantity++;
        } else if (this.classList.contains('btn-decrease') && quantity > 1) {
            quantity--;
        }

        // Cập nhật số lượng trong input
        quantityInput.value = quantity;

        // Cập nhật tổng tiền
        updateTotal();
    });
});
document.querySelector('.checkout').addEventListener('click', function () {
    <?php if (!isset($_SESSION['id_user'])): ?>
        // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
        window.location.href = './public/modules/login/login.php';
    <?php else: ?>
    let selectedItems = [];
    let checkboxes = document.querySelectorAll('.item-checkbox');

    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            let itemId = checkbox.getAttribute('data-id');
            let quantity = document.querySelector(`.quantity-input[data-id="${itemId}"]`).value;
            let detailElement = document.querySelector(`.product_detail[data-id="${itemId}"]`);
            let priceElement = document.querySelector(`.item-total[data-id="${itemId}"]`);
            let nameElement = document.querySelector(`.product_name[data-id="${itemId}"]`);
            let imageElement = document.querySelector(`.product-image[data-id="${itemId}"]`);
            let sanphamId = document.querySelector(`.product_id[data-id="${itemId}"]`).innerText.replace('Mã sản phẩm: ', '').trim();

            let detail = detailElement ? detailElement.innerText : '';  // Kiểm tra xem phần tử có tồn tại không
            let price = priceElement ? priceElement.getAttribute('data-price') : 0;
            let name = nameElement ? nameElement.innerText : '';
            let image = imageElement ? imageElement.src : '';


            selectedItems.push({
                id: itemId,
                sanpham_id: sanphamId,
                name: name,
                detail: detail,
                quantity: quantity,
                price: price,
                image: image,
            });
        }
    });

    // Chuyển đổi mảng thành JSON và đặt vào input ẩn
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = './delivery.php';

    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'selectedItems';
    input.value = JSON.stringify(selectedItems);

    form.appendChild(input);
    document.body.appendChild(form);

    form.submit();
    <?php endif; ?>
});


// Cập nhật tổng tiền của các sản phẩm được chọn
function updateTotal() {
    let checkboxes = document.querySelectorAll('.item-checkbox');
    let total = 0;

    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            let itemId = checkbox.getAttribute('data-id');
            let quantity = document.querySelector(`.quantity-input[data-id="${itemId}"]`).value;
            let price = parseFloat(document.querySelector(`.item-total[data-id="${itemId}"]`).getAttribute('data-price'));
            total += price * quantity;
        }
    });

    // Hiển thị tổng tiền
    document.getElementById('total-amount').innerText = total.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ',') + 'đ';
    document.getElementById('summary-total').innerText = document.getElementById('total-amount').innerText;
}



</script>

</body>
</html>
