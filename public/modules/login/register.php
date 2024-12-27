<?php
require_once dirname(dirname(dirname(__DIR__))) . "/autoLoad_User/autoload.php";


$role = $db->fetchOne('role', "quyen = 'user'");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $hoten = trim($_POST['hoten']);
    $tendangnhap = trim($_POST['tendangnhap']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);
    $sdt = trim($_POST['sdt']);
    $diachi = trim($_POST['diachi']);
    $ngaysinh = trim($_POST['ngaysinh']);
    $gioitinh = isset($_POST['gioitinh']) ? $_POST['gioitinh'] : '';

    if ($role) {
        $role_id = $role['id'];
    }

    $errors = [];

    if (!preg_match('/^[0-9]{10,11}$/', $sdt)) {
        $errors[] = "Số điện thoại không hợp lệ (chỉ chứa 10-11 chữ số).";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email không đúng định dạng.";
    }

    if (strlen($password) < 8) {
        $errors[] = "Mật khẩu phải có ít nhất 8 ký tự.";
    }

    $ngaysinh_format = date("Y/m/d", strtotime($ngaysinh));

    $gioitinh = ($gioitinh === "Nam") ? 1 : 0;

    $user_check = $db->fetchOne('user', "tendangnhap = '$tendangnhap'");
    if ($user_check) {
        $errors[] = "Tên đăng nhập đã tồn tại.";
    }

    $email_check = $db->fetchOne('user', "email = '$email'");
    if ($email_check) {
        $errors[] = "Email đã được đăng ký.";
    }

    if (empty($errors)) {
        $user = [
            'hoten' => $hoten,
            'tendangnhap' => $tendangnhap,
            'password' => password_hash($password, PASSWORD_DEFAULT), // Hash mật khẩu
            'email' => $email,
            'sdt' => $sdt,
            'diachi' => $diachi,
            'ngaysinh' => $ngaysinh_format,
            'gioitinh' => $gioitinh,
            'id_quyen' => $role_id
        ];

        try {
            $db->insert('user', $user);
            header('Location: login.php?status=success');
        } catch (Exception $e) {
            header('Location: register.php?status=error');
        }
    } else {
        // Hiển thị thông báo lỗi
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/public/img/logo.png">

    <title>Register</title>
    <link rel="stylesheet" href="../../../admin/css/login.css">
</head>

<body>
    <div class="register-container">
        <h2>Đăng ký tài khoản</h2>
        <form id="registerForm" method="post">
            <div class="form-group">
                <label for="hoten">Họ và tên:</label>
                <input type="text" id="hoten" name="hoten">
            </div>

            <div class="form-group">
                <label for="tendangnhap">Tên đăng nhập:</label>
                <input type="text" id="tendangnhap" name="tendangnhap" require autocomplete="off">
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" required autocomplete="new-password">
                <div>
                    <input type="checkbox" id="show-password" onclick="togglePassword()">
                    <label for="show-password">Hiện mật khẩu</label>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="sdt">Số điện thoại:</label>
                <input type="tel" id="sdt" name="sdt" required>
            </div>

            <div class="form-group">
                <label for="diachi">Địa chỉ:</label>
                <input type="text" id="diachi" name="diachi" required>
            </div>

            <div class="form-group">
                <label for="ngaysinh">Ngày sinh:</label>
                <input type="date" id="ngaysinh" name="ngaysinh" required>
            </div>

            <div class="form-group">
                <label>Giới tính:</label>
                <div class="gender-options">
                    <label><input type="radio" name="gioitinh" value="Nam" required> Nam</label>
                    <label><input type="radio" name="gioitinh" value="Nữ" required> Nữ</label>
                </div>
            </div>

            <div class="form-btn">
                <button type="submit">Đăng ký</button>
            </div>
        </form>
    </div>

</body>
<script src="../../js/notification.js">

</script>

</html>