<?php
include 'view/admin/nav.php';
?>
<article>
    <div class="container-add">
        <h1>Thêm Tài Khoản</h1>
        <form id="addAccountForm">
            <label for="user">Tên tài khoản:</label>
            <input type="text" id="user" name="user" required>

            <label for="pass">Mật khẩu:</label>
            <input type="password" id="pass" name="pass" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="address">Địa chỉ:</label>
            <input type="text" id="address" name="address" required>

            <label for="id_role">Role:</label>
            <select id="id_role" name="id_role" required>
                <option value="">Chọn role</option>
                <?php foreach ($list_role as $role): ?>
                    <option value="<?= $role['role_id'] ?>"><?= $role['role_name'] ?></option>
                <?php endforeach; ?>
            </select>
            
            <div id="api-message" style="margin-top: 10px; font-weight: bold;"></div>

            <div class="return">
                <button type="submit" class="btn btn-primary">Thêm Tài Khoản</button>
                <a href="?act=admin&admin=accountList">Quay lại</a>
            </div>
        </form>
    </div>
</article>

<script>
document.getElementById('addAccountForm').addEventListener('submit', function(e) {
    e.preventDefault(); 

   
    const data = {
        user: document.getElementById('user').value.trim(),
        pass: document.getElementById('pass').value.trim(),
        email: document.getElementById('email').value.trim(),
        address: document.getElementById('address').value.trim(),
        role: document.getElementById('id_role').value
    };

    const messageBox = document.getElementById('api-message');
    messageBox.style.color = 'blue';
    messageBox.innerText = 'Đang xử lý...';

    // Gọi API bằng Fetch
    fetch('./api/add_account.php', {
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
            // Chuyển hướng về trang danh sách sau 1.5 giây
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
        messageBox.innerText = 'Đã xảy ra lỗi khi gọi API!';
    });
});
</script>