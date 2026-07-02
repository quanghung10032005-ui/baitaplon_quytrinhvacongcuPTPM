<?php
header('Content-Type: application/json');
include "../query/pdo.php";
include "../query/tai-khoan.php";

$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data['user']) && !empty($data['pass']) && !empty($data['email'])) {
    try {
        $user = trim($data['user']);
        $pass = trim($data['pass']);
        $email = trim($data['email']);
        $address = isset($data['address']) ? trim($data['address']) : "";
        $role = isset($data['role']) ? $data['role'] : 2; 

        if (strlen($user) < 5) {
            echo json_encode(["status" => "error", "message" => "Tên tài khoản phải dài ít nhất 5 ký tự!"]);
            exit();
        }
        
        if (check_duplicate_account($user)) {
            echo json_encode(["status" => "error", "message" => "Tên tài khoản đã tồn tại!"]);
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

        if (empty($address)) {
            echo json_encode(["status" => "error", "message" => "Vui lòng điền địa chỉ!"]);
            exit();
        }

        insert_account($user, $pass, $email, $address, $role);
        
        echo json_encode(["status" => "success", "message" => "Tạo tài khoản thành công!"]);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Lỗi Database: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Vui lòng điền đủ Tên tài khoản, Mật khẩu và Email."]);
}
?>