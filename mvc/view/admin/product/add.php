<?php
include 'view/admin/nav.php';
?>
<article>
    <div class="container-add">
        <h1>Thêm Sản Phẩm</h1>
        <form id="addProductForm" enctype="multipart/form-data">
            <label for="name">Nhập Tên:</label>
            <input type="text" name="name" id="name" value="<?= $_POST['name'] ?? "" ?>">
            <span class="error-message"><?= $thongBaoLoiTen ?></span>
            <br>
            <label for="image">Nhập Ảnh:</label>
            <input type="text" name="image" id="image" value="<?= $_POST['image'] ?? "" ?>">
            <input type="file" name="file_upload">
            <span class="error-message"><?= $thongBaoLoiAnh ?></span>
            <br>
            <label for="price">Nhập Giá:</label>
            <input type="number" name="price" id="price" value="<?= $_POST['price'] ?? "" ?>">
            <span class="error-message"><?= $thongBaoLoiGia ?></span>
            <br>
            <label for="quantity">Nhập Số Lượng:</label>
            <input type="number" name="quantity" id="quantity" value="<?= $_POST['quantity'] ?? "" ?>">
            <span class="error-message"><?= $thongBaoLoiSoLuong ?></span>
            <br>
            <label for="sp_pricedel">Nhập Biến Thể Giá:</label>
            <input type="number" name="sp_pricedel" id="sp_pricedel" value="<?= $_POST['sp_pricedel'] ?? "" ?>">
            <span class="error-message"><?= $thongBaoLoiSoLuong ?></span>
            <br>
            <label for="describe">Nhập Mô Tả:</label>
            <input type="text" name="describe" id="describe" value="<?= $_POST['describe'] ?? "" ?>">
            <span class="error-message"><?= $thongBaoLoiMoTa ?></span>
            <br>
            <label for="dm_id">Nhập Danh Mục:</label>
            <select name="dm_id" id="dm_id">
                <option value="<?= $_POST['dm_id'] ?? "" ?>">Chọn danh mục</option>
                <?php foreach ($list_category as $danhmuc): extract($danhmuc) ?>
                    <option value="<?= $dm_id ?>"><?= $dm_name ?></option>
                <?php endforeach ?>
            </select>
            <span class="error-message"><?= $thongBaoLoiDM ?></span>
            <br>
            <div class="return">
                <button name="submit" type="submit">Thêm SP</button>
                <a href="?act=admin&admin=productList">Quay lại</a>
            </div>
        </form>
        <div class="success-message"><?= $thongBao ?></div>
    </div>
</article>

<script>
    document.getElementById('addProductForm').addEventListener('submit', function(e) {
        e.preventDefault(); 

        const formData = new FormData(this);

        fetch('api/add_product.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                alert(data.message); 
                window.location.href = '?act=admin&admin=productList';
            } else {
                alert("Lỗi: " + data.message); 
            }
        })
        .catch(error => {
            console.error('Lỗi khi gọi API:', error);
            alert("Đã xảy ra lỗi hệ thống khi kết nối tới máy chủ!");
        });
    });
</script>