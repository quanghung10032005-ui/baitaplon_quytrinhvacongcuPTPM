<?php
include 'view/admin/nav.php';
?>
<article>
    <div class="container-add">
        <h1>Cập nhật Danh mục</h1>
        <form id="updateCategoryForm">
            <?php foreach ($list_category as $category): extract($category);
                if ($dm_id == $_GET['id']) { ?>
                    <label for="name">Tên danh mục:</label>
                    <input type="text" name="name" id="name" value="<?= $dm_name ?>">
                    
                    <input type="hidden" name="dm_id" value="<?= $dm_id ?>">

                    <div class="return">
                        <button id="btn-update" type="button">Cập nhật danh Mục</button>
                        <a href="?act=admin&admin=categoryList">Quay lại</a>
                    </div>
            <?php }
            endforeach ?>
        </form>
    </div>
</article>

<script>
    document.getElementById('btn-update').addEventListener('click', function() {
        
        // Lấy dữ liệu từ các ô input
        const categoryId = document.querySelector('input[name="dm_id"]').value;
        const categoryName = document.querySelector('input[name="name"]').value;

        // Gọi API bằng Fetch
        fetch('api/update_category.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id: categoryId,
                name: categoryName
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                alert(data.message); 
                window.location.href = '?act=admin&admin=categoryList';
            } else {
                alert("Lỗi: " + data.message); 
            }
        })
        .catch(error => {
            console.error('Lỗi khi gọi API:', error);
            alert("Đã xảy ra lỗi hệ thống khi cập nhật danh mục!");
        });
    });
</script>