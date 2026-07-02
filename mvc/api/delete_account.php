<?php
header('Content-Type: application/json');
include "../query/pdo.php";
include "../query/tai-khoan.php";

$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data['id'])) {
    try {
        $id = $data['id'];
        
        delete_account($id);
        
        echo json_encode(["status" => "success", "message" => "Xóa tài khoản thành công!"]);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Lỗi Database: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Không tìm thấy ID tài khoản cần xóa!"]);
}
?>