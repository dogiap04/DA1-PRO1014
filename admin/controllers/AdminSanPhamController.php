<?php
class AdminSanPhamController {

    public  $modelSanPham;
    public  $modelDanhMuc;
    public function __construct(){
        $this->modelSanPham = new AdminSanPham();
        $this->modelDanhMuc = new AdminDanhMuc();
    }

    public function danhSachSanPham(){

        $listSanPham = $this->modelSanPham->getAllSanPham();
        
       require_once './views/sanpham/listSanPham.php';
    }

    public function formAddSanPham(){
        // ham nay dung de hien thi form nhap
        $listDanhMuc = $this->modelDanhMuc->getAllDanhMuc();

        require_once './views/sanpham/addSanPham.php';


        //xóa session sau khi load trang
        deleteSessionError();
    }
    public function postAddSanPham(){
        // ham nay dung de xy ly them du lieu
       
        // kiểm tra xem dữ liệu có phải dc submit lên không 
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // lấy ra dữ liệu
            $ten_san_pham = $_POST['ten_san_pham'] ?? '';
            $gia_san_pham = $_POST['gia_san_pham'] ?? '';
            $gia_khuyen_mai	 = $_POST['gia_khuyen_mai'] ?? '';
            $so_luong = $_POST['so_luong'] ?? '';
            $ngay_nhap = $_POST['ngay_nhap'] ?? '';
            $danh_muc_id = $_POST['danh_muc_id'] ?? '';
            $trang_thai = $_POST['trang_thai'] ?? '';
            $mo_ta = $_POST['mo_ta'] ?? '';

            $hinh_anh = $_FILES['hinh_anh']?? null;

            //lưu hình ảnh vào
            $file_thumb = uploadFile($hinh_anh, './uploads/');


            //mảng hình ảnh
            $img_array =  $_FILES['img_array'];

            // tạo 1 bảng trống để chứa dữ liệu
            $errors = [];

            if (empty($ten_san_pham)){
                $errors['ten_san_pham'] = 'tên sản phẩm không được để trống';
            }

            if (empty($gia_san_pham)){
                $errors['gia_san_pham'] = 'giá sản phẩm không được để trống';
            }

            if (empty($gia_khuyen_mai)){
                $errors['gia_khuyen_mai'] = 'giá khuyến mãi sản phẩm không được để trống';
            }

            if (empty($so_luong)){
                $errors['so_luong'] = 'số lượng sản phẩm không được để trống';
            }

            if (empty($ngay_nhap)){
                $errors['$ngay_nhap'] = 'ngày nhập sản phẩm không được để trống';
            }

            if (empty($danh_muc_id)){
                $errors['$danh_muc_id'] = 'danh mục sản phẩm phải chọn';
            }

            if (empty($trang_thai)){
                $errors['trang_thai'] = 'trạng thái sản phẩm phải chọn';
            }

            if ($hinh_anh ['error'] !==0){
                $errors['hinh_anh'] = 'Phải chọn ảnh sản phẩm';
            }

            $_SESSION['error'] = $errors;


            //Nếu không có lỗi thì tiến hành trheem sản phẩm
            if(empty($errors)){
                //Nếu không có lỗi thì tiến hành trheem sản phẩm
                // var_dump('oke');
              $san_pham_id = $this->modelSanPham->insertSanPham($ten_san_pham,
                                                   $gia_san_pham,
                                                   $gia_khuyen_mai,
                                                   $so_luong,
                                                   $ngay_nhap,
                                                   $danh_muc_id,
                                                   $trang_thai,
                                                   $mo_ta,
                                                   $file_thumb)
                                                   ;
                //Xử lý thêm album ảnh sản phẩm img_array

                if(!empty($img_array['name'])){
                    foreach ($img_array['name'] as $key=>$value){
                        $file = [
                            'name' => $img_array['name'][$key],
                            'type' => $img_array['type'][$key],
                            'tmp_name' => $img_array['tmp_name'][$key],
                            'error' => $img_array['error'][$key],
                            'size' => $img_array['size'][$key],
                        ];
                        $link_hinh_anh = uploadFile($file, './uploads/');
                        $this->modelSanPham->insertAlbumAnhSanPham($san_pham_id, $link_hinh_anh);
                    }
                }


                header("Location: ". BASE_URL_ADMIN . '?act=san-pham' );
                exit();
            } else {
                // tra về form và lôix
                
                //Đatwh chỉ thị xóa session sau khi hiện thị form
                $_SESSION[''] = true;

                header("Location: ". BASE_URL_ADMIN . '?act=form-them-san-pham' );
                exit();
            }
        }
    }



    public function formEditSanPham(){
        // ham nay dung de hien thi form nhap
        //lấy ra thông tin sản phẩm cần sửa
        $id = $_GET['id_san_pham'];
        $sanPham = $this->modelSanPham->getDetailSanPham($id);
        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);
        $listDanhMuc = $this->modelDanhMuc->getAllDanhMuc();
        if($sanPham){
            require_once './views/sanpham/editSanPham.php';
            deleteSessionError();
        } else{
            header("Location: ". BASE_URL_ADMIN . '?act=san-pham' );
            exit();
        }  
    }
    public function postEditSanPham(){
        // ham nay dung de xy ly them du lieu
       
        // kiểm tra xem dữ liệu có phải dc submit lên không 
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // lấy ra dữ liệu
            // Lấy ra dữ liệu cũ của sản phẩm
            $san_pham_id = $_POST['san_pham_id'] ?? '';
            // truy vấn
            $sanPhamOld = $this->modelSanPham->getDetailSanPham($san_pham_id);
            $old_file = $sanPhamOld['hinh_anh']; // lấy ảnh cũ để phục vụ cho sửa ảnh
            

            $ten_san_pham = $_POST['ten_san_pham'] ?? '';
            $gia_san_pham = $_POST['gia_san_pham'] ?? '';
            $gia_khuyen_mai	 = $_POST['gia_khuyen_mai'] ?? '';
            $so_luong = $_POST['so_luong'] ?? '';
            $ngay_nhap = $_POST['ngay_nhap'] ?? '';
            $danh_muc_id = $_POST['danh_muc_id'] ?? '';
            $trang_thai = $_POST['trang_thai'] ?? '';
            $mo_ta = $_POST['mo_ta'] ?? '';

            $hinh_anh = $_FILES['hinh_anh']?? null;




            // tạo 1 bảng trống để chứa dữ liệu
            $errors = [];

            if (empty($ten_san_pham)){
                $errors['ten_san_pham'] = 'tên sản phẩm không được để trống';
            }

            if (empty($gia_san_pham)){
                $errors['gia_san_pham'] = 'giá sản phẩm không được để trống';
            }

            if (empty($gia_khuyen_mai)){
                $errors['gia_khuyen_mai'] = 'giá khuyến mãi sản phẩm không được để trống';
            }

            if (empty($so_luong)){
                $errors['so_luong'] = 'số lượng sản phẩm không được để trống';
            }

            if (empty($ngay_nhap)){
                $errors['$ngay_nhap'] = 'ngày nhập sản phẩm không được để trống';
            }

            if (empty($danh_muc_id)){
                $errors['$danh_muc_id'] = 'danh mục sản phẩm phải chọn';
            }

            if (empty($trang_thai)){
                $errors['trang_thai'] = 'trạng thái sản phẩm phải chọn';
            }
            
            $_SESSION['error'] = $errors;


            //logic sửa ảnh
            if(isset($hinh_anh) && $hinh_anh['error']  == UPLOAD_ERR_OK){
                // uplaod ảnh mới lên
                $new_file = uploadFile($hinh_anh, '/uploads/');

                if (!empty($old_file)){  // nếu có ảnh cũ thì xóa đi
                    deleteFile($old_file);
                }
            }else{
                $new_file = $old_file;
            }


            //Nếu không có lỗi thì tiến hành trheem sản phẩm
            if(empty($errors)){
                //Nếu không có lỗi thì tiến hành trheem sản phẩm
                // var_dump('oke');
             $this->modelSanPham->updateSanPham(
                                                   $san_pham_id,
                                                   $ten_san_pham,
                                                   $gia_san_pham,
                                                   $gia_khuyen_mai,
                                                   $so_luong,
                                                   $ngay_nhap,
                                                   $danh_muc_id,
                                                   $trang_thai,
                                                   $mo_ta,
                                                   $new_file
                                                   );
                // var_dump($status);die();

                header("Location: ". BASE_URL_ADMIN . '?act=san-pham' );
                exit();
            } else {
                // tra về form và lôix
                
                //Đatwh chỉ thị xóa session sau khi hiện thị form
                $_SESSION[''] = true;

                header("Location: ". BASE_URL_ADMIN . '?act=form-sua-san-pham&id_san_pham=' . $san_pham_id );
                exit();
            }
        }
    }

    // Sửa album ảnh
    //  - Sửa ảnh cũ
    //    + Thêm ảnh mới
    //    + Không thêm ảnh mới
    //  - Không sửa ảnh cũ
    //    + Thêm ảnh mới
    //    + Không thêm ảnh mới
    // - Xóa ảnh cũ
    //    + Thêm ảnh mới
    //    + Không thêm ảnh mới

    public function postEditAnhSanPham(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $san_pham_id = $_POST['san_pham_id'] ?? '';

            // lấy danh sách ảnh hiện tại của sản phẩm
            $listAnhSanPhamCurrent = $this->modelSanPham->getListAnhSanPham($san_pham_id);

            // xử lý các ảnh được gửi từ from
            $img_array = $_FILES['img_array'];
            $img_delete = isset($_POST['img_delete']) ? explode(',', $_POST['img_delete']) : [];
            $current_img_ids = $_POST['current_img_ids'] ?? [];

            // khai báo mảng để lưu hình ảnh thêm mới hoặc thay thế ảnh cũ
            $upload_file = [];

            // upload ảnh mới hoặc thay thế ảnh cũ
            foreach($img_array['name'] as $key=>$value){
                if($img_array['error'][$key] == UPLOAD_ERR_OK){
                    $new_file = uploadFileAlbum($img_array, '/uploads/', $key);
                    if ($new_file){
                        $upload_file[] = [
                            'id' => $current_img_ids[$key] ?? null,
                            'file' => $new_file
                        ];
                    }
                }
            }

            // lưu hình ảnh và xóa hình ảnh cũ nếu có
            foreach($upload_file as $file_info){
                if($file_info['id']){
                    $old_file = $this->modelSanPham->getDetailAnhSanPham($file_info['id'])['link_hinh_anh'];


                    // cập nhật ảnh cũ
                    $this->modelSanPham->updateAnhSanPham($file_info['id'], $file_info['file']);

                    // xóa ảnh cũ
                    deleteFile($old_file);
                }else{
                    // thêm ảnh mới
                    $this->modelSanPham->insertAlbumAnhSanPham($san_pham_id, $file_info['file']);
                }
            }

            // Xử lý xóa ảnh
            foreach($listAnhSanPhamCurrent as $anhSP){
                $anh_id = $anhSP['id'];
                if(in_array($anh_id, $img_delete)){
                    //xóa ảnh trong db
                    $this->modelSanPham->destroyAnhSanPham($anh_id);

                    //xóa file
                    deleteFile($anhSP['link_hinh_anh']);

                }
            }

            header("Location: ". BASE_URL_ADMIN . '?act=form-sua-san-pham&id_san_pham=' . $san_pham_id );
            exit();

        }
    }



    public function deleteSanPham (){
        $id = $_GET['id_san_pham'];
        $sanPham = $this->modelSanPham->getDetailSanPham($id);

        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);

        if ($sanPham){
            deleteFile($sanPham['hinh_anh']);
            $this->modelSanPham->destroySanPham($id);           
        }
        if($listAnhSanPham){
            foreach($listAnhSanPham as $key=>$anhSP){
                deleteFile($anhSP['link_hinh_anh']);
                $this->modelSanPham->destroyAnhSanPham($anhSP['id']);
            }
        }
        header("Location: ". BASE_URL_ADMIN . '?act=san-pham' );
        exit();
    }

    public function detailSanPham(){

        $id = $_GET['id_san_pham'];

        $sanPham = $this->modelSanPham->getDetailSanPham($id);

        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);

        if($sanPham){
            require_once './views/sanpham/detailSanPham.php';

        } else{
            header("Location: ". BASE_URL_ADMIN . '?act=san-pham' );
            exit();
        }  
    }
}
