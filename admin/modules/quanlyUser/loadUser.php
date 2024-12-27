<?php
require_once(dirname(dirname(__DIR__)) . "/autoload/autoload.php");

$sql = "SELECT 
            user.id AS user_id, 
            user.hoten AS hoten, 
            user.id_quyen AS id_quyen, 
            role.quyen AS quyen
        FROM 
            user
        JOIN 
            role
        ON 
            user.id_quyen = role.id";

$user = $conn->query($sql);
$role = $db->fetchALL('role');

$idAdmin = $_SESSION['id_Admin'];


?>
<h2 style="margin-bottom: 20px;">Quản lý User</h2>

<div class="table-container large-table">
  <div class="row header">
    <div class="column user-id">ID Người dùng</div>
    <div class="column user-name">Tên Người dùng</div>
    <!-- <div class="column permission-name">Tên Quyền</div> -->
    <!-- <div class="column permission-id">ID Quyền</div> -->
    <div class="column action">Thay đổi Quyền</div>
  </div>

  <!-- Dữ liệu dòng -->
  <?php if (!empty($user)) {
    foreach ($user as $us) {
      if ($us['user_id'] == $idAdmin) {
        // Bỏ qua admin ddang login hiện tại
        continue;
      } ?>
      <div class="row">
        <div class="column user-id"><?php echo htmlspecialchars($us['user_id']) ?></div>
        <div class="column user-name"><?php echo htmlspecialchars($us['hoten']) ?></div>
        <!-- <div class="column permission-name"><?php echo htmlspecialchars($us['quyen']) ?></div> -->
        <!-- <div class="column permission-id"><?php echo htmlspecialchars($us['id_quyen']) ?></div> -->
        <div class="column action">
          <form method="POST" action="/admin/modules/quanlyUser/controll.php">
            <input type="hidden" name="user_id" value="<?php echo $us['user_id']; ?>">
            <select name="idRole" required>
              <?php foreach ($role as $r) { ?>
                <option value="<?php echo $r['id']; ?>"
                  <?php echo ($us['id_quyen'] == $r['id']) ? 'selected' : ''; ?>>
                  <?php echo $r['quyen']; ?>
                </option>
              <?php } ?>
            </select>
            <button type="submit" name="submitUpdate" class="update-btn">Cập nhật quyền</button>
        </div>
        </form>
      </div>
  <?php
    }
  } ?>
</div>
<style>
  .large-table {
    min-height: 450px;
  }
</style>