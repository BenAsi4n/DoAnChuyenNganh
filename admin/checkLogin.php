<?php

// Kiểm tra nếu chưa đăng nhập
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true 
                                || $_SESSION['quyen'] != "admin") {
    header('Location: login.php');
    exit();
}
$timeout = 600;//giây
// Kiểm tra timeout (10 phút không hoạt động)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
    session_unset();
    session_destroy();
    header("Location: login.php?status=timeout");
    exit();
}

// Cập nhật lại thời gian hoạt động
$_SESSION['last_activity'] = time();
