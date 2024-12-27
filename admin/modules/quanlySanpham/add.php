<?php
require_once(dirname(dirname(__DIR__)) . "/autoload/autoload.php");

$loai = $db->fetchAll("loai");
$size = $db->fetchAll("sanpham_kichthuoc");
?>
<h2>Thêm sản phẩm</h2>

<div class="product-add-form">
    <form action="/admin/modules/quanlySanpham/controll.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="tensp">Tên sản phẩm:</label>
            <div class="input-tensp">
                <input type="text" name="tensp" id="tensp" class="input-field" required>
            </div>
        </div>

        <div class="form-group">
            <label for="mota">Mô tả:</label>
            <div class="input-mota">
                <textarea name="mota" id="mota" class="input-field" rows="4" required></textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="gia">Giá (VNĐ):</label>
            <div class="input-gia">
                <input type="number" name="gia" id="gia" class="input-field" required>
            </div>
        </div>

        <div class="form-group">
            <label for="hinh">Hình ảnh (tối đa 4 ảnh):</label>
            <div class="input-hinh">
                <input type="file" name="hinh[]" id="hinh" class="input-field" accept="image/*" multiple required>
            </div>
        </div>

        <div class="form-group">
            <label for="soluong">Số lượng:</label>
            <div class="input-soluong">
                <?php foreach ($size as $kichthuoc) { ?>
                    <div class="size-group">
                        <label for="soluong_<?php echo htmlspecialchars($kichthuoc['id']); ?>">
                            <?php echo htmlspecialchars($kichthuoc['tenkichthuoc']); ?>:
                        </label>
                        <input
                            type="number"
                            name="soluong[<?php echo htmlspecialchars($kichthuoc['id']); ?>]"
                            id="soluong_<?php echo htmlspecialchars($kichthuoc['id']); ?>"
                            class="input-field"
                            min="0"
                            required>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="form-group">
            <label for="maloai">Mã loại:</label>
            <div class="input-maloai">
                <select name="maloai" id="maloai" class="input-field" required>
                    <option value="">Chọn mã loại</option>
                    <?php foreach ($loai as $item) { ?>
                        <option value="<?php echo htmlspecialchars($item['maloai']); ?>">
                            <?php echo htmlspecialchars($item['tenloai']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn-submit" name="btn-Add">Thêm sản phẩm</button>
        </div>
    </form>
</div>