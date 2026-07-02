<?php
include 'view/admin/nav.php';
?>

<article>
    <div class="container-add">
        <h1>Cập Nhật Đơn Hàng</h1>
        <form id="updateOrderForm">
            <?php if ($load_one_order) {
                extract($load_one_order); ?>
                <label for="name">Tên người nhận:</label>
                <input type="text" id="name" name="namePay" placeholder="<?= $dh_nameUser; ?>" value="<?php if (isset($namePay) && !empty($namePay)) echo $namePay; ?>" disabled />

                <label for="email">Email:</label>
                <input type="text" id="email" name="emailPay" placeholder="<?= $dh_emailUser; ?>" value="<?php if (isset($emailPay) && !empty($emailPay)) echo $emailPay; ?>" disabled />

                <label for="tel">Số điện thoại:</label>
                <input type="tel" id="tel" name="phonePay" placeholder="<?= $dh_phoneUser; ?>" value="<?php if (isset($phonePay) && !empty($phonePay)) echo $phonePay; ?>" disabled />

                <label for="address-detail">Địa chỉ:</label>
                <input type="text" id="address-detail" name="addressPay" placeholder="<?= $dh_addressUser; ?>" value="<?php if (isset($addressPay) && !empty($addressPay)) echo $addressPay; ?>" disabled />

                <label for="location-col">Quốc gia:</label>
                <input type="text" id="location-col" name="countryPay" placeholder="<?= $dh_countryPay; ?>" value="<?php if (isset($countryPay) && !empty($countryPay)) echo $countryPay; ?>" disabled />

                <label for="location-city">Thành phố:</label>
                <input type="text" id="location-city" name="cityPay" placeholder="<?= $dh_cityPay; ?>" value="<?php if (isset($cityPay) && !empty($cityPay)) echo $cityPay; ?>" disabled />

                <label for="location-district">Quận/Huyện:</label>
                <input type="text" id="location-district" name="districtPay" placeholder="<?= $dh_districtPay; ?>" value="<?php if (isset($districtPay) && !empty($districtPay)) echo $districtPay; ?>" disabled />

                <label for="location-commune">Xã/Phường:</label>
                <input type="text" id="location-commune" name="communePay" placeholder="<?= $dh_communePay; ?>" value="<?php if (isset($communePay) && !empty($communePay)) echo $communePay; ?>" disabled />

                <label for="message">Ghi chú:</label>
                <input type="text" id="message" name="messagePay" placeholder="<?= $dh_messagePay; ?>" value="<?php if (isset($messagePay) && !empty($messagePay)) echo $messagePay; ?>" disabled />

                <label for="statusPay">Trạng thái:</label>
                <select name="statusPay" id="statusPay_<?= $dh_id ?>" onchange="checkStatus(<?= $dh_id ?>)">
                    <option value="Chờ Xác Nhận" <?= ($dh_status == "Chờ Xác Nhận") ? 'selected' : ''; ?>>Chờ Xác Nhận</option>
                    <option value="Đã Xác Nhận" <?= ($dh_status == "Đã Xác Nhận") ? 'selected' : ''; ?>>Đã Xác Nhận</option>
                    <option value="Chờ Giao Hàng" <?= ($dh_status == "Chờ Giao Hàng") ? 'selected' : ''; ?>>Chờ Giao Hàng</option>
                    <option value="Đang Giao Hàng" <?= ($dh_status == "Đang Giao Hàng") ? 'selected' : ''; ?>>Đang Giao Hàng</option>
                    <option value="Giao Hàng Thành Công" <?= ($dh_status == "Giao Hàng Thành Công") ? 'selected' : ''; ?>>Giao Hàng Thành Công</option>
                    <option value="Đã nhận hàng" <?= ($dh_status == "Đã nhận hàng") ? 'selected' : ''; ?>>Đã nhận hàng</option>
                </select>

                <div class="return">
                    <button type="submit" name="btnPayUpdate" class="button-confirm">Cập Nhật</button>
                    <a href="?act=admin&admin=orderList">Quay lại</a>
                </div>

            <?php } ?>
        </form>

        <?php if (!empty($mess)): ?>
            <p class="error-message" style="align-center; margin-left: 100px;"><?php echo $mess; ?></p>
        <?php endif; ?>
    </div>
</article>

<script>
    
    document.getElementById('updateOrderForm').addEventListener('submit', function(e) {
        e.preventDefault(); 

        
        const orderId = <?= $dh_id ?? 0 ?>; 
        
        
        const statusSelect = document.getElementById("statusPay_" + orderId);
        const newStatus = statusSelect.value;

        
        fetch('api/update_order_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                dh_id: orderId,
                status: newStatus
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                alert(data.message);
      
                window.location.href = '?act=admin&admin=orderList';
            } else {
                alert("Lỗi: " + data.message);
            }
        })
        .catch(error => {
            console.error('Lỗi khi gọi API:', error);
            alert("Đã xảy ra lỗi hệ thống khi cập nhật trạng thái!");
        });
    });

    function checkStatus(orderId) {
        var statusSelect = document.getElementById("statusPay_" + orderId);
        var selectedStatus = statusSelect.value;

        
        var options = statusSelect.getElementsByTagName("option");

    
        for (var i = 0; i < options.length; i++) {
            var option = options[i];
           
            if (selectedStatus == "Đã Xác Nhận" && i == 0) { 
                option.disabled = true;
            } else if (selectedStatus == "Chờ Giao Hàng" && i < 2) {
                option.disabled = true;
            } else if (selectedStatus == "Đang Giao Hàng" && i < 3) { 
                option.disabled = true;
            } else if (selectedStatus == "Giao Hàng Thành Công" && i < 4) { 
                option.disabled = true;
            } else if (selectedStatus == "Đã nhận hàng" && i < 5) { 
                option.disabled = true;
            } else {
                option.disabled = false;
            }
        }
    }

   
    window.onload = function() {
        var allStatusSelects = document.querySelectorAll('[id^="statusPay_"]'); 
        allStatusSelects.forEach(function(statusSelect) {
            var orderId = statusSelect.id.split('_')[1]; 
            if (orderId) {
                checkStatus(orderId); 
            }
        });
    };
</script>