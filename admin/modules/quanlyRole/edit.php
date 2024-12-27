<?php
require_once(dirname(dirname(__DIR__)) . "/autoload/autoload.php");
if (isset($_GET['id'])) {
    $id = getInput('id');
}
//lấy để settext cho input
$role_ID = $db->fetchID('role', $id);
?>
<div class="permissions-wrapper">
    <form action="/admin/modules/quanlyRole/controll.php?id=<?php echo $_GET['id'] ?>" method="POST">
        <input type="hidden" value="<?php echo $_GET['id'] ?>" id="id" name="id" >
        <div class="add_role edit_role">
            <input type="text" placeholder="Role" id="role" name="role" value="<?php echo htmlspecialchars($role_ID['quyen']) ?>">
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