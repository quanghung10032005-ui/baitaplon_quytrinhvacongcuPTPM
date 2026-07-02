<?php
include 'view/admin/nav.php';
?>
<article>
    <div class="container-add">
        <h1>Cập Nhật Tài Khoản</h1>
        <form id="updateAccountForm">
            <input type="hidden" id="account_id" value="<?= $id ?>">

            <label for="user">Tên tài khoản:</label>
            <input type="text" id="user" name="user" value="<?= $tk_user ?>" required>

            <label for="pass">Mật khẩu:</label>
            <input type="password" id="pass" name="pass" value="<?= $tk_password ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= $tk_email ?>" required>

            <label for="address">Địa chỉ:</label>
            <input type="text" id="address" name="address" value="<?= $tk_address ?>" required>

            <label for="id_role">Vai tro:</label>
            <select id="id_role" name="id_role" required>
                <option value="">Chọn role</option>
                <?php foreach ($list_role as $role): ?>
                    <option value="<?= $role['role_id'] ?>" <?= ($role['role_id'] == $id_role) ? 'selected' : '' ?>>
                        <?= $role['role_name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <div id="api-message" style="margin-top: 10px; font-weight: bold;"></div>

            <div class="return">
                <button name="submit" type="submit" class="btn btn-primary">Cập Nhật Tài Khoản</button>
                <a href="?act=admin&admin=accountList">Quay lại</a>
            </div>
        </form>
    </div>
</article>

<script>
document.getElementById('updateAccountForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Chặn tải lại trang

    // Lấy dữ liệu từ form
    const data = {
        id: document.getElementById('account_id').value,
        user: document.getElementById('user').value.trim(),
        pass: document.getElementById('pass').value.trim(),
        email: document.getElementById('email').value.trim(),
        address: document.getElementById('address').value.trim(),
        id_role: document.getElementById('id_role').value
    };

    const messageBox = document.getElementById('api-message');
    messageBox.style.color = 'blue';
    messageBox.innerText = 'Đang xử lý cập nhật...';

    // Gọi API Update
    fetch('./api/update_account.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.status === 'success') {
            messageBox.style.color = 'green';
            messageBox.innerText = result.message;
            // Trở về trang danh sách sau 1.5 giây
            setTimeout(() => {
                window.location.href = '?act=admin&admin=accountList';
            }, 1500);
        } else {
            messageBox.style.color = 'red';
            messageBox.innerText = result.message;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        messageBox.style.color = 'red';
        messageBox.innerText = 'Đã xảy ra lỗi hệ thống!';
    });
});
</script>