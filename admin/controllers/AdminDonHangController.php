<?php
class AdminDonHangController
{

    public $modelDonHang;

    public function __construct()
    {
        $this->modelDonHang = new AdminDonHang();
    }

    public function danhSachDonHang()
    {

        $listDonHang = $this->modelDonHang->getAllDonHang();

        require_once './views/donhang/listDonHang.php';
    }

    public function detailDonHang(){
        $don_hang_id = $_GET['id_don_hang'];
        
        //lấy thông tin đơn hàng ở bảng don_hangs
        $donHang = $this->modelDonHang->getDetailDonHang($don_hang_id);

        //lấy danh sách sản phẩm dã đặt của đơn hàng ở bảng chi_tiet_don_hangs
        $sanPhamDonHang = $this->modelDonHang->getListSpDonHang($don_hang_id);

        $listTrangThaiDonHang = $this->modelDonHang->getAllTrangThaiDonHang();


        require_once './views/donhang/detailDonHang.php';


    }




    public function formEditDonHang(){

        $id = $_GET['id_don_hang'];
        $donHang = $this->modelDonHang->getDetailDonHang($id);
        $listTrangThaiDonHang = $this->modelDonHang->getAllTrangThaiDonHang();
        if($donHang){
            require_once './views/donhang/editDonHang.php';
            deleteSessionError();
        } else{
            header("Location: ". BASE_URL_ADMIN . '?act=don-hang' );
            exit();
        }  
    }

    public function postEditDonHang(){
        // ham nay dung de xy ly them du lieu

        // kiểm tra xem dữ liệu có phải dc submit lên không 
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // lấy ra dữ liệu
            // Lấy ra dữ liệu cũ của sản phẩm
            $don_hang_id = $_POST['don_hang_id'] ?? '';
    
            

            $ten_nguoi_nhan = $_POST['ten_nguoi_nhan'] ?? '';
            $sdt_nguoi_nhan = $_POST['sdt_nguoi_nhan'] ?? '';
            $email_nguoi_nhan = $_POST['email_nguoi_nhan'] ?? '';
            $dia_chi_nguoi_nhan = $_POST['dia_chi_nguoi_nhan'] ?? '';
            $ghi_chu = $_POST['ghi_chu'] ?? '';
            $trang_thai_id = $_POST['trang_thai_id'] ?? '';
       
            // tạo 1 bảng trống để chứa dữ liệu
            $errors = [];

            if (empty($ten_nguoi_nhan)){
                $errors['ten_nguoi_nhan'] = 'Tên người nhận không được để trống';
            }

            if (empty($sdt_nguoi_nhan)){
                $errors['sdt_nguoi_nhan'] = 'SDT người nhận không được để trống';
            }

            if (empty($email_nguoi_nhan)){
                $errors['email_nguoi_nhan'] = 'Email người nhận không được để trống';
            }

            if (empty($dia_chi_nguoi_nhan)){
                $errors['dia_chi_nguoi_nhan'] = 'Địa chỉ người nhận không được để trống';
            }

            if (empty($trang_thai_id)){
                $errors['trang_thai_id'] = 'Trạng thái đơn hàng';
            }

            $_SESSION['error'] = $errors;


            //Nếu không có lỗi thì tiến hành trheem sản phẩm
            if(empty($errors)){
                //Nếu không có lỗi thì tiến hành sửa
                // var_dump('oke');
            $this->modelDonHang->updateDonHang(   $don_hang_id,
                                                   $ten_nguoi_nhan,
                                                   $sdt_nguoi_nhan,
                                                   $email_nguoi_nhan,
                                                   $dia_chi_nguoi_nhan,
                                                   $ghi_chu,
                                                   $trang_thai_id
                                                   );
                // var_dump($abc);die();

                header("Location: ". BASE_URL_ADMIN . '?act=don-hang' );
                exit();
            } else {
                //Đatwh chỉ thị xóa session sau khi hiện thị form
                $_SESSION[''] = true;

                header("Location: ". BASE_URL_ADMIN . '?act=form-sua-don-hang&id_don_hang=' . $don_hang_id );
                exit();
            }
        }
    }

    // // Sửa album ảnh
    // //  - Sửa ảnh cũ
    // //    + Thêm ảnh mới
    // //    + Không thêm ảnh mới
    // //  - Không sửa ảnh cũ
    // //    + Thêm ảnh mới
    // //    + Không thêm ảnh mới
    // // - Xóa ảnh cũ
    // //    + Thêm ảnh mới
    // //    + Không thêm ảnh mới

    // public function postEditAnhSanPham(){
    //     if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //         $san_pham_id = $_POST['san_pham_id'] ?? '';

    //         // lấy danh sách ảnh hiện tại của sản phẩm
    //         $listAnhSanPhamCurrent = $this->modelSanPham->getListAnhSanPham($san_pham_id);

    //         // xử lý các ảnh được gửi từ from
    //         $img_array = $_FILES['img_array'];
    //         $img_delete = isset($_POST['img_delete']) ? explode(',', $_POST['img_delete']) : [];
    //         $current_img_ids = $_POST['current_img_ids'] ?? [];

    //         // khai báo mảng để lưu hình ảnh thêm mới hoặc thay thế ảnh cũ
    //         $upload_file = [];

    //         // upload ảnh mới hoặc thay thế ảnh cũ
    //         foreach($img_array['name'] as $key=>$value){
    //             if($img_array['error'][$key] == UPLOAD_ERR_OK){
    //                 $new_file = uploadFileAlbum($img_array, '/uploads/', $key);
    //                 if ($new_file){
    //                     $upload_file[] = [
    //                         'id' => $current_img_ids[$key] ?? null,
    //                         'file' => $new_file
    //                     ];
    //                 }
    //             }
    //         }

    //         // lưu hình ảnh và xóa hình ảnh cũ nếu có
    //         foreach($upload_file as $file_info){
    //             if($file_info['id']){
    //                 $old_file = $this->modelSanPham->getDetailAnhSanPham($file_info['id'])['link_hinh_anh'];


    //                 // cập nhật ảnh cũ
    //                 $this->modelSanPham->updateAnhSanPham($file_info['id'], $file_info['file']);

    //                 // xóa ảnh cũ
    //                 deleteFile($old_file);
    //             }else{
    //                 // thêm ảnh mới
    //                 $this->modelSanPham->insertAlbumAnhSanPham($san_pham_id, $file_info['file']);
    //             }
    //         }

    //         // Xử lý xóa ảnh
    //         foreach($listAnhSanPhamCurrent as $anhSP){
    //             $anh_id = $anhSP['id'];
    //             if(in_array($anh_id, $img_delete)){
    //                 //xóa ảnh trong db
    //                 $this->modelSanPham->destroyAnhSanPham($anh_id);

    //                 //xóa file
    //                 deleteFile($anhSP['link_hinh_anh']);

    //             }
    //         }

    //         header("Location: ". BASE_URL_ADMIN . '?act=form-sua-san-pham&id_san_pham=' . $san_pham_id );
    //         exit();

    //     }
    // }



    // public function deleteSanPham (){
    //     $id = $_GET['id_san_pham'];
    //     $sanPham = $this->modelSanPham->getDetailSanPham($id);

    //     $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);

    //     if ($sanPham){
    //         deleteFile($sanPham['hinh_anh']);
    //         $this->modelSanPham->destroySanPham($id);           
    //     }
    //     if($listAnhSanPham){
    //         foreach($listAnhSanPham as $key=>$anhSP){
    //             deleteFile($anhSP['link_hinh_anh']);
    //             $this->modelSanPham->destroyAnhSanPham($anhSP['id']);
    //         }
    //     }
    //     header("Location: ". BASE_URL_ADMIN . '?act=san-pham' );
    //     exit();
    // }

    // public function detailSanPham(){

    //     $id = $_GET['id_san_pham'];

    //     $sanPham = $this->modelSanPham->getDetailSanPham($id);

    //     $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);

    //     if($sanPham){
    //         require_once './views/sanpham/detailSanPham.php';

    //     } else{
    //         header("Location: ". BASE_URL_ADMIN . '?act=san-pham' );
    //         exit();
    //     }  
    // }
}
