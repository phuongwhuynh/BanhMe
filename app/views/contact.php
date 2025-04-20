<div id="wrapper">
<div class="contact-container">
  <div class="contact-info">
  <h1>Liên hệ</h1>
    <p><strong>Địa chỉ:</strong> 268 Đ. Lý Thường Kiệt, Phường 14, Quận 10, Hồ Chí Minh</p>
    <p><strong>Email:</strong> lienhe@example.com</p>
    <p><strong>Số điện thoại:</strong> 0123 456 789</p>
  </div>

  <div id="map" ></div>
</div>
</div>
<style>

</style>

<script>
function initMap() {
    const location = { lat: 10.762622, lng: 106.660172 }; // Vị trí TP.HCM, bạn có thể thay đổi
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
        center: location,
    });

    const marker = new google.maps.Marker({
        position: location,
        map: map,
    });
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>
