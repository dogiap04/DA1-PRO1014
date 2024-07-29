<?php 

// Biến môi trường, dùng chung toàn hệ thống
// Khai báo dưới dạng HẰNG SỐ để không phải dùng $GLOBALS


// duong san vao clients
define('BASE_URL'       , 'http://localhost/PET%20PAMILY/');
// duong san vao admin
define('BASE_URL_ADMIN'       , 'http://localhost/PET%20PAMILY/admin/');

define('DB_HOST'    , 'localhost');
define('DB_PORT'    , 3306);
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME'    , 'pet_family');  // Tên database

define('PATH_ROOT'    , __DIR__ . '/../');
