<?php
include 'view/admin/nav.php';
?>
<article>
    <h1>Danh Sách Tài Khoản</h1>
    <div class="container-list">
        <form action="">
            <table class="table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tài khoản</th>
                        <th>Điền Email</th>
                        <th>Địa chỉ</th>
                        <th>Vai Trò</th>
                        <th>Tác Vụ</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($list_account as $index => $account):  extract($account) ?>
                        <tr id="row-<?= $tk_id ?>">
                            <td><?= $index + 1 ?></td>
                            <td><?= $tk_user ?></td>
                            <td><?= $tk_email ?></td>
                            <td><?= $tk_address ?></td>
                            <td><?= $role_name ?></td>

                            <td class="action">
                                <a href="?act=admin&admin=accountUpdate&id=<?= $tk_id ?>" class="update"><i class="fa-regular fa-pen-to-square"></i></a>
                                
                                <a href="javascript:void(0);" class="delete" onclick="deleteAccount(<?= $tk_id ?>)"><i class="fa-solid fa-trash-can"></i></a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </form>
    </div>
</article>

<script>
    // Hàm gọi API xóa tài khoản
    function deleteAccount(accountId) {
        // Hộp thoại xác nhận
        if (confirm("Bạn có chắc chắn muốn xóa tài khoản này? Hành động này không thể hoàn tác!")) {
            
            // Gọi API bằng Fetch
            fetch('./api/delete_account.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: accountId })
            })
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    alert(result.message); // Báo thành công
                    
                    // Xóa mượt: Xóa luôn dòng đó khỏi HTML mà không cần f5 reload trang
                    let row = document.getElementById('row-' + accountId);
                    if (row) {
                        row.remove();
                    }
                } else {
                    alert("Lỗi: " + result.message); // Báo lỗi từ server
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Đã xảy ra lỗi hệ thống khi gọi API xóa tài khoản!');
            });
        }
    }
</script>