<?php
include 'view/admin/nav.php';
?>
<article>
    <div class="container-add">
        <h1>Thêm Danh mục</h1>
      <form id="addCategoryForm">
            <input type="text" name="name" id="">
            <div class="return">
                <button name="submit" type="submit">Thêm danh Mục</button>
                <a href="?act=admin&admin=categoryList">Quay lại</a>
            </div>
        </form>
    </div>
</article>
<script>
    document.getElementById('addCategoryForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Ngăn hành vi load lại trang mặc định của form

        // Lấy giá trị mà người dùng nhập từ ô input có name="name"
        const categoryName = document.querySelector('input[name="name"]').value;

        // Gọi API bằng Fetch
        fetch('api/add_category.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                name: categoryName
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                alert(data.message); // Thông báo thành công
                // Chuyển hướng về trang danh sách danh mục sau khi thêm xong
                window.location.href = '?act=admin&admin=categoryList'; 
            } else {
                // Hiển thị lỗi báo từ API (VD: để trống trường nhập)
                alert("Lỗi: " + data.message); 
            }
        })
        .catch(error => {
            console.error('Lỗi khi gọi API:', error);
            alert("Đã xảy ra lỗi hệ thống khi thêm danh mục!");
        });
    });
</script>