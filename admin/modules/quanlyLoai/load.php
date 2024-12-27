<h2 style="margin-bottom: 20px;">Quản lý Loại Sản Phẩm</h2>

<?php
require_once(dirname(dirname(__DIR__)) . "/autoload/autoload.php");
$ac = getInput('ac');
if (isset($ac) != '' && $ac === 'edit') {
  require_once(ROOT . "/admin/modules/quanlyLoai/edit.php");
}

$loai = $db->fetchAll("loai");
?>
<div class="permissions-wrapper">
  <form action="/admin/modules/quanlyLoai/controll.php" method="POST">
    <div class="add_role">
      <input type="text" placeholder="Loại SP" id="loai" name="loai">
      <div class="btn_them">
        <button type="submit" name="submitAdd">Thêm</button>
      </div>
    </div>
  </form>

  <!-- Bảng trên -->
  <div class="table-container small-table">
    <div class="row header">
      <div class="column permission-id">Mã Loại</div>
      <div class="column permission-name">Tên Loại</div>
      <div class="column action"></div>
    </div>

    <!-- Dữ liệu dòng -->
    <?php foreach ($loai as $item) { ?>
      <div class="row">
        <div class="column permission-id"><?php echo htmlspecialchars($item['maloai']) ?></div>
        <div class="column permission-name"><?php echo htmlspecialchars($item['tenloai']) ?></div>
        <div class="column action">
          <a href="?mod=loai&ac=edit&id=<?php echo htmlspecialchars($item['maloai']) ?>" class="edit-btn" name="btnEdit">Edit</a>
          <a href="/admin/modules/quanlyLoai/controll.php?action=delete&id=<?php echo htmlspecialchars($item['maloai']) ?>" class="delete-btn" name="btnDelete">Delete</a>
        </div>
      </div>
    <?php } ?>

  </div>
</div>