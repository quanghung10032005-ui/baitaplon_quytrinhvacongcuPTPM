<?php
header('Content-Type: application/json');
include "../query/pdo.php";
include "../query/tai-khoan.php";

try {
    $list_account = load_all_account();
    
    foreach ($list_account as $key => $account) {
        unset($list_account[$key]['tk_password']); 
    }

    echo json_encode([
        "status" => "success",
        "data" => $list_account
    ]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>