<?php
require_once(dirname(dirname(__DIR__)) . "/autoload/autoload.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       $ngaygiao = date("Y-m-d H:i:s");
       $id =  intval($_POST['id']);
       if (isset($_POST['xacnhan'])) {
              try{
                     $data = ["tinhtrang" => "Đã xác nhận",
                            "ngaygiao" => $ngaygiao ];
                     $db->update('hoadon', $data, array("id_hoadon" => $id));
                     header("Location:../../index.php?mod=hoadon&message=update");
                     exit();
              }catch (Exception $e){
                     $e->getMessage();
                     header("Location:../../index.php?mod=hoadon&message=error");
              }

       } elseif (isset($_POST['dagiao'])) {
              try {
                     $data = ["tinhtrang" => "Đã giao",
                     "ngaygiao" => $ngaygiao];
                     $db->update('hoadon', $data, array("id_hoadon" => $id));
                     header("Location:../../index.php?mod=hoadon&message=update");
                     exit();
                 } catch (Exception $e) {
                     $e->getMessage();
                     header("Location:../../index.php?mod=hoadon&message=error");
                 }
       } elseif (isset($_POST['chitiet'])) {
              header("Location:../../index.php?mod=chitiethoadon&id=" . $id);
    exit();
       }
}
