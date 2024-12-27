<?php
require_once(dirname(dirname(__DIR__)) . "/autoload/autoload.php");
if (isset($_GET['id'])) {
    $id = getInput('id');
}
//lấy để settext cho input
$ptvc = $db->fetchOne('vanchuyen', 'id_vanchuyen = ' . $id);
?>
<div class="permissions-wrapper">
    <form action="/admin/modules/quanlyVanchuyen/controll.php?id=<?php echo $_GET['id'] ?>" method="POST">
        <input type="hidden" value="<?php echo $_GET['id'] ?>" id="id_vanchuyen" name="id_vanchuyen">
        <div class="add_role edit_role">
            <input type="text" placeholder="PTVC" id="vanchuyen" name="ptvc" value="<?php echo htmlspecialchars($ptvc['ten_ptvc']) ?>">
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