function initMap() {
    const location = { lat: 10.772763802309562, lng: 106.65771437174988 }; 
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
        center: location,
    });

    const marker = new google.maps.Marker({
        position: location,
        map: map,
    });
}