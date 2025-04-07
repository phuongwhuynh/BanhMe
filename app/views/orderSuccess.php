<div class="order-success-container">
    <h1>Đặt Hàng Thành Công!</h1>
    <p>Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi. Đơn hàng của bạn đã được xác nhận và sẽ được giao sớm.</p>
    
    <div class="button-container">
        <button onclick="goHome()">Về Trang Chủ</button>
        <button onclick="continueShopping()">Tiếp Tục Mua</button>
    </div>
</div>


<script>
    // Redirect to the home page
    function goHome() {
        window.location.href = "index.php?page=home";  // Change this URL to your homepage URL
    }

    // Redirect to the shopping page (or category page, etc.)
    function continueShopping() {
        window.location.href = "index.php?page=order";  // Change this URL to your shopping or category page
    }
</script>
