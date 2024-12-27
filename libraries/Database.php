<?php
class Database
{
    public $link;

    public function __construct()
    {
        // Kết nối đến cơ sở dữ liệu
        $this->link = mysqli_connect("localhost", "root", "", "db_webquanao");
        if (!$this->link) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($this->link, "utf8");
    }

    public function insert($table, array $data)
    {
        // Tạo câu lệnh INSERT
        $columns = implode(',', array_keys($data));
        $values = [];

        foreach ($data as $field => $value) {
            if (is_string($value)) {
                $values[] = "'" . mysqli_real_escape_string($this->link, $value) . "'";
            } else {
                $values[] = mysqli_real_escape_string($this->link, $value);
            }
        }

        $sql = "INSERT INTO {$table} ($columns) VALUES (" . implode(',', $values) . ")";
        mysqli_query($this->link, $sql) or die("Error inserting data: " . mysqli_error($this->link));
        return mysqli_insert_id($this->link);
    }

    public function update($table, array $data, array $conditions)
    {
        // Tạo câu lệnh UPDATE
        $set = [];
        foreach ($data as $field => $value) {
            if (is_string($value)) {
                $set[] = "$field='" . mysqli_real_escape_string($this->link, $value) . "'";
            } else {
                $set[] = "$field=" . mysqli_real_escape_string($this->link, $value);
            }
        }

        $sql = "UPDATE {$table} SET " . implode(',', $set);

        $where = [];
        foreach ($conditions as $field => $value) {
            if (is_string($value)) {
                $where[] = "$field='" . mysqli_real_escape_string($this->link, $value) . "'";
            } else {
                $where[] = "$field=" . mysqli_real_escape_string($this->link, $value);
            }
        }
        if (!empty($where)) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }

        mysqli_query($this->link, $sql) or die("Error updating data: " . mysqli_error($this->link));
        return mysqli_affected_rows($this->link);
    }

    public function fetchAll($table, $conditions = null)
    {
        // Lấy tất cả dữ liệu từ bảng
        $sql = "SELECT * FROM {$table}";
        if ($conditions) {
            $sql .= " WHERE " . $conditions;
        }
        $result = mysqli_query($this->link, $sql) or die("Error fetching data: " . mysqli_error($this->link));
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }

    public function fetchID($table, $id)
    {
        // Lấy một bản ghi theo ID
        $sql = "SELECT * FROM {$table} WHERE id = " . intval($id);
        $result = mysqli_query($this->link, $sql) or die("Error fetching data: " . mysqli_error($this->link));
        return mysqli_fetch_assoc($result);
    }

    public function fetchOne($table, $query)
    {
        // Lấy một bản ghi theo điều kiện
        $sql = "SELECT * FROM {$table} WHERE " . $query . " LIMIT 1";
        $result = mysqli_query($this->link, $sql) or die("Error fetching data: " . mysqli_error($this->link));
        return mysqli_fetch_assoc($result);
    }

    public function getCart()
    {
        // Kiểm tra xem giỏ hàng có tồn tại trong session không
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); // Khởi động session nếu chưa được khởi động
        }
        return isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    }

    public function delete($table, $id = null)
    {
        // Xóa bản ghi theo ID
        $sql = "DELETE FROM {$table} WHERE " . $id;
        mysqli_query($this->link, $sql) or die("Error deleting data: " . mysqli_error($this->link));
        return mysqli_affected_rows($this->link);
    }
    public function deleteCart($table, $condition)
    {
        // Xóa bản ghi theo điều kiện
        $sql = "DELETE FROM {$table} WHERE {$condition}";
        mysqli_query($this->link, $sql) or die("Error deleting data: " . mysqli_error($this->link));
        return mysqli_affected_rows($this->link);
    }
    public function countTable($table)
    {
        // Đếm số lượng bản ghi trong bảng
        $sql = "SELECT COUNT(*) as count FROM {$table}";
        $result = mysqli_query($this->link, $sql) or die("Error counting records: " . mysqli_error($this->link));
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    }
    public function calculateTotalAmount($cartItems)
    {
        $total = 0;
        foreach ($cartItems as $item) {
            $product = $this->fetchOne("product", "id = " . intval($item['product_id']));
            if ($product) {
                $total += $product['price'] * intval($item['soluong']);
            }
        }
        return $total;
    }
    public function fetchsql(){}
    public function lastInsertId()
    {
    return mysqli_insert_id($this->link);
    }

}
