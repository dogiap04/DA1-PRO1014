<!-- Header -->
<?php require './views/layout/header.php'; ?>
<!-- end Header -->
<!-- Navbar -->
<?php include './views/layout/navbar.php'; ?>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<?php include './views/layout/slidebar.php'; ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Quản lý danh mục sản phẩm</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Nội dung của bảng -->
  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card card-solid">
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-sm-6">
            <div class="col-12">
              <img style="width:400px; height: 400px;" src="<?= BASE_URL . $sanPham['hinh_anh'] ?>"
                class="product-image" alt="Product Image">
            </div>
            <div class="col-12 product-image-thumbs">
              <?php foreach ($listAnhSanPham as $key => $anhSP): ?>
                <div class="product-image-thumb <?= $anhSP[$key] == 0 ? 'active' : '' ?>"><img
                    src="<?= BASE_URL . $anhSP['link_hinh_anh']; ?>" alt="Product Image"></div>
              <?php endforeach ?>
            </div>
          </div>
          <div class="col-12 col-sm-6">
            <h3 class="my-3">Tên sản phẩm: <span class="text-primary"><?= $sanPham['ten_san_pham'] ?></span></h3>
            <hr>
            <div class="mt-3">
              <h4>Giá tiền: <small class="text-muted"><?= $sanPham['gia_san_pham'] ?></small></h4>
            </div>
            <div class="mt-3">
              <h4>Giá khuyến mãi: <small class="text-danger"><?= $sanPham['gia_khuyen_mai'] ?></small></h4>
            </div>
            <div class="mt-3">
              <h4>Số lượng: <small class="text-muted"><?= $sanPham['so_luong'] ?></small></h4>
            </div>
            <div class="mt-3">
              <h4>Lượt xem: <small class="text-muted"><?= $sanPham['luot_xem'] ?></small></h4>
            </div>
            <div class="mt-3">
              <h4>Ngày nhập: <small class="text-muted"><?= $sanPham['ngay_nhap'] ?></small></h4>
            </div>
            <div class="mt-3">
              <h4>Danh mục: <small class="text-muted"><?= $sanPham['ten_danh_muc'] ?></small></h4>
            </div>
            <div class="mt-3">
              <h4>Trạng thái: <small
                  class="<?= $sanPham['trang_thai'] == 1 ? 'text-success' : 'text-danger' ?>"><?= $sanPham['trang_thai'] == 1 ? 'Còn bán' : 'Dừng bán' ?></small>
              </h4>
            </div>
            <div class="mt-3">
              <h4>Mô tả: <small class="text-muted"><?= $sanPham['mo_ta'] ?></small></h4>
            </div>
          </div>


        </div>
        <ul class="nav nav-tabs row mt-4" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab"
              aria-controls="home" aria-selected="true">Bình luận của sản phẩm</button>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <table class="table table-striped  table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Tên người bình luận</th>
                  <th>Nội dung</th>
                  <th>Ngày đăng</th>
                  <th>Thao tác</th>
                </tr>
              </thead>

              <tbody>
                <tr>
                  <td>1</td>
                  <td>Giap</td>
                  <td>Siêu hay</td>
                  <td>26/07/2024</td>
                  <td>
                    <div class="btn-group">
                      <a href="#"><button class="btn btn-warning">Ân</button></a>
                      <a href="#"><button class="btn btn-danger">Xóa</button></a>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- Footer -->
<?php include './views/layout/footer.php'; ?>
<!-- End Footer -->
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
<!-- Code injected by live-server -->
</body>
<script>
  $(document).ready(function () {
    $('.product-image-thumb').on('click', function () {
      var $image_element = $(this).find('img')
      $('.product-image').prop('src', $image_element.attr('src'))
      $('.product-image-thumb.active').removeClass('active')
      $(this).addClass('active')
    })
  })
</script>

</html>