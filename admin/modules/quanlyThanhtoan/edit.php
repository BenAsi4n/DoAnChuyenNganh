<?php
require_once(dirname(dirname(__DIR__)) . "/autoload/autoload.php");
if (isset($_GET['id'])) {
    $id = getInput('id');
}
//lấy để settext cho input
$pttt = $db->fetchOne('thanhtoan', 'id_thanhtoan = ' . $id);
?>
<div class="permissions-wrapper">
    <form action="/admin/modules/quanlyThanhtoan/controll.php?id=<?php echo $_GET['id'] ?>" method="POST">
        <input type="hidden" value="<?php echo $_GET['id'] ?>" id="id_thanhtoan" name="id_thanhtoan">
        <div class="add_role edit_role">
            <input type="text" placeholder="PTTT" id="thanhtoan" name="pttt" value="<?php echo htmlspecialchars($pttt['ten_pttt']) ?>">
            <div class="btn_them">
                <button type="submit" name="submitEdit">Cập nhật</button>
            </div>
        </div>
    </form>
    <style>
        .table-container {
            display: none;
        }

        .add_role {
            display: none;
        }

        .add_role.edit_role {
            display: flex;
        }
    </style>
</div>