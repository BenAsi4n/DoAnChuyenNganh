<?php
require_once './libraries/Database.php';
$db = new Database();

$maloai = isset($_GET['maloai']) ? intval($_GET['maloai']) : 0;

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
    <link rel="shortcut icon" type="image/png" href="./public/img/logo.png">
    <title>DirtyXu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./public/css/style.css">


</head>

<body>
    <?php include "./public/component/header.php"; ?>
    
    <main>
        <section class="slider" aria-label="Image Slider">
            <div class="slide active" style="background-image: url('./public/img/slide1.jpg?height=400&width=1200');"></div>
            <div class="slide" style="background-image: url('./public/img/slide2.jpg?height=400&width=1200');"></div>
            <div class="slide" style="background-image: url('./public/img/slide3.jpg?height=400&width=1200');"></div>
            <div class="slider-nav">
                <button class="active" aria-label="Go to slide 1"></button>
                <button aria-label="Go to slide 2"></button>
                <button aria-label="Go to slide 3"></button>
            </div>
        </section>

        <section class="featured-products">
            <div class="container">
                <h2>All Products</h2>
                <div class="product-grid">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="product-card">
                            <a href="./product_detail.php?masp=<?php echo $product['masp']; ?>">
                                <img class="main-img" src="<?php echo htmlspecialchars($product['hinh']); ?>" alt="<?php echo htmlspecialchars($product['tensp']); ?>">
                                <img class="hover-img" src="<?php echo htmlspecialchars($product['hinh2']); ?>" alt="<?php echo htmlspecialchars($product['tensp']); ?>">
                                <div class="product-info">
                                    <h3><?php echo htmlspecialchars($product['tensp']); ?></h3>
                                    <p><?php echo htmlspecialchars($product['mota']); ?></p>
                                    <div class="price"><?php echo htmlspecialchars(number_format($product['gia'], 0, ',', '.')); ?> đ</div>
                                </div>
                                </a>
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
    <script src="./public/js/ui.js"></script>
</body>

</html>
