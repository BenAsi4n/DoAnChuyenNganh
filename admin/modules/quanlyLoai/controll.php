<?php
require_once(dirname(dirname(__DIR__)) . "/autoload/autoload.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       
        if (isset($_POST['submitAdd'])) {
                $loai = trim(postInput('loai'));

                if ($loai != '') {
                        // Kiểm tra trùng tên loại
                        $checkLoai = $db->fetchAll("loai", "tenloai = " . '"' . $loai . '"' . " LIMIT 1");

                        if ($checkLoai) {
                                // Nếu đã tồn tại
                                header("Location:../../index.php?mod=loai&message=duplicate");
                        } else {
                                $data = ['tenloai' => $loai];
                                try {
                                        $db->insert('loai', $data);
                                        header("Location:../../index.php?mod=loai&message=success");
                                        exit();
                                } catch (Exception $e) {
                                        header("Location:../../index.php?mod=loai&message=error");
                                }
                        }
                } else {
                        header("Location:../../index.php?mod=loai&message=empty");
                }
        } else if (isset($_POST['submitEdit']) && isset($_POST['maloai'])) {
                $id = intval($_POST['maloai']); // Lấy giá trị id từ POST
                $loai = trim(postInput('tenloai'));

                if ($loai != '' && $id > 0) {
                        // Kiểm tra trùng tên loại nhưng phải bỏ qua bản ghi hiện tại
                        $checkLoai = $db->fetchAll("loai", "tenloai = " . '"' . $loai . '"' . " LIMIT 1");

                        if ($checkLoai) {
                                // Nếu đã tồn tại
                                header("Location:../../index.php?mod=loai&message=duplicate");
                        } else {
                                $data = ['tenloai' => $loai];
                                try {
                                        $db->update('loai', $data, array("maloai" => $id));
                                        header("Location:../../index.php?mod=loai&message=update");
                                        exit();
                                } catch (Exception $e) {
                                        header("Location:../../index.php?mod=loai&message=error");
                                }
                        }
                } else {
                        header("Location:../../index.php?mod=loai&message=invalid");
                }
        }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Xử lý xóa vai trò
        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
                $id = intval($_GET['id']);
                if ($id > 0) {
                        try {
                                $db->delete('loai', "maloai = $id");
                                header("Location:../../index.php?mod=loai&message=delsuccess");
                                exit();
                        } catch (Exception $e) {
                                header("Location:../../index.php?mod=loai&message=error");
                        }
                } else {
                        header("Location:../../index.php?mod=loai&message=invalid");
                }
        }
}
