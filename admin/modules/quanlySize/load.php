<h2 style="margin-bottom: 20px;">Quản lý Size</h2>

<?php
require_once(dirname(dirname(__DIR__)) . "/autoload/autoload.php");
$ac = getInput('ac');
if (isset($ac) != '' && $ac === 'edit') {
  require_once(ROOT . "/admin/modules/quanlySize/edit.php");
}

$size = $db->fetchAll("sanpham_kichthuoc");
?>
<div class="permissions-wrapper">
  <form action="/admin/modules/quanlySize/controll.php" method="POST">
    <div class="add_role">
      <input type="text" placeholder="Kích thước" id="size" name="size">
      <div class="btn_them">
        <button type="submit" name="submitAdd">Thêm</button>
      </div>
    </div>
  </form>

  <!-- Bảng trên -->
  <div class="table-container small-table">
    <div class="row header">
      <div class="column permission-id">Mã Size</div>
      <div class="column permission-name">Size</div>
     
      <div class="column action"></div>
    </div>

    <!-- Dữ liệu dòng -->
    <?php foreach ($size as $item) { ?>
      <div class="row">
        <div class="column permission-id"><?php echo htmlspecialchars($item['id']) ?></div>
        <div class="column permission-name"><?php echo htmlspecialchars($item['tenkichthuoc']) ?></div>
        <div class="column action">
          <a href="?mod=size&ac=edit&id=<?php echo htmlspecialchars($item['id']) ?>" class="edit-btn" name="btnEdit">Edit</a>
          <a href="/admin/modules/quanlySize/controll.php?action=delete&id=<?php echo htmlspecialchars($item['id']) ?>" class="delete-btn" name="btnDelete">Delete</a>
        </div>
      </div>
    <?php } ?>

  </div>
</div>