<?php
header('Content-Type: application/json');
include "../query/pdo.php";
include "../query/san-pham.php";

$sp_id = trim($_POST['sp_id'] ?? '');
$sp_name = trim($_POST['name'] ?? '');
$sp_price = trim($_POST['price'] ?? '');
$sp_quantity = trim($_POST['quantity'] ?? '');
$sp_describe = trim($_POST['describe'] ?? '');
$id_dm = trim($_POST['dm_id'] ?? '');
$sp_pricedel = isset($_POST['sp_pricedel']) ? trim($_POST['sp_pricedel']) : 0;
$sp_image = trim($_POST['old_image'] ?? ''); 

$errors = [];
if ($sp_id === '') $errors[] = "- Không tìm thấy ID sản phẩm để sửa!";
if ($sp_name === '') $errors[] = "- Vui lòng nhập Tên sản phẩm!";
if ($sp_price === '') $errors[] = "- Vui lòng nhập Giá sản phẩm!";
if ($sp_quantity === '') $errors[] = "- Vui lòng nhập Số lượng!";
if ($id_dm === '' || $id_dm === '0') $errors[] = "- Vui lòng chọn Danh mục!";

if (count($errors) > 0) {
    echo json_encode(["status" => "error", "message" => implode("\n", $errors)]);
    exit;
}

try {
    if (isset($_FILES["file_upload"]["tmp_name"]) && $_FILES["file_upload"]["tmp_name"]) {
        $sp_image = "upload/" . $_FILES["file_upload"]["name"];
        move_uploaded_file($_FILES["file_upload"]["tmp_name"], "../upload/" . $_FILES["file_upload"]["name"]);
    }

    update_product($sp_id, $sp_name, $sp_image, $sp_price, $sp_quantity, $sp_describe, $id_dm, $sp_pricedel);
    
    echo json_encode(["status" => "success", "message" => "Cập nhật sản phẩm thành công!"]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Lỗi Database: " . $e->getMessage()]);
}
?>