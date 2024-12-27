<h2 style="margin-bottom: 20px;">Quản lý Quyền</h2>

<?php
require_once(dirname(dirname(__DIR__)) . "/autoload/autoload.php");
$ac = getInput('ac');
if (isset($ac) != '' && $ac === 'edit') {
  require_once(ROOT . "/admin/modules/quanlyRole/edit.php");
}

$role = $db->fetchAll("role");
?>
<div class="permissions-wrapper">
  <form action="/admin/modules/quanlyRole/controll.php" method="POST">
    <div class="add_role">
      <input type="text" placeholder="Role" id="role" name="role">
      <div class="btn_them">
        <button type="submit" name="submitAdd">Thêm</button>
      </div>
    </div>
  </form>

  <!-- Bảng trên -->
  <div class="table-container small-table">
    <div class="row header">
      <div class="column permission-id">ID</div>
      <div class="column permission-name">Quyền</div>
      <div class="column action"></div>
    </div>

    <!-- Dữ liệu dòng -->
    <?php foreach ($role as $item) { ?>
      <div class="row">
        <div class="column permission-id"><?php echo htmlspecialchars($item['id']) ?></div>
        <div class="column permission-name"><?php echo htmlspecialchars($item['quyen']) ?></div>
        <div class="column action">
          <?php if ($item['quyen'] === "admin" || $item['quyen'] === "user") { ?>
            <a onclick="return false;" href="?mod=role&ac=edit&id=<?php echo htmlspecialchars($item['id']) ?>" 
            class="edit-btn" name="btnEdit">Edit</a>
            <a onclick="return false;" href="/admin/modules/quanlyRole/controll.php?action=delete&id=<?php echo htmlspecialchars($item['id']) ?>" 
            class="" name="btnDelete">Delete</a>
          <?php } else { ?>
            <a href="?mod=role&ac=edit&id=<?php echo htmlspecialchars($item['id']) ?>" 
            class="edit-btn update-btn" name="btnEdit">Edit</a>
            <a href="/admin/modules/quanlyRole/controll.php?action=delete&id=<?php echo htmlspecialchars($item['id']) ?>" 
            class="delete-btn" name="btnDelete">Delete</a>
          <?php } ?>

        </div>
      </div>
    <?php } ?>

  </div>
</div>