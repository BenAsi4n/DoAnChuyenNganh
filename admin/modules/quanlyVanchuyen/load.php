<h2 style="margin-bottom: 20px;">Quản lý Vận chuyển</h2>

<?php
require_once(dirname(dirname(__DIR__)) . "/autoload/autoload.php");
$ac = getInput('ac');
if (isset($ac) != '' && $ac === 'edit') {
  require_once(ROOT . "/admin/modules/quanlyVanchuyen/edit.php");
}

$ptvc = $db->fetchAll("vanchuyen");
?>
<div class="permissions-wrapper">
  <form action="/admin/modules/quanlyVanchuyen/controll.php" method="POST">
    <div class="add_role">
      <input type="text" placeholder="Tên PTVC" id="ptvc" name="ptvc">
      <div class="btn_them">
        <button type="submit" name="submitAdd">Thêm</button>
      </div>
    </div>
  </form>

  <!-- Bảng trên -->
  <div class="table-container small-table">
    <div class="row header">
      <div class="column permission-id">Mã PT</div>
      <div class="column permission-name">Tên Phương thức Vận chuyển</div>
      <div class="column action"></div>
    </div>

    <!-- Dữ liệu dòng -->
    <?php foreach ($ptvc as $item) { ?>
      <div class="row">
        <div class="column permission-id"><?php echo htmlspecialchars($item['id_vanchuyen']) ?></div>
        <div class="column permission-name"><?php echo htmlspecialchars($item['ten_ptvc']) ?></div>
        <div class="column action">
          <a href="?mod=vanchuyen&ac=edit&id=<?php echo htmlspecialchars($item['id_vanchuyen']) ?>" class="edit-btn update-btn" name="btnEdit">Edit</a>
          <a href="/admin/modules/quanlyVanchuyen/controll.php?action=delete&id=<?php echo htmlspecialchars($item['id_vanchuyen']) ?>" class="delete-btn" name="btnDelete">Delete</a>
        </div>
      </div>
    <?php } ?>

  </div>
</div>