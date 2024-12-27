<h2 style="margin-bottom: 20px;">Quản lý Thanh toán</h2>

<?php
require_once(dirname(dirname(__DIR__)) . "/autoload/autoload.php");
$ac = getInput('ac');
if (isset($ac) != '' && $ac === 'edit') {
  require_once(ROOT . "/admin/modules/quanlyThanhtoan/edit.php");
}

$pttt = $db->fetchAll("thanhtoan");
?>
<div class="permissions-wrapper">
  <form action="/admin/modules/quanlyThanhtoan/controll.php" method="POST">
    <div class="add_role">
      <input type="text" placeholder="Tên PTTT" id="pttt" name="pttt">
      <div class="btn_them">
        <button type="submit" name="submitAdd">Thêm</button>
      </div>
    </div>
  </form>

  <!-- Bảng trên -->
  <div class="table-container small-table">
    <div class="row header">
      <div class="column permission-id">Mã PT</div>
      <div class="column permission-name">Tên Phương thức Thanh toán</div>
      <div class="column action"></div>
    </div>

    <!-- Dữ liệu dòng -->
    <?php foreach ($pttt as $item) { ?>
      <div class="row">
        <div class="column permission-id"><?php echo htmlspecialchars($item['id_thanhtoan']) ?></div>
        <div class="column permission-name"><?php echo htmlspecialchars($item['ten_pttt']) ?></div>
        <div class="column action">
          <a href="?mod=thanhtoan&ac=edit&id=<?php echo htmlspecialchars($item['id_thanhtoan']) ?>" class="edit-btn update-btn" name="btnEdit">Edit</a>
          <a href="/admin/modules/quanlyThanhtoan/controll.php?action=delete&id=<?php echo htmlspecialchars($item['id_thanhtoan']) ?>" class="delete-btn" name="btnDelete">Delete</a>
        </div>
      </div>
    <?php } ?>

  </div>
</div>