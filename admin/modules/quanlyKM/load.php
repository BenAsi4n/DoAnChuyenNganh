<h2 style="margin-bottom: 20px;">Quản lý Khuyến mãi</h2>

<?php
require_once(dirname(dirname(__DIR__)) . "/autoload/autoload.php");
$ac = getInput('ac');
if (isset($ac) != '' && $ac === 'edit') {
  require_once(ROOT . "/admin/modules/quanlyKM/edit.php");
}

$khuyenmai = $db->fetchAll("khuyenmai");
?>
<div class="permissions-wrapper">
  <form action="/admin/modules/quanlyKM/controll.php" method="POST">
    <div class="add_role">
      <input type="text" placeholder="Khuyến mãi" id="km" name="km">
      <div class="btn_them">
        <button type="submit" name="submitAdd">Thêm</button>
      </div>
    </div>
  </form>

  <!-- Bảng trên -->
  <div class="table-container small-table">
    <div class="row header">
      <div class="column permission-id">Mã KM</div>
      <div class="column permission-name">Tên KM</div>
      <div class="column permission-id">% Giảm giá</div>
      <div class="column permission-name">Mã Sản phẩm</div>
      <div class="column action"></div>
    </div>

    <!-- Dữ liệu dòng -->
    <?php foreach ($khuyenmai as $item) { ?>
      <div class="row">
        <div class="column permission-id"><?php echo htmlspecialchars($item['id']) ?></div>
        <div class="column permission-name"><?php echo htmlspecialchars($item['tenloai']) ?></div>
        <div class="column permission-id"><?php echo htmlspecialchars($item['maloai']) ?></div>
        <div class="column permission-name"><?php echo htmlspecialchars($item['tenloai']) ?></div>
        <div class="column action">
          <a href="?mod=km&ac=edit&id=<?php echo htmlspecialchars($item['maloai']) ?>" class="edit-btn update-btn" name="btnEdit">Edit</a>
          <a href="/admin/modules/quanlyKM/controll.php?action=delete&id=<?php echo htmlspecialchars($item['maloai']) ?>" class="delete-btn" name="btnDelete">Delete</a>
        </div>
      </div>
    <?php } ?>

  </div>
</div>