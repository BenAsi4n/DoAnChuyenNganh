<?php
require_once(dirname(dirname(__DIR__)) . "/autoload/autoload.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['submitAdd'])) {
                $pttt = trim(postInput('pttt'));

                if ($pttt != '') {
                        $check = $db->fetchAll("thanhtoan", "ten_pttt = " . '"' . $pttt . '"' . " LIMIT 1");

                        if ($check) {
                                // Nếu đã tồn tại
                                header("Location:../../index.php?mod=thanhtoan&message=duplicate");
                        } else {
                                $data = ['ten_pttt' => $pttt];
                                try {
                                        $db->insert('thanhtoan', $data);
                                        header("Location:../../index.php?mod=thanhtoan&message=success");
                                        exit();
                                } catch (Exception $e) {
                                        header("Location:../../index.php?mod=thanhtoan&message=error");
                                }
                        }
                } else {
                        header("Location:../../index.php?mod=thanhtoan&message=empty");
                }
        } else if (isset($_POST['submitEdit']) && isset($_POST['id_thanhtoan'])) {

                $id = intval($_POST['id_thanhtoan']); // Lấy giá trị id từ POST
                $pttt = trim(postInput('pttt'));


                if ($pttt != '' && $id > 0) {
                        $check = $db->fetchAll("thanhtoan", "ten_pttt = " . '"' . $pttt . '"' . " LIMIT 1");

                        if ($check) {
                                // Nếu đã tồn tại
                                header("Location:../../index.php?mod=thanhtoan&message=duplicate");
                        } else {
                                $data = ['ten_pttt' => $pttt];
                                try {
                                        $db->update('thanhtoan', $data, array("id_thanhtoan" => $id));
                                        header("Location:../../index.php?mod=thanhtoan&message=update");
                                        exit();
                                } catch (Exception $e) {
                                        header("Location:../../index.php?mod=thanhtoan&message=error");
                                }
                        }
                } else {
                        header("Location:../../index.php?mod=thanhtoan&message=invalid");
                }
        }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Xử lý xóa vai trò
        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
                $id = intval($_GET['id']);
                if ($id > 0) {
                        try {
                                $db->delete('thanhtoan', "id_thanhtoan = $id");
                                header("Location:../../index.php?mod=thanhtoan&message=delsuccess");
                                exit();
                        } catch (Exception $e) {
                                header("Location:../../index.php?mod=thanhtoan&message=error");
                        }
                } else {
                        header("Location:../../index.php?mod=thanhtoan&message=invalid");
                }
        }
}
