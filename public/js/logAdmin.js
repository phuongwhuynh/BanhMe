let offset = 0;
const limit = 6;
let loading = false;
let allLoaded = false;

function renderHistoryCard(history) {
    const card = document.createElement('div');
    card.className = 'history-card';
    
    const timePriceDiv=document.createElement('div');
    timePriceDiv.className="time-price-container";
    card.appendChild(timePriceDiv);

    const datetimeDiv = document.createElement('div');
    datetimeDiv.className = 'datetime-container';

    const userIdDiv=document.createElement('div');
    userIdDiv.textContent = "user_id: " + history.user_id;
    timePriceDiv.appendChild(userIdDiv);


    const date = new Date(history.datetime);
    const formattedDatetime = date.toLocaleString('vi-VN', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
    });
    datetimeDiv.textContent = "Thời gian: " + formattedDatetime;
    timePriceDiv.appendChild(datetimeDiv);

    const totalPriceDiv = document.createElement('div');
    totalPriceDiv.className = 'total-price-container';
    totalPriceDiv.textContent = 'Tổng: ' + Math.floor(history.total_price).toLocaleString() + ' VND';
    timePriceDiv.appendChild(totalPriceDiv);

    // Always show the first item
    history.items.forEach((item, index) => {
        const itemDiv = document.createElement('div');
        itemDiv.className = 'item-container';
        
        // Always show the first item
        if (index === 0) {
            itemDiv.style.display = 'flex'; 
            itemDiv.classList.add('first-item-container'); 
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

        const quantityDiv = document.createElement('div');
        quantityDiv.className = 'item-quantity-container';
        quantityDiv.textContent = item.quantity;
        itemDiv.appendChild(quantityDiv);

        const priceDiv = document.createElement('div');
        priceDiv.className = 'item-price-container';
        priceDiv.textContent = Math.floor(item.price).toLocaleString() + ' VND';
        itemDiv.appendChild(priceDiv);
        
        card.appendChild(itemDiv);
    });

    // Add "Load More" button only if there are more than one item
    if (history.items.length > 1) {
        const loadMoreButton = document.createElement('button');
        loadMoreButton.className = 'load-more-button';
        loadMoreButton.innerHTML = `
            Xem thêm 
            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
        `;

        let expanded = false; // Toggle state

        loadMoreButton.addEventListener('click', () => {
            const itemContainers = card.querySelectorAll('.item-container');
            
            if (!expanded) {
                // Expand: show all items
                itemContainers.forEach((itemDiv, index) => {
                    if (index > 0) {
                        itemDiv.style.display = 'flex';
                    }
                });
                loadMoreButton.innerHTML = `
                    Thu lại 
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="transform: rotate(180deg);">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                `;            
            } else {
                // Collapse: hide items again (except the first one)
                itemContainers.forEach((itemDiv, index) => {
                    if (index > 0) {
                        itemDiv.style.display = 'none';
                    }
                });
                loadMoreButton.innerHTML = `
                    Xem thêm 
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                `;
            }

            expanded = !expanded; // Flip the state
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
            action: 'showAllHistory',
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

    const mainContainer = document.querySelector('main');
    const nearBottom = mainContainer.scrollHeight - mainContainer.scrollTop <= mainContainer.clientHeight + 100;

    // console.log("Main Scroll Position:", mainContainer.scrollTop, "Main Height:", mainContainer.scrollHeight, "Main Client Height:", mainContainer.clientHeight); // Debugging line

    if (nearBottom) {
        console.log("Near bottom of <main>, loading more history...");
        loadHistory();
    }
}

document.addEventListener('DOMContentLoaded', () => {
    console.log("Page loaded, loading initial history..."); 
    loadHistory();
    const mainContainer = document.querySelector('main');
    mainContainer.addEventListener('scroll', handleScroll); 
});
