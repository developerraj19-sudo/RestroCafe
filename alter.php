<?php
require 'app/Core/Database.php';
require 'app/Models/AdminModel.php';
$db = new Database();
$conn = $db->getConnection();
$model = new AdminModel();
$res = $model->clearTableByNumber(1);
var_dump($res);

define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'restrocafe');
define('DB_USER', 'root');
define('DB_PASS', '');

require 'd:/XAMPP/htdocs/RestroCafe/app/Core/Database.php';
$db = new Database();
$conn = $db->getConnection();
try {
    $conn->exec('ALTER TABLE tbl_orders ADD notes VARCHAR(255) NULL DEFAULT NULL AFTER o_qty');
    echo 'Success';
} catch(Exception $e) {
    echo $e->getMessage();
}
