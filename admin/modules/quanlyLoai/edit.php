<?php
require_once(dirname(dirname(__DIR__)) . "/autoload/autoload.php");
if (isset($_GET['id'])) {
    $id = getInput('id');
}
//lấy để settext cho input
$loai = $db->fetchOne('loai', 'maloai = ' . $id);
?>
<div class="permissions-wrapper">
    <form action="/admin/modules/quanlyLoai/controll.php?id=<?php echo $_GET['id'] ?>" method="POST">
        <input type="hidden" value="<?php echo $_GET['id'] ?>" id="maloai" name="maloai">
        <div class="add_role edit_role">
            <input type="text" placeholder="Loại" id="loai" name="tenloai" value="<?php echo htmlspecialchars($loai['tenloai']) ?>">
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