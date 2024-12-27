<?php
require_once(dirname(dirname(__DIR__)) . "/autoload/autoload.php");

if (isset($_POST['submitUpdate'])) {
    if (isset($_POST['user_id']) && isset($_POST['idRole'])) {
        $user_id = intval($_POST['user_id']); // Ép kiểu để tránh lỗi
        $new_role_id = intval($_POST['idRole']); // Lấy trực tiếp giá trị từ select

      
        $sql = "UPDATE user SET id_quyen = ? WHERE id = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ii", $new_role_id, $user_id); 

            if ($stmt->execute()) {
                header("Location:../../index.php?mod=user&message=update");
                exit();
            } else {
                header("Location:../../index.php?mod=user&message=error");
                exit();
            }
            $stmt->close();
        } else {
            header("Location:../../index.php?mod=user&message=error");
            exit();
        }
    } else {
        header("Location:../../index.php?mod=user&message=invalid");
        exit();
    }
} else {
    header("Location:../../index.php?mod=user&message=invalid");
    exit();
}
