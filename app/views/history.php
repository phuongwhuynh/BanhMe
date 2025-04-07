<h1>Lịch sử</h1>

<div id="history-container">
    <!-- <div class="history-card">
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
    </div>  -->
</div>

<script>
let offset = 0;
const limit = 6;
let loading = false;
let allLoaded = false;

function renderHistoryCard(history) {
    const card = document.createElement('div');
    card.className = 'history-card';

    const datetimeDiv = document.createElement('div');
    datetimeDiv.className = 'datetime-container';
    datetimeDiv.textContent = history.datetime;
    card.appendChild(datetimeDiv);

    const totalPriceDiv = document.createElement('div');
    totalPriceDiv.className = 'total-price-container';
    totalPriceDiv.textContent = history.total_price + 'VND';
    card.appendChild(totalPriceDiv);

    // Always show the first item
    history.items.forEach((item, index) => {
        const itemDiv = document.createElement('div');
        itemDiv.className = 'item-container';
        
        // Always show the first item
        if (index === 0) {
            itemDiv.style.display = 'block';  // Make sure the first item is always shown
        } else {
            itemDiv.style.display = 'none'; // Hide other items initially
        }

        const image = document.createElement('img');
        image.className = 'card-image';
        image.src = "public/"+item.image;
        image.alt = item.name;
        itemDiv.appendChild(image);

        const nameDiv = document.createElement('div');
        nameDiv.className = 'item-name-container';
        nameDiv.textContent = item.name;
        itemDiv.appendChild(nameDiv);

        const priceDiv = document.createElement('div');
        priceDiv.className = 'item-price-container';
        priceDiv.textContent = item.price + 'VND';
        itemDiv.appendChild(priceDiv);

        const quantityDiv = document.createElement('div');
        quantityDiv.className = 'item-quantity-container';
        quantityDiv.textContent = item.quantity;
        itemDiv.appendChild(quantityDiv);

        card.appendChild(itemDiv);
    });

    // Add "Load More" button only if there are more than one item
    if (history.items.length > 1) {
        const loadMoreButton = document.createElement('button');
        loadMoreButton.className = 'load-more-button';
        loadMoreButton.textContent = 'Xem thêm'; 
        
        loadMoreButton.addEventListener('click', () => {
            // Toggle visibility of all items
            const itemContainers = card.querySelectorAll('.item-container');
            itemContainers.forEach((itemDiv, index) => {
                if (index > 0) {
                    itemDiv.style.display = 'block'; // Show hidden items
                }
            });

            // Change the button text
            loadMoreButton.textContent = 'Thu lại'; // Change to collapse
            loadMoreButton.addEventListener('click', () => {
                itemContainers.forEach((itemDiv, index) => {
                    if (index > 0) {
                        itemDiv.style.display = 'none'; // Hide items again, except the first one
                    }
                });
                loadMoreButton.textContent = 'Xem thêm'; // Change back to show more
            });
        });

        card.appendChild(loadMoreButton);
    }

    return card;
}

function loadHistory() {
    if (loading || allLoaded) return;
    loading = true;

    fetch('index.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            ajax: 1,
            controller: 'history',
            action: 'showHistory',
            limit: limit,
            offset: offset
        })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            console.log('Failed to load history:', data.message || 'Unknown error');
            allLoaded = true;
            return;
        }

        const container = document.getElementById('history-container');
        data.history.forEach(history => {
            const card = renderHistoryCard(history);
            container.appendChild(card);
        });

        offset += data.history.length;
        if (data.history.length < limit) {
            allLoaded = true;
        }
    })
    .catch(error => console.log('Error loading history:', error))
    .finally(() => {
        loading = false;
    });
}

function handleScroll() {
    const historyContainer = document.getElementById('history-container'); 
    const nearBottom = historyContainer.scrollHeight - historyContainer.scrollTop <= historyContainer.clientHeight + 100;
    
    console.log("History Container Scroll Position:", historyContainer.scrollTop, "History Container Height:", historyContainer.scrollHeight, "History Container Client Height:", historyContainer.clientHeight); // Debugging line
    
    if (nearBottom) {
        console.log("Near bottom of history-container, loading more history...");
        loadHistory();
    }
}

document.addEventListener('DOMContentLoaded', () => {
    console.log("Page loaded, loading initial history..."); 
    loadHistory();
    const historyContainer = document.getElementById('history-container');
    historyContainer.addEventListener('scroll', handleScroll); 
});

</script>

<style>

#history-container {
    display: flex;
    flex-direction: column;
    margin: 1rem;
    gap: 1rem;
    overflow-y: auto;
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

