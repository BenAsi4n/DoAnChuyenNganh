<?php
require_once(dirname(dirname(__DIR__)) . "/autoload/autoload.php");
$searchTerm = isset($_POST['search']) ? $_POST['search'] : '';
if ($searchTerm) {
    $products = $db->fetchAll('sanpham', "tensp LIKE '%" . $searchTerm . "%' OR masp LIKE '%" . $searchTerm . "%'");
} else {
    $products = $db->fetchAll('sanpham');
}

?>
<div class="title-mod">
    <h2>Quản lý Sản phẩm</h2>
    <form method="POST" action="">
        <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..." value="<?php echo htmlspecialchars($searchTerm); ?>">
        <button type="submit" class="btn_search">Tìm kiếm</button>
    </form>
    <a href="?mod=sanpham&ac=add" class="btn_them">Thêm sản phẩm</a>
</div>

<div class="product-table">
    <table>
        <thead>
            <tr>
                <th>
                    <div class="header-masp">Mã SP</div>
                </th>
                <th>
                    <div class="header-tensp">Tên SP</div>
                </th>
                <th>
                    <div class="header-mota">Mô tả</div>
                </th>
                <th>
                    <div class="header-gia">Giá</div>
                </th>
                <th>
                    <div class="header-hinh">Hình ảnh</div>
                </th>
                <th>
                    <div class="header-soluong">Số lượng</div>
                </th>
                <th>
                    <div class="header-maloai">Mã loại</div>
                </th>
                <th>
                    <div class="header-maloai"></div>
                </th>

            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($products as $product) {
                $details = $db->fetchAll("chitietsanpham", "sanpham_id = " . $product['masp']);
            ?>
                <tr>
                    <td>
                        <div class="cell-masp"><?php echo htmlspecialchars($product['masp']); ?></div>
                    </td>
                    <td>
                        <div class="cell-tensp"><?php echo htmlspecialchars($product['tensp']); ?></div>
                    </td>
                    <td>
                        <div class="cell-mota"><?php echo htmlspecialchars($product['mota']); ?></div>
                    </td>
                    <td>
                        <div class="cell-gia"><?php echo number_format($product['gia'], 0, ',', '.'); ?> VNĐ</div>
                    </td>
                    <td>
                        <div class="cell-hinh">
                            <div class="image-group">
                                <img src="<?php echo htmlspecialchars($product['hinh']); ?>"
                                    alt=""
                                    class="product-image">
                                <?php if (!empty($product['hinh2'])) { ?>
                                    <img src="<?php echo htmlspecialchars($product['hinh2']); ?>"
                                        alt=""
                                        class="product-image">
                                <?php } ?>
                                <?php if (!empty($product['hinh3'])) { ?>
                                    <img src="<?php echo htmlspecialchars($product['hinh3']); ?>"
                                        alt=""
                                        class="product-image">
                                <?php } ?>
                                <?php if (!empty($product['hinh4'])) { ?>
                                    <img src="<?php echo htmlspecialchars($product['hinh4']); ?>"
                                        alt=""
                                        class="product-image">
                                <?php } ?>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="cell-soluong"><?php
                                                    foreach ($details as $detail) {
                                                        $kichthuoc = $db->fetchOne("sanpham_kichthuoc", "id = " . $detail['kichthuoc_id']);
                                                        echo htmlspecialchars($kichthuoc['tenkichthuoc']) . ": " . htmlspecialchars($detail['soluong']) . "<br>";
                                                    } ?></div>
                    </td>
                    <td>
                        <div class="cell-maloai"><?php echo htmlspecialchars($product['maloai']); ?></div>
                    </td>
                    <td>
                        <div class="cell-maloai">
                            <a href="?mod=sanpham&ac=edit&id=<?php echo htmlspecialchars($product['masp']); ?>" class="edit-btn" name="btnEdit">Edit</a>
                            <a href="/admin/modules/quanlySanpham/controll.php?action=delete&id=<?php echo htmlspecialchars($product['masp']); ?>" class="delete-btn" name="btnDelete">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
<style>
    .title-mod input {
        font-size: 15px;
        border-radius: 8px;
        padding: 10px 5px ;
        border: solid 1px;
        margin-top: 15px;
    }
    .title-mod .btn_search {
        padding: 10px 5px ;
        background-color: #000;
        color: #fff;
    }
    .title-mod .btn_search:hover{
        scale: 1.1;
    }
</style>
