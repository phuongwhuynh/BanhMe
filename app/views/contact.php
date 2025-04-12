<div id="wrapper">
<div class="contact-container">
  <div class="contact-info">
  <h1>Liên hệ</h1>
    <p><strong>Địa chỉ:</strong> 268 Đ. Lý Thường Kiệt, Phường 14, Quận 10, Hồ Chí Minh</p>
    <p><strong>Email:</strong> lienhe@example.com</p>
    <p><strong>Số điện thoại:</strong> 0123 456 789</p>
  </div>

  <div id="map" style="height: 400px; width: 100%; border-radius: 10px;"></div>
</div>
</div>
<style>
  #wrapper {
    position: relative;
    width: 100%;
    flex:1; /* or a specific height */
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 1rem; /* add some breathing room */
    box-sizing: border-box;
    overflow: auto;
  }

  .contact-container {
    width: 80%;
    max-width: 60rem;
    display: flex;
    flex-direction: row;
    gap: 1rem;
    margin: auto;
    padding: 1.5rem;
    background-color: var(--cream);
    border-radius: 0.5rem;
    flex-wrap: wrap; 
  }

  .contact-info {
    flex:1;
    font-size: 1.2rem;
    line-height: 1.6;
  }
  #map {
    flex: 1;
    /* height: 400px; */
    border-radius: 0.5rem;
  }

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
