<?php
require_once(dirname(dirname(__DIR__)) . "/autoload/autoload.php");
if (isset($_GET['id'])) {
    $id = getInput('id');
}
//lấy để settext cho input
$size = $db->fetchOne('sanpham_kichthuoc', 'id = ' . $id);
?>
<div class="permissions-wrapper">

    <form action="/admin/modules/quanlySize/controll.php?id=<?php echo $_GET['id'] ?>" method="POST">
        <input type="hidden" value="<?php echo $_GET['id'] ?>" id="id" name="id">
        <div class="add_role edit_role">
            <input type="text" placeholder="Kích thước" id="size" name="size" value="<?php echo htmlspecialchars($size['tenkichthuoc']) ?>">
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