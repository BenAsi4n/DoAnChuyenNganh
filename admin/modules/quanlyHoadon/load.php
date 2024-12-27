<h2 style="margin-bottom: 20px;">Quản lý Đơn hàng</h2>

<?php
require_once(dirname(dirname(__DIR__)) . "/autoload/autoload.php");


$hd = $db->fetchAll("hoadon", " 1 = 1 ORDER BY ngaydat DESC");
?>
<div class="table-container">
  <table>
    <thead>
      <tr>
        <th>Mã đơn</th>
        <th>User</th>
        <th>Tên KH</th>
        <th>Địa chỉ</th>
        <th>SDT</th>
        <th>Tổng tiền</th>
        <th>Ngày đặt</th>
        <th>Ngày giao</th>
        <th>Tình trạng</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($hd as $item) { ?>
        <tr>
          <td><?php echo htmlspecialchars($item['id_hoadon']) ?></td>
          <td><?php echo htmlspecialchars($item['id_user']) ?></td>
          <td><?php echo htmlspecialchars($item['hoten']) ?></td>
          <td><?php echo htmlspecialchars($item['diachinhan']) ?></td>
          <td><?php echo htmlspecialchars($item['sdt']) ?></td>
          <td><?php echo htmlspecialchars($item['tongtien']) ?></td>
          <td><?php echo htmlspecialchars($item['ngaydat']) ?></td>
          <td><?php echo htmlspecialchars($item['ngaygiao']) ?></td>
          <td><?php echo htmlspecialchars($item['tinhtrang']) ?></td>
          <td class="action-buttons">
            <form action="/admin/modules/quanlyHoadon/controll.php" method="POST">
              <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id_hoadon']) ?>" id="">
              <?php if ($item['tinhtrang'] === "Đã giao" || $item['tinhtrang'] === "Đã xác nhận") { ?>
                <button name="xacnhan" class="edit-btn" disabled>Xác nhận đơn hàng</button>
              <?php } else { ?>
                <button name="xacnhan" class="edit-btn">Xác nhận đơn hàng</button>
              <?php } ?>
              <?php if ($item['tinhtrang'] === "Chờ xác nhận" || $item['tinhtrang'] === "Đã giao") { ?>
                <button name="dagiao" class="edit-btn" disabled>Đã giao</button>
              <?php } else { ?>
                <button name="dagiao" class="edit-btn">Đã giao</button>
              <?php } ?>
              <button name="chitiet" class="edit-btn">Chi tiết</button>
            </form>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<style>
  .table-container {
    width: 100%;
    margin: 20px 0;
    border-collapse: collapse;
  }

  .table-container table {
    width: 100%;
    border-collapse: collapse;
    font-family: Arial, sans-serif;
    text-align: left;
  }

  .table-container th,
  .table-container td {
    border: 1px solid #ddd;
    padding: 8px;
  }

  .table-container th {
    background-color: #f4f4f4;
    font-weight: bold;
  }

  .table-container tr:nth-child(even) {
    background-color: #f9f9f9;
  }

  .action-buttons {
    display: flex;
    align-items: center;
  }

  .action-buttons button {
    padding: 5px 10px;
    margin: 3px 0;
    color: #fff;
    border-radius: 4px;
  }

  .action-buttons .edit-btn {
    width: 50%;
    background-color: rgb(45, 45, 45);
  }

  .action-buttons .edit-btn:hover {
    background-color: rgb(73, 70, 74);
    scale: 1.1;
  }
</style>