<?php 

class HomeController
{
    public $modelSanPham;

    public function __construct(){
        $this->modelSanPham = new SanPham();
    }
    public function home(){
        echo "dday laf hom 123";
    }
    public function trangChu(){
        echo "day la trang chu";
    }
    public function danhSachSanPham(){
        // echo "day la trang danh sach san pham";
        $listProduct = $this->modelSanPham->getAllProduct(); //
        // var_dump($listProduct);die();
        require_once './views/listProduct.php';
    }

}