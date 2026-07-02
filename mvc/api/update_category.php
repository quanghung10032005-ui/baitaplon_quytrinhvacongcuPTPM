<?php
// File: mvc/api/update_category.php
header('Content-Type: application/json');
include_once '../query/pdo.php';
include_once '../query/danh-muc.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    $id = isset($data['id']) ? intval($data['id']) : 0;
    $name = isset($data['name']) ? trim($data['name']) : '';

    if ($id > 0 && $name !== '') {

        update_category($id, $name); 
        echo json_encode([
            "status" => "success", 
            "message" => "Cập nhật danh mục thành công!"
        ]);
    } else {
        echo json_encode([
            "status" => "error", 
            "message" => "Dữ liệu không hợp lệ hoặc tên danh mục trống!"
        ]);
    }
} else {
    echo json_encode([
        "status" => "error", 
        "message" => "Phương thức yêu cầu không hợp lệ!"
    ]);
}
?>