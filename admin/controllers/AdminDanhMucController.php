<?php

class AdminDanhMucController {
    public $modelDanhMuc;
    public function __construct(){
        $this->modelDanhMuc = new AdminDanhMuc();
    }
    public function danhSachDanhMuc(){
        
        $listDanhMuc = $this->modelDanhMuc->getAllDanhMuc();
        require_once './views/danhmuc/listDanhMuc.php';
    }

    public function formAddDanhMuc(){
        // ham nay dung de hien thi form nhap
        require_once './views/danhmuc/addDanhMuc.php';

    }

    public function postAddDanhMuc(){
        // ham nay dung de xy ly them du lieu
       
        // kiểm tra xem dữ liệu có phải dc submit lên không 
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // lấy ra dữ liệu
            $ten_danh_muc = $_POST['ten_danh_muc'];
            $mo_ta = $_POST['mo_ta'];

            // tạo 1 bảng trống để chứa dữ liệu
            $errors = [];
            if (empty($ten_danh_muc)){
                $errors['ten_danh_muc'] = 'tên danh mục không được để trống';
            }

            //Nếu không có lỗi thì tiến hành trheem danh mục
            if(empty($errors)){
                //Nếu không có lỗi thì tiến hành trheem danh mục
                // var_dump('oke');
                $this->modelDanhMuc->insertDanhMuc($ten_danh_muc, $mo_ta);
                header("Location: ". BASE_URL_ADMIN . '?act=danh-muc' );
                exit();
            } else {
                // tra về form và lôix
                require_once './views/danhmuc/addDanhMuc.php';
            }
        }
    }

    public function formEditDanhMuc(){
        // ham nay dung de hien thi form nhap
        //lấy ra thông tin danh mục cần sửa
        $id = $_GET['id_danh_muc'];
        $danhMuc = $this->modelDanhMuc->getDetailDanhMuc($id);
        if($danhMuc){
            require_once './views/danhmuc/editDanhMuc.php';
        } else{
            header("Location: ". BASE_URL_ADMIN . '?act=danh-muc' );
            exit();
        }
        
    }
    public function postEditDanhMuc(){
        // ham nay dung de xy ly them du lieu
       
        // kiểm tra xem dữ liệu có phải dc submit lên không 
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // lấy ra dữ liệu
            $id = $_POST['id'];
            $ten_danh_muc = $_POST['ten_danh_muc'];
            $mo_ta = $_POST['mo_ta'];

            // tạo 1 bảng trống để chứa dữ liệu
            $errors = [];
            if (empty($ten_danh_muc)){
                $errors['ten_danh_muc'] = 'tên danh mục không được để trống';
            }

            //Nếu không có lỗi thì tiến hành sửa danh mục
            if(empty($errors)){
                //Nếu không có lỗi thì tiến hành sửa danh mục
                // var_dump('oke');
                $this->modelDanhMuc->updateDanhMuc($id, $ten_danh_muc, $mo_ta);
                header("Location: ". BASE_URL_ADMIN . '?act=danh-muc' );
                exit();
            } else {
                // tra về form và lôix
                $danhMuc = ['id' => $id, 'ten_danh_muc' => $ten_danh_muc, 'mo_ta' => $mo_ta];
                require_once './views/danhmuc/editDanhMuc.php';
            }
        }
    }

    public function deleteDanhMuc (){
        $id = $_GET['id_danh_muc'];
        $danhMuc = $this->modelDanhMuc->getDetailDanhMuc($id);

        if ($danhMuc){
            $this->modelDanhMuc->destroyDanhMuc($id);
        }
        header("Location: ". BASE_URL_ADMIN . '?act=danh-muc' );
        exit();
    }


}