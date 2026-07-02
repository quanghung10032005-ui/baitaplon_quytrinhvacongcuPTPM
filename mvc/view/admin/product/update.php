<?php
include 'view/admin/nav.php';
?>
<article>
    <div class="container-add">
        <h1>Sửa Sản Phẩm</h1>
        <form id="updateProductForm" enctype="multipart/form-data">
            <input type="hidden" name="sp_id" value="<?= $sp_id ?>">
            <input type="hidden" name="old_image" value="<?= $sp_image ?>">

            <label for="name">Tên sản phẩm:</label>
            <input type="text" name="name" id="name" value="<?= $sp_name ?>">
            <span class="error-message"><?= $thongBaoLoiTen ?></span>

            <label for="image">Ảnh sản phẩm:</label>
            <input type="text" name="image_display" value="<?= $sp_image ?>" readonly>
            <input type="file" name="file_upload">
            
            <label for="price">Giá sản phẩm:</label>
            <input type="number" name="price" id="price" value="<?= $sp_price ?>">

            <label for="quantity">Số lượng:</label>
            <input type="number" name="quantity" id="quantity" value="<?= $sp_quantity ?>">

            <label for="describe">Mô tả:</label>
            <input type="text" name="describe" id="describe" value="<?= $sp_describe ?>">

            <label for="sp_pricedel">Giá biến thể:</label>
            <input type="number" name="sp_pricedel" id="sp_pricedel" value="<?= $sp_pricedel ?>">

            <label for="dm_id">Danh mục:</label>
            <select name="dm_id" id="dm_id">
                <?php foreach ($list_category as $category): ?>
                    <option value="<?= $category['dm_id'] ?>" <?= ($category['dm_id'] == $id_dm) ? 'selected' : '' ?>>
                        <?= $category['dm_name'] ?>
                    </option>
                <?php endforeach ?>
            </select>
                
            <div class="return">
                <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
                <a href="?act=admin&admin=productList">Quay lại</a>
            </div>
        </form>
        <div id="update-message"></div>
    </div>

    <div class="container-add">
        <h1>Thêm Màu Sản Phẩm</h1>
        <form action="" method="POST">
            <label for="name_color">Nhập Tên:</label>
            <input type="text" name="name_color" id="name_color" value="<?= $_POST["name_color"] ?? "" ?>">
            <div class="error-message"><?= $thongBaoLoiTenMau ?></div>
            <button name="submit_color" type="submit" class="btn btn-primary">Thêm Màu</button>
        </form>
        <div class="mt-3"><?= $thongBaoMau ?></div>
    </div>

    <div class="container-add">
        <h1>Thêm Bộ Nhớ Sản Phẩm</h1>
        <form action="" method="POST">
            <label for="name_memory">Nhập Tên:</label>
            <input type="text" name="name_memory" id="name_memory" value="<?= $_POST["name_memory"] ?? "" ?>">
            <div class="error-message"><?= $thongBaoLoiTenBN ?></div>
            <button name="submit_memory" type="submit" class="btn btn-primary">Thêm Bộ Nhớ</button>
        </form>
        <div class="mt-3"><?= $thongBaoBN ?></div>
    </div>
</article>

<script>
    // Chỉ xử lý Fetch cho Form Update Sản Phẩm
    document.getElementById('updateProductForm').addEventListener('submit', function(e) {
        e.preventDefault(); 
        const formData = new FormData(this);

        fetch('api/update_product.php', {  
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
            console.error('Lỗi:', error);
            alert("Lỗi hệ thống!");
        });
    });
</script>