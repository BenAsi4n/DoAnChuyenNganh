<?php
require_once(dirname(dirname(__DIR__)) . "/autoload/autoload.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['btn-Add'])) {
        $tensp = $_POST['tensp'] ?? '';
        $mota = $_POST['mota'] ?? '';
        $gia = $_POST['gia'] ?? 0;
        $soluong = $_POST['soluong'] ?? []; // Mảng số lượng theo kích thước
        $maloai = $_POST['maloai'] ?? '';
        // Kiểm tra và xử lý upload hình ảnh
        $uploadedImages = [];
        if (!empty($_FILES['hinh']['name'][0])) {
            $targetDir = "/public/img/"; // Đường dẫn tương đối
            $allowedTypes = ['jpg', 'jpeg', 'png', 'webp'];

            foreach ($_FILES['hinh']['name'] as $key => $filename) {
                $fileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                if (in_array($fileType, $allowedTypes)) {
                    $uniqueName = uniqid() . "_" . basename($filename); // Tạo tên file duy nhất
                    $targetFile = ROOT . $targetDir . $uniqueName; // Đường dẫn đầy đủ trên server
                    if (move_uploaded_file($_FILES['hinh']['tmp_name'][$key], $targetFile)) {
                        $uploadedImages[] = $targetDir . $uniqueName; // Lưu đường dẫn tương đối
                    }
                }
            }
        }
        // Đảm bảo tối thiểu 1 hình ảnh
        $hinh = $uploadedImages[0] ?? "";
        $hinh2 = $uploadedImages[1] ?? "";
        $hinh3 = $uploadedImages[2] ?? "";
        $hinh4 = $uploadedImages[3] ?? "";

        // Nếu không có hình ảnh, gán giá trị "" cho các hình ảnh còn lại
        if (!$hinh) {
            $hinh2 = $hinh3 = $hinh4 = "";
        }
        // Lưu thông tin sản phẩm vào bảng `sanpham`
        if ($tensp && $mota && $gia > 0 && !empty($soluong) && $maloai) {
            $data = [
                'tensp' => $tensp,
                'mota' => $mota,
                'gia' => $gia,
                'maloai' => $maloai,
                'hinh' => $hinh,
                'hinh2' => $hinh2,
                'hinh3' => $hinh3,
                'hinh4' => $hinh4
            ];
            $sanpham_id = $db->insert("sanpham", $data); // Trả về `masp` vừa thêm

            if ($sanpham_id) {
                // Lưu thông tin số lượng theo kích thước vào bảng `chitietsanpham`
                foreach ($soluong as $kichthuoc_id => $soLuong) {
                    if ($soLuong > 0) { // Chỉ lưu kích thước có số lượng lớn hơn 0
                        $detailData = [
                            'sanpham_id' => $sanpham_id,
                            'kichthuoc_id' => $kichthuoc_id,
                            'soluong' => $soLuong
                        ];
                        $db->insert("chitietsanpham", $detailData);
                    }
                }
                header("Location:../../index.php?mod=sanpham&message=success");
            } else {
                header("Location:../../index.php?mod=sanpham&message=error");
            }
        } else {
            header("Location:../../index.php?mod=sanpham&message=error");
        }
    } elseif (isset($_POST['btnEdit'])) {
        $sanpham_id = $_POST['id'] ?? null; // ID sản phẩm cần sửa
        $tensp = $_POST['tensp'] ?? '';
        $mota = $_POST['mota'] ?? '';
        $gia = $_POST['gia'] ?? 0;
        $soluong = $_POST['soluong'] ?? []; // Mảng số lượng theo kích thước
        $maloai = $_POST['maloai'] ?? '';

        // Kiểm tra và xử lý upload hình ảnh
        $uploadedImages = [];
        $targetDir = "/public/img/"; // Đường dẫn tương đối
        $allowedTypes = ['jpg', 'jpeg', 'png', 'webp'];

        $hinh = $_POST['hinh_cu'] ?? ""; // Lấy hình cũ nếu không upload mới
        $hinh2 = $_POST['hinh2_cu'] ?? "";
        $hinh3 = $_POST['hinh3_cu'] ?? "";
        $hinh4 = $_POST['hinh4_cu'] ?? "";

        foreach ($_FILES as $key => $file) {
            if (!empty($file['name']) && in_array(strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)), $allowedTypes)) {
                $uniqueName = uniqid() . "_" . basename($file['name']);
                $targetFile = ROOT . $targetDir . $uniqueName;
                if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                    if ($key === 'hinh') $hinh = $targetDir . $uniqueName;
                    if ($key === 'hinh2') $hinh2 = $targetDir . $uniqueName;
                    if ($key === 'hinh3') $hinh3 = $targetDir . $uniqueName;
                    if ($key === 'hinh4') $hinh4 = $targetDir . $uniqueName;
                }
            }
        }

        // Kiểm tra dữ liệu hợp lệ
        if ($sanpham_id && $tensp && $mota && $gia > 0 && !empty($maloai)) {
            // Cập nhật bảng `sanpham`
            $data = [
                'tensp' => $tensp,
                'mota' => $mota,
                'gia' => $gia,
                'maloai' => $maloai,
                'hinh' => $hinh,
                'hinh2' => $hinh2,
                'hinh3' => $hinh3,
                'hinh4' => $hinh4
            ];
                $updateResult = $db->update("sanpham", $data, array("masp" => $sanpham_id));
            
                // Xóa các chi tiết sản phẩm cũ trong bảng `chitietsanpham`
                $db->delete("chitietsanpham", "sanpham_id = $sanpham_id");

                // Lưu thông tin số lượng mới theo kích thước vào bảng `chitietsanpham`
                foreach ($soluong as $kichthuoc_id => $soLuong) {
                    if ($soLuong > 0) { // Chỉ lưu kích thước có số lượng lớn hơn 0
                        $detailData = [
                            'sanpham_id' => intval($sanpham_id),
                            'kichthuoc_id' => intval($kichthuoc_id),
                            'soluong' => intval($soLuong)
                        ];
                        $db->insert("chitietsanpham", $detailData);
                    }
                }
               header("Location:../../index.php?mod=sanpham&message=update");
           
                
                    
               // header("Location:../../index.php?mod=sanpham&message=error");
            
        } else {
            header("Location:../../index.php?mod=sanpham&message=invalid");
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Xử lý xóa vai trò
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        if ($id > 0) {
            try {
                $db->delete("sanpham", "masp = $id");
                header("Location:../../index.php?mod=sanpham&message=delsuccess");
                exit();
            } catch (Exception $e) {
                echo $e->getMessage();
                //  header("Location:../../index.php?mod=sanpham&message=error");
            }
        } else {
            header("Location:../../index.php?mod=sanpham&message=invalid");
        }
    }
}
