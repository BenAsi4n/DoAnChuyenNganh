<?php
require_once './libraries/Database.php';
$db = new Database();

$masp = isset($_GET['masp']) ? intval($_GET['masp']) : 0;

$product = $db->fetchOne('sanpham', "masp = $masp");
if (!$product) {
    die("Sản phẩm không tồn tại.");
}
$sizes = $db->fetchAll('sanpham_kichthuoc');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="./public/img/logo.png">
    <title><?php echo htmlspecialchars($product['tensp']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./public/css/product_detail.css">
    <style>
        .button-container {
            display: flex;
            gap: 10px;
            padding-bottom: 10px;
        }

        .select-button {
            width: 30px;
            height: 30px;
            border: 2px solid #ddd;
            border-radius: 4px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            user-select: none;
            transition: border-color 0.2s ease-in-out;
        }

        .select-button.active {
            border: 2px solid #000;
        }

        .color-button {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid #ddd;
            transition: border-color 0.2s ease-in-out;
        }

        .color-button.black {
            background-color: #000;
        }

        .color-button.white {
            background-color: #fff;
            border: 2px solid #ccc;
        }

        .color-button.beige {
            background-color: #f5f5dc;
        }

        .color-button.active {
            border: 2px solid #000;
        }
    </style>
</head>
<body>
    <?php include "./public/component/header.php"; ?>

    <div class="product-page">
        <!-- Hình ảnh sản phẩm -->
        <div class="product-images">
            <img src="<?php echo htmlspecialchars($product['hinh']); ?>" alt="<?php echo htmlspecialchars($product['tensp']); ?>" class="main-img">
            <div class="thumbnails">
                <?php if (!empty($product['hinh2'])): ?>
                    <img src="<?php echo htmlspecialchars($product['hinh2']); ?>" alt="Thumbnail 2">
                <?php endif; ?>
                <?php if (!empty($product['hinh3'])): ?>
                    <img src="<?php echo htmlspecialchars($product['hinh3']); ?>" alt="Thumbnail 3">
                <?php endif; ?>
                <?php if (!empty($product['hinh4'])): ?>
                    <img src="<?php echo htmlspecialchars($product['hinh4']); ?>" alt="Thumbnail 4">
                <?php endif; ?>
            </div>

        </div>

        <!-- Thông tin sản phẩm -->
        <div class="product-info">
            <h1 class="product_tensp"><?php echo htmlspecialchars($product['tensp']); ?></h1>
            <p class="price"><?php echo htmlspecialchars(number_format($product['gia'], 0, ',', '.')); ?> đ</p>
            <p><?php echo htmlspecialchars($product['mota']); ?></p>

            <!-- Nút chọn size -->
            <div class="button-container">
                <?php foreach ($sizes as $index => $size): ?>
                    <div 
                        name="<?php echo htmlspecialchars($size['tenkichthuoc']); ?>" 
                        class="select-button <?php echo $index === 0 ? 'active' : ''; ?>" 
                        onclick="selectButton(event)">
                        <?php echo htmlspecialchars($size['tenkichthuoc']); ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Nút chọn màu -->
            <div class="button-container">
                <div name="black" class="color-button black" onclick="selectColor(event)"></div>
                <div name="white" class="color-button white" onclick="selectColor(event)"></div>
                <div name="beige" class="color-button beige" onclick="selectColor(event)"></div>
            </div>

            <!-- Button Giỏ hàng -->
            <button class="add-to-cart">Thêm vào giỏ hàng</button>
        </div>
        
    </div>

    <?php include "./public/component/footer.php"; ?>
    <script>        
        const productID = "<?php echo $product['masp']; ?>";
    </script>
    <script src="./public/js/product_detail.js"></script>
</body>
</html>
