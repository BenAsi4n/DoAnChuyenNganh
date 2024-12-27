<?php
require_once(dirname(dirname(__DIR__)) . "/autoload/autoload.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['submitAdd'])) {
                $ptvc = trim(postInput('ptvc'));

                if ($ptvc != '') {
                        $check = $db->fetchAll("vanchuyen", "ten_ptvc = " . '"' . $ptvc . '"' . " LIMIT 1");

                        if ($check) {
                                // Nếu đã tồn tại
                                header("Location:../../index.php?mod=vanchuyen&message=duplicate");
                        } else {
                                $data = ['ten_ptvc' => $ptvc];
                                try {
                                        $db->insert('vanchuyen', $data);
                                        header("Location:../../index.php?mod=vanchuyen&message=success");
                                        exit();
                                } catch (Exception $e) {
                                        header("Location:../../index.php?mod=vanchuyen&message=error");
                                }
                        }
                } else {
                        header("Location:../../index.php?mod=vanchuyen&message=empty");
                }
        } else if (isset($_POST['submitEdit']) && isset($_POST['id_vanchuyen'])) {

                $id = intval($_POST['id_vanchuyen']); // Lấy giá trị id từ POST
                $ptvc = trim(postInput('ptvc'));


                if ($ptvc != '' && $id > 0) {
                        $check = $db->fetchAll("vanchuyen", "ten_ptvc = " . '"' . $ptvc . '"' . " LIMIT 1");

                        if ($check) {
                                // Nếu đã tồn tại
                                header("Location:../../index.php?mod=vanchuyen&message=duplicate");
                        } else {
                                $data = ['ten_ptvc' => $ptvc];
                                try {
                                        $db->update('vanchuyen', $data, array("id_vanchuyen" => $id));
                                        header("Location:../../index.php?mod=vanchuyen&message=update");
                                        exit();
                                } catch (Exception $e) {
                                        header("Location:../../index.php?mod=vanchuyen&message=error");
                                }
                        }
                } else {
                        header("Location:../../index.php?mod=vanchuyen&message=invalid");
                }
        }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Xử lý xóa vai trò
        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
                $id = intval($_GET['id']);
                if ($id > 0) {
                        try {
                                $db->delete('vanchuyen', "id_vanchuyen = $id");
                                header("Location:../../index.php?mod=vanchuyen&message=delsuccess");
                                exit();
                        } catch (Exception $e) {
                                header("Location:../../index.php?mod=vanchuyen&message=error");
                        }
                } else {
                        header("Location:../../index.php?mod=vanchuyen&message=invalid");
                }
        }
}
