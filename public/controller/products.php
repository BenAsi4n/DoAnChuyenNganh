<?php
require_once './libraries/Database.php';
$db = new Database();

// Lấy mã loại từ URL
$maloai = isset($_GET['maloai']) ? intval($_GET['maloai']) : 0;

// Truy vấn sản phẩm theo mã loại
if ($maloai > 0) {
    $products = $db->fetchAll('sanpham', "maloai = $maloai");
} else {
    $products = $db->fetchAll('sanpham');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/css/cssUser.css">
    <title>Products</title>
</head>
<body>
    <?php include "./public/component/header.php"; ?>

    <main>
        <section class="featured-products">
            <div class="container">
                <h2>Filtered Products</h2>
                <div class="product-grid">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="product-card">
                                <img src="./public/img/<?php echo htmlspecialchars($product['hinh']); ?>" alt="<?php echo htmlspecialchars($product['tensp']); ?>">
                                <div class="product-info">
                                    <h3><?php echo htmlspecialchars($product['tensp']); ?></h3>
                                    <p><?php echo htmlspecialchars($product['mota']); ?></p>
                                    <div class="price">$<?php echo htmlspecialchars(number_format($product['gia'], 2)); ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No products found for this category.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>

    <?php include "./public/component/footer.php"; ?>
</body>
</html>
