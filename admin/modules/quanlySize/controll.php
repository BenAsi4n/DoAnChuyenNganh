<?php
require_once(dirname(dirname(__DIR__)) . "/autoload/autoload.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['submitAdd'])) {
                $size = trim(postInput('size'));

                if ($size != '') {
                        $check = $db->fetchAll("sanpham_kichthuoc", "tenkichthuoc = " . '"' . $size . '"' . " LIMIT 1");

                        if ($check) {
                                // Nếu đã tồn tại
                                header("Location:../../index.php?mod=size&message=duplicate");
                        } else {
                                $data = ['tenkichthuoc' => $size];
                                try {
                                        $db->insert('sanpham_kichthuoc', $data);
                                        header("Location:../../index.php?mod=size&message=success");
                                        exit();
                                } catch (Exception $e) {
                                        header("Location:../../index.php?mod=size&message=error");
                                }
                        }
                } else {
                        header("Location:../../index.php?mod=size&message=empty");
                }
        } else if (isset($_POST['submitEdit']) && isset($_POST['id'])) {

                $id = intval($_POST['id']); // Lấy giá trị id từ POST
                $size = trim(postInput('size'));


                if ($size != '' && $id > 0) {
                        $check = $db->fetchAll("sanpham_kichthuoc", "tenkichthuoc = " . '"' . $size . '"' . " LIMIT 1");

                        if ($checkLoai) {
                                // Nếu đã tồn tại
                                header("Location:../../index.php?mod=size&message=duplicate");
                        } else {
                                $data = ['tenkichthuoc' => $size];
                                try {
                                        $db->update('sanpham_kichthuoc', $data, array("id" => $id));
                                        header("Location:../../index.php?mod=size&message=update");
                                        exit();
                                } catch (Exception $e) {
                                        header("Location:../../index.php?mod=size&message=error");
                                }
                        }
                } else {
                        header("Location:../../index.php?mod=size&message=invalid");
                }
        }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
                $id = intval($_GET['id']);
                if ($id > 0) {
                        try {
                                $db->delete('sanpham_kichthuoc', "id = $id");
                                header("Location:../../index.php?mod=size&message=delsuccess");
                                exit();
                        } catch (Exception $e) {
                                header("Location:../../index.php?mod=size&message=error");
                        }
                } else {
                        header("Location:../../index.php?mod=size&message=invalid");
                }
        }
}
