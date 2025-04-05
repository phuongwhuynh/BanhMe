<h1>Lịch sử</h1>

<div id="history-container">
    <div class="history-card">
        <div class="datetime-container">18/08/2004 12:00:00</div>
        <div class="total-price-container">100000VND</div>
        <div class="item-container">
            <img class="card-image" src="public/images/banh_mi_bo_duong.jpg" alt="Bánh Mì Bơ Đường">
            <div class="item-name-container">Bánh Mì Bơ Đường</div>
            <div class="item-price-container">10000VND</div>
            <div class="item-quantity-container">1</div>
        </div>
        <div class="item-container">
            <img class="card-image" src="public/images/banh_mi_nhan_kem.jpg" alt="Bánh Mì Nhân Kem">
            <div class="item-name-container">Bánh Mì Nhân Kem</div>
            <div class="item-price-container">10000VND</div>
            <div class="item-quantity-container">2</div>
        </div>
        <button class="load-more-button">Thu lại</button>
    </div>
    <div class="history-card">
        <div class="datetime-container">18/08/2004 12:00:00</div>
        <div class="total-price-container">100000VND</div>
        <div class="item-container">
            <img class="card-image" src="public/images/banh_mi_bo_duong.jpg" alt="Bánh Mì Bơ Đường">
            <div class="item-name-container">Bánh Mì Bơ Đường</div>
            <div class="item-price-container">10000VND</div>
            <div class="item-quantity-container">1</div>
        </div>
        <button class="load-more-button">Xem thêm</button>
    </div>
</div>

<script>
function loadHistory() {
    fetch('index.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            ajax: 1,
            controller: 'history',
            action: 'showHistory',
            limit: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        const container = document.getElementById('history-container');
        container.innerHTML = '';

        data.forEach((history, index) => {
            const card = renderHistoryCard(history, index === 0);
            container.appendChild(card);
        });
    })
    .catch(error => console.error('Error loading history:', error));
}

document.addEventListener('DOMContentLoaded', loadHistory);

</script>

<style>
#history-container {
    display: flex;
    flex-direction: column;
    margin: 1rem;
    gap: 1rem;
}
.history-card {
    display: flex;
    flex-direction: column;
    border: 4px solid black;
    padding: 1rem;
}
.item-container {
    display: flex;
    flex-direction: row;
    gap: 1rem;
    border: 2px solid black;

}
.card-image{
    height: 2rem;
}
</style>

