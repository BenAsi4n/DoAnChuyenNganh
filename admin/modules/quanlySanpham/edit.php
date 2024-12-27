<?php
require_once(dirname(dirname(__DIR__)) . "/autoload/autoload.php");

if (isset($_GET['id'])) {
    $id = getInput('id');
    $product = $db->fetchOne("sanpham", "masp = '" . $id . "'");
    if (!$product) {
        die("Không tìm thấy sản phẩm!");
    }
}

// Lấy danh sách loại
$loai = $db->fetchAll("loai");

// Lấy danh sách kích thước
$kichthuoc = $db->fetchAll("sanpham_kichthuoc");

// Lấy số lượng sản phẩm theo kích thước
$soluongData = $db->fetchAll("chitietsanpham", "sanpham_id = '" . $id . "'");
$soluongMap = [];
foreach ($soluongData as $soluongItem) {
    $soluongMap[$soluongItem['kichthuoc_id']] = $soluongItem['soluong'];
}
?>
<h2>Cập nhật sản phẩm</h2>

<div class="product-edit-form">
    <form action="/admin/modules/quanlySanpham/controll.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

        <div class="form-group">
            <label for="tensp">Tên sản phẩm:</label>
            <div class="input-tensp">
                <input type="text" name="tensp" id="tensp" class="input-field" value="<?php echo htmlspecialchars($product['tensp']); ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label for="mota">Mô tả:</label>
            <div class="input-mota">
                <textarea name="mota" id="mota" class="input-field" rows="4" required><?php echo htmlspecialchars($product['mota']); ?></textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="gia">Giá (VNĐ):</label>
            <div class="input-gia">
                <input type="number" name="gia" id="gia" class="input-field" value="<?php echo htmlspecialchars($product['gia']); ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label for="hinh">Hình ảnh:</label>
            <div class="input-hinh">
                <input type="file" name="hinh" id="hinh" class="input-field" accept="image/*">
                <p>Hình hiện tại: <?php echo htmlspecialchars($product['hinh']); ?></p>
                <input type="hidden" name="hinh_cu" value="<?php echo htmlspecialchars($product['hinh']); ?>">
        
                <input type="file" name="hinh2" id="hinh2" class="input-field" accept="image/*">
                <input type="hidden" name="hinh2_cu" value="<?php echo htmlspecialchars($product['hinh2']); ?>">
                <p>Hình 2 hiện tại: <?php echo htmlspecialchars($product['hinh2']); ?></p>

                <input type="file" name="hinh3" id="hinh3" class="input-field" accept="image/*">
                <input type="hidden" name="hinh3_cu" value="<?php echo htmlspecialchars($product['hinh3']); ?>">
                <p>Hình 3 hiện tại: <?php echo htmlspecialchars($product['hinh3']); ?></p>

                <input type="file" name="hinh4" id="hinh4" class="input-field" accept="image/*">
                <input type="hidden" name="hinh4_cu" value="<?php echo htmlspecialchars($product['hinh4']); ?>">
                <p>Hình 4 hiện tại: <?php echo htmlspecialchars($product['hinh4']); ?></p>
            </div>
        </div>

        <div class="form-group">
            <label for="maloai">Mã loại:</label>
            <div class="input-maloai">
                <select name="maloai" id="maloai" class="input-field" required>
                    <option value="">Chọn mã loại</option>
                    <?php foreach ($loai as $item) { ?>
                        <option value="<?php echo htmlspecialchars($item['maloai']); ?>" <?php echo $item['maloai'] == $product['maloai'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($item['tenloai']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="kichthuoc">Số lượng theo kích thước:</label>
            <div class="input-kichthuoc">
                <?php foreach ($kichthuoc as $item) { ?>
                    <label for="soluong_<?php echo $item['id']; ?>">
                        <?php echo htmlspecialchars($item['tenkichthuoc']); ?>:
                    </label>
                    <input 
                    type="number" 
                    name="soluong[<?php echo $item['id']; ?>]" 
                    id="soluong_<?php echo $item['id']; ?>" 
                           class="input-field" value="<?php echo htmlspecialchars($soluongMap[$item['id']] ?? 0); ?>" min="0">
                <?php } ?>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn-submit" name="btnEdit">Cập nhật sản phẩm</button>
        </div>
    </form>
</div>
