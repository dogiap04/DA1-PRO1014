<?php

class SanPham {
    public $conn; // khai báo phương thức
    
    public function __construct(){
        $this->conn = connectDB();
    }

    // viet ham lay toan bo san pham

    public function getAllProduct() {
        try{
            $sql = 'SELECT * FROM san_phams';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll();

        }catch (Exception $e) {
            echo $e->getMessage() . "Lỗi";
        }

    }
}