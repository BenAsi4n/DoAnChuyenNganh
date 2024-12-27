<?php
require_once dirname(dirname(dirname(__DIR__))) . "/autoLoad_User/autoload.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "SELECT u.id, u.tendangnhap, u.password, r.quyen, u.hoten 
            FROM user u
            INNER JOIN role r ON u.id_quyen = r.id
            WHERE u.tendangnhap = ?";

    $stmt = $conn->prepare($sql);

    $username = $_POST['username'];
    $password = $_POST['password'];
    

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Kiểm tra nếu có người dùng
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Kiểm tra mật khẩu
        if (password_verify($password, $user['password'])) {
            if ($user['quyen'] === 'user') {
                $_SESSION['login'] = true;
                $_SESSION['last_activity'] = time();
                $_SESSION['username'] = $username;
                 $_SESSION['id_user'] = $user['id'];
                $_SESSION['hoten'] = $user['hoten'];

                header('Location: ../../../index.php');
                exit();
            } else {
                header('Location: login.php?message=not');
                exit();
            }
        } else {
            header('Location: login.php?message=invalid_password');
            exit();
        }
    } else {
        header('Location: login.php?message=user_not_found');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="./public/img/logo.png">

    <title>Login Admin</title>
    <link rel="stylesheet" href="../../../admin/css/login.css">
</head>

<body>
    <div class="hidden" id="notification"></div>

    <div class="login-container">
        <h2>Đăng nhập</h2>
        <form id="loginForm" method="post">
            <div class="form-group">
                <label for="username">Tên đăng nhập:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" required>
                <div>
                    <input type="checkbox" id="show-password" onclick="togglePassword()">
                    <label for="show-password">Hiện mật khẩu</label>
                </div>
            </div>

            <div class="form-btn">
                <button type="submit">Đăng nhập</button>
            </div>

            <div class="form-group">
                <a href="./register.php" class="register-link">Bạn chưa có tài khoản? Đăng ký</a>
            </div>
        </form>
    </div>


</body>

<script>

</script>
<script src="../../js/notification.js"></script>

</html>