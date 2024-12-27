<?php
require_once(dirname(dirname(__DIR__)) . "/autoload/autoload.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['submitAdd'])) {
                $role = trim(postInput('role'));

                if ($role != '') {
                        $checkRole = $db->fetchAll("role", "quyen = " . '"' . $role . '"' . " LIMIT 1");
                        if ($checkRole) {
                                header("Location:../../index.php?mod=role&message=duplicate");
                        } else {
                                $data = ['quyen' => $role];
                                try {
                                        $db->insert('role', $data);
                                        header("Location:../../index.php?mod=role&message=success");
                                        exit();
                                } catch (Exception $e) {
                                        header("Location:../../index.php?mod=role&message=error");
                                }
                        }
                } else {
                        header("Location:../../index.php?mod=role&message=empty");
                }
        } else if (isset($_POST['submitEdit']) && isset($_POST['id'])) {

                $id = intval($_POST['id']); // Lấy giá trị id từ POST
                $role = trim(postInput('role'));

                if ($role != '' && $id > 0) {
                        $checkRole = $db->fetchAll("role", "quyen = " . '"' . $role . '"' . " LIMIT 1");
                        if ($checkRole) {
                                header("Location:../../index.php?mod=role&message=duplicate");
                        } else {
                                $data = ['quyen' => $role];
                                try {
                                        $db->update('role', $data, array("id" => $id));
                                        header("Location:../../index.php?mod=role&message=update");
                                        exit();
                                } catch (Exception $e) {
                                        header("Location:../../index.php?mod=role&message=error");
                                }
                        }
                } else {
                        header("Location:../../index.php?mod=role&message=invalid");
                }
        }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Xử lý xóa vai trò
        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
                $id = intval($_GET['id']);
                if ($id > 0) {
                        try {
                                $db->delete('role', "id = $id");
                                header("Location:../../index.php?mod=role&message=delsuccess");
                                exit();
                        } catch (Exception $e) {
                                header("Location:../../index.php?mod=role&message=error");
                        }
                } else {
                        header("Location:../../index.php?mod=role&message=invalid");
                }
        }
}
