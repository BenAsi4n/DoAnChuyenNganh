<h2 style="margin-bottom: 20px;">Chi tiết hóa đơn</h2>
<?php
require_once(dirname(dirname(__DIR__)) . "/autoload/autoload.php");
$id = intval(getInput('id'));
if ($id > 0) {
  $cthd = $db->fetchAll("chitiethoadon", "id_hoadon = " . $id);
} else {
  $cthd = $db->fetchAll("chitiethoadon");
}



?>

<div class="permissions-wrapper">

  <div class="table-container small-table">
    <div class="row header">
      <div class="column permission-id">Mã</div>
      <div class="column permission-id">Mã Hóa đơn</div>
      <div class="column permission-name">Mã SP</div>
      <div class="column permission-name">Số lượng</div>
      <div class="column permission-name">Giá</div>
      <div class="column permission-name">Mô tả</div>
    </div>

    <?php if (empty($cthd)) {
      echo "<div>Không có dữ liệu nào được tìm thấy.</div>";
      echo "$id"; 
    } else {
      foreach ($cthd as $item) { ?>
        <div class="row">
          <div class="column permission-id"><?php echo htmlspecialchars($item['id_chitiet']) ?></div>
          <div class="column permission-name"><?php echo htmlspecialchars($item['id_hoadon']) ?></div>
          <div class="column permission-id"><?php echo htmlspecialchars($item['masp']) ?></div>
          <div class="column permission-name"><?php echo htmlspecialchars($item['soluong']) ?></div>
          <div class="column permission-id"><?php echo htmlspecialchars($item['gia']) ?></div>
          <div class="column permission-name"><?php echo htmlspecialchars($item['description']) ?></div>
        </div>
    <?php }
    }
    ?>

  </div>
</div>
<style>
  .small-table {
    min-height: 500px;
    width: 100%;
  }
</style>