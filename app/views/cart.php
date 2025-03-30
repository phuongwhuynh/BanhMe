<h1>Cart</h1>
<div id="item-list">
    <!-- <div class="item-card">
        <div class="image-container">
            <img class="card-image" src="public/images/banh_mi_xiu_mai.jpg" alt="Bánh Mì Xíu Mại">
        </div>
        <div class="item-name-container">
            Bánh Mì Xíu Mại
        </div>
        <div class="item-price-container">
            30000 VND
        </div>
        <div class="quantity-container">
            <button class="quantity-btn decrease-btn" type="button">&#8722;</button>
            <input class="quantity" type="number" name="quantity" value="1" min="1">
            <button class="quantity-btn increase-btn" type="button">&#43;</button>
        </div>

    </div>
    <div class="item-card">
        <div class="image-container">
            <img class="card-image" src="public/images/banh_mi_cha_ca.jpg" alt="Bánh Mì Chả Cá">
        </div>
        <div class="item-name-container">
            Bánh Mì Chả Cá
        </div>
        <div class="item-price-container">
            30000 VND
        </div>
        <div class="quantity-container">
            <button class="quantity-btn decrease-btn" type="button">&#8722;</button>
            <input class="quantity" type="number" name="quantity" value="1" min="1">
            <button class="quantity-btn increase-btn" type="button">&#43;</button>
        </div>

    </div> -->
</div>
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <p>Bạn chắc chắn muốn bỏ sản phẩm này?</p>
        <button id="confirmDelete" class="modal-btn">Có, xóa</button>
        <button id="cancelDelete" class="modal-btn">Không</button>
    </div>
</div>

<style>
.item-list {
    display: flex;
    flex-direction: column;
}
.item-card {
    height: 4rem;
    overflow: hidden; 
    display: flex;
    align-items: center;
    gap: 0.5rem; 
    padding: 0.2rem;
    margin: 1rem;
    border: 4px solid black;

}
.image-container {
    height: 100%;
    width: auto;
}
.card-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.item-name-container, 
.item-price-container {
    font-size: 0.8rem; 
    white-space: nowrap; 
    overflow: hidden;
    text-overflow: ellipsis;
}
.modal {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    z-index: 500;
}
.modal-content {
    text-align: center;
}
.modal-btn {
    margin: 10px;
    padding: 8px 16px;
    border: none;
    cursor: pointer;
}

</style>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const itemList = document.getElementById("item-list");

    itemList.addEventListener("click", handleQuantityChange);

    fetchItems(); // fetch items when the page loads
});


function handleQuantityChange(event) {
    const target = event.target;
    const itemCard = target.closest(".item-card");

    if (!itemCard) return;

    const quantityInput = itemCard.querySelector(".quantity");
    const decreaseBtn = itemCard.querySelector(".decrease-btn");
    const itemId = itemCard.dataset.itemId;

    if (target.classList.contains("increase-btn")) {
        quantityInput.value = parseInt(quantityInput.value) + 1;
        debouncedUpdateDatabase(itemId, quantityInput.value);
    }

    if (target.classList.contains("decrease-btn")) {
        if (quantityInput.value > 1) {
            quantityInput.value = parseInt(quantityInput.value) - 1;
            debouncedUpdateDatabase(itemId, quantityInput.value);
        } else {
            showDeleteModal(itemId, itemCard);
        }
    }
}




function updateDatabase(itemId, quantity) {
    const formData = new FormData();
    formData.append("item_id", itemId);
    formData.append("quantity", quantity);

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "index.php?ajax=1&controller=cart&action=updateQuantity", true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log("Quantity updated successfully.");
        }
    };

    xhr.send(formData);
}


function deleteItem(itemId, itemCard) {
    const formData = new FormData();
    formData.append("item_id", itemId);

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "index.php?ajax=1&controller=cart&action=deleteItem", true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log("Item deleted.");
            itemCard.remove();
        }
    };

    xhr.send(formData);
}


function debounce(func, delay) {
    let timer;
    return function (...args) {
        clearTimeout(timer);
        timer = setTimeout(() => func.apply(this, args), delay);
    };
}

const debouncedUpdateDatabase = debounce(updateDatabase, 500);


function showDeleteModal(itemId, itemCard) {
    const modal = document.getElementById("deleteModal");
    const confirmBtn = document.getElementById("confirmDelete");
    const cancelBtn = document.getElementById("cancelDelete");

    modal.style.display = "block";

    confirmBtn.onclick = function () {
        deleteItem(itemId, itemCard);
        modal.style.display = "none";
    };

    cancelBtn.onclick = function () {
        modal.style.display = "none";
    };
}


// Fetches cart items from the server and renders them in the UI.
function fetchItems() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "index.php?ajax=1&controller=cart&action=getAll", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);
            const itemList = document.getElementById("item-list");
            itemList.innerHTML = "";

            data.forEach(item => {
                itemList.innerHTML += `
                    <div class="item-card" data-item-id="${item.item_id}">
                        <div class="image-container">
                            <img class="card-image" src="public/${item.image_path}" alt="${item.name}">
                        </div>
                        <div class="item-name-container">${item.name}</div>
                        <div class="item-price-container">${item.price} VND</div>
                        <div class="quantity-container">
                            <button class="quantity-btn decrease-btn" type="button">&#8722;</button>
                            <input class="quantity" type="number" value="${item.quantity}" min="1">
                            <button class="quantity-btn increase-btn" type="button">&#43;</button>
                        </div>
                    </div>
                `;
            });
        }
    };
    xhr.send();
}

</script>

