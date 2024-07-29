<?php
class AdminDonHang
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getAllDonHang()
    {
        try {
            $sql = 'SELECT don_hangs.id, `ma_don_hang`, `tai_khoan_id`, `ten_nguoi_nhan`, `email_nguoi_nhan`, `sdt_nguoi_nhan`, 
                    `dia_chi_nguoi_nhan`, `ngay_dat`, `tong_tien`, `ghi_chu`, `phuong_thuc_thanh_toan_id`, trang_thai_don_hangs.ten_trang_thai 
                    FROM `don_hangs` 
                    INNER JOIN trang_thai_don_hangs on don_hangs.trang_thai_id = trang_thai_don_hangs.id';
            $stmt = $this->conn->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll();

        } catch (Exception $e) {
            echo 'lỗi' . $e->getMessage();

        }
    }

    public function getAllTrangThaiDonHang()
    {
        try {
            $sql = 'SELECT * FROM trang_thai_don_hangs';
            $stmt = $this->conn->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll();

        } catch (Exception $e) {
            echo 'lỗi' . $e->getMessage();

        }
    }

    
    public function getDetailDonHang($id){
        try{
            $sql = 'SELECT don_hangs.*, trang_thai_don_hangs.ten_trang_thai, 
            tai_khoans.ho_ten, tai_khoans.email, tai_khoans.so_dien_thoai,
            phuong_thuc_thanh_toans.ten_phuong_thuc
            FROM don_hangs
            INNER JOIN trang_thai_don_hangs ON  don_hangs.trang_thai_id = trang_thai_don_hangs.id   
            INNER JOIN tai_khoans ON  don_hangs.tai_khoan_id = tai_khoans.id 
            INNER JOIN phuong_thuc_thanh_toans ON  don_hangs.phuong_thuc_thanh_toan_id = phuong_thuc_thanh_toans.id 
            WHERE don_hangs.id = :id';


            $stmt = $this->conn->prepare($sql);

            $stmt->execute([':id' => $id]);

            return $stmt->fetch();

        } catch(Exception $e){
            echo 'lỗi' .$e->getMessage();
        }
    }  

    public function getListSpDonHang($id){
        try{
            $sql = 'SELECT chi_tiet_don_hangs.*, san_phams.ten_san_pham
            FROM chi_tiet_don_hangs  
            INNER JOIN san_phams ON  chi_tiet_don_hangs.san_pham_id = san_phams.id 
            WHERE chi_tiet_don_hangs.don_hang_id = :id';


            $stmt = $this->conn->prepare($sql);

            $stmt->execute([':id' => $id]);

            return $stmt->fetchAll();

        } catch(Exception $e){
            echo 'lỗi' .$e->getMessage();
        }
    } 

   



    public function updateDonHang($id, $ten_nguoi_nhan, $sdt_nguoi_nhan, $email_nguoi_nhan, $dia_chi_nguoi_nhan, $ghi_chu, $trang_thai_id){
        try{
            // var_dump($id);die();
            $sql = ' UPDATE don_hangs
                    SET 
                         ten_nguoi_nhan = :ten_nguoi_nhan,
                         sdt_nguoi_nhan = :sdt_nguoi_nhan,
                         email_nguoi_nhan = :email_nguoi_nhan,
                         dia_chi_nguoi_nhan = :dia_chi_nguoi_nhan,
                         ghi_chu = :ghi_chu,
                         trang_thai_id = :trang_thai_id
                    WHERE id = :id';
            // var_dump($iql);die();
            $stmt = $this->conn->prepare($sql);
            // var_dump($stmt);die();
            $stmt->execute([
                ':ten_nguoi_nhan' => $ten_nguoi_nhan,
                ':sdt_nguoi_nhan' => $sdt_nguoi_nhan,
                ':email_nguoi_nhan' => $email_nguoi_nhan,
                ':dia_chi_nguoi_nhan' => $dia_chi_nguoi_nhan,
                ':ghi_chu' => $ghi_chu,
                ':trang_thai_id' => $trang_thai_id,
                ':id' => $id
            ]);

            // lấy id sản phẩm vừa thêm
            return true;

        } catch(Exception $e){
            echo 'lỗi' .$e->getMessage();

        }
    }

    // public function getDetailAnhSanPham($id){
    //     try{
    //         $sql = 'SELECT * FROM hinh_anh_san_phams WHERE id = :id';
    //         $stmt = $this->conn->prepare($sql);

    //         $stmt->execute([':id' => $id]);

    //         return $stmt->fetch();

    //     } catch(Exception $e){
    //         echo 'lỗi' .$e->getMessage();

    //     }
    // } 


    // public function updateAnhSanPham($id,$new_file){
    //     try{
    //         $sql = ' UPDATE hinh_anh_san_phams
    //                 SET 
    //                   link_hinh_anh = :new_file
    //                 WHERE id = :id';

    //         $stmt = $this->conn->prepare($sql);

    //         $stmt->execute([
    //             ':new_file' => $new_file,
    //             ':id' => $id


    //         ]);

    //         // lấy id sản phẩm vừa thêm
    //         return true;

    //     } catch(Exception $e){
    //         echo 'lỗi' .$e->getMessage();

    //     }
    // }

    // public function destroyAnhSanPham($id){
    //     try{
    //         $sql = 'DELETE FROM hinh_anh_san_phams WHERE id = :id';

    //         $stmt = $this->conn->prepare($sql);

    //         $stmt->execute([
    //             ':id' => $id
    //         ]);

    //         return true;

    //     } catch(Exception $e){
    //         echo 'lỗi' .$e->getMessage();

    //     }
    // }

    // public function destroySanPham($id){
    //     try{
    //         $sql = 'DELETE FROM san_phams WHERE id = :id';

    //         $stmt = $this->conn->prepare($sql);

    //         $stmt->execute([
    //             ':id' => $id
    //         ]);

    //         return true;

    //     } catch(Exception $e){
    //         echo 'lỗi' .$e->getMessage();

    //     }
    // }
}