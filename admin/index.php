<?php
require_once("autoload/autoload.php");
include("checkLogin.php");
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="shortcut icon" type="image/png" href="/public/img/logo.png">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <?php
        require_once("./layouts/header.php");
        require_once("./layouts/sidebar.php");
        ?>
        <!-- Xử lý hiển thị ở đây -->
        <main>
            <div class="hidden" id="notification"></div>
            <?php
            $mod = getInput('mod');
            $ac = getInput('ac');
            if ($mod == 'loai') {
                require_once(ROOT . "/admin/modules/quanlyLoai/load.php");
            } else if ($mod == 'role') {
                require_once(ROOT . "/admin/modules/quanlyRole/loadRole.php");
            } else if ($mod == 'sanpham') {
                if ($ac == 'add') {
                    require_once(ROOT . "/admin/modules/quanlySanpham/add.php");
                } elseif ($ac == 'edit') {
                    require_once(ROOT . "/admin/modules/quanlySanpham/edit.php");
                } else {
                    require_once(ROOT . "/admin/modules/quanlySanpham/load.php");
                }
            } else if ($mod == 'user') {
                require_once(ROOT . "/admin/modules/quanlyUser/loadUser.php");
            } else if ($mod == 'thanhtoan') {
                require_once(ROOT . "/admin/modules/quanlyThanhtoan/load.php");
            } else if ($mod == 'vanchuyen') {
                require_once(ROOT . "/admin/modules/quanlyVanchuyen/load.php");
            } else if ($mod == 'km') {
                require_once(ROOT . "/admin/modules/quanlyKM/load.php");
            } else if ($mod == 'size') {
                require_once(ROOT . "/admin/modules/quanlySize/load.php");
            } else if ($mod == 'hoadon') {
                require_once(ROOT . "/admin/modules/quanlyHoadon/load.php");
            } else if ($mod == 'chitiethoadon') {
                require_once(ROOT . "/admin/modules/quanlyChitietHoadon/load.php");
            } else {
                echo "Helloo, hãy chọn mục bạn muốn " . $_SESSION['id_Admin'] . ":" . $_SESSION['username'];
            }
            ?>
        </main>
    </div>
</body>
<script src="/public/js/notification.js"></script>

</html>