<?php
header('Content-Type: application/json');
include "../query/pdo.php";
include "../query/tai-khoan.php";


$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data['id']) && !empty($data['user']) && !empty($data['pass']) && !empty($data['email'])) {
    try {
        $id = trim($data['id']);
        $user = trim($data['user']);
        $pass = trim($data['pass']);
        $email = trim($data['email']);
        $address = isset($data['address']) ? trim($data['address']) : "";
        $id_role = isset($data['id_role']) ? trim($data['id_role']) : "";

        if (strlen($user) < 5) {
            echo json_encode(["status" => "error", "message" => "Tên tài khoản phải dài ít nhất 5 ký tự!"]);
            exit();
        }

        if (strlen($pass) < 6) {
            echo json_encode(["status" => "error", "message" => "Mật khẩu phải dài ít nhất 6 ký tự!"]);
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["status" => "error", "message" => "Địa chỉ email không hợp lệ!"]);
            exit();
        }

        if ($address == '') {
            echo json_encode(["status" => "error", "message" => "Vui lòng điền địa chỉ!"]);
            exit();
        }

        if ($id_role == '') {
            echo json_encode(["status" => "error", "message" => "Vui lòng chọn role cho tài khoản!"]);
            exit();
        }

        update_account($id, $user, $pass, $email, $address, $id_role);
        
        echo json_encode(["status" => "success", "message" => "Cập nhật tài khoản thành công!"]);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Lỗi Database: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Vui lòng điền đủ các thông tin bắt buộc!"]);
}
?>