<h1>Cart</h1>
<div class="cart-container">
    <div class="left-container">
        <div class="item-list" id="item-list">
        </div>
    </div>
    <div class="right-container">
        <div class="total-money-contaier" id="total-money">0VND</div>

        <div class="shipping-method-container">
            <label>
                <input type="radio" name="shipping" value="ship" id="ship"> Giao hàng
            </label>
            <label>
                <input type="radio" name="shipping" value="takeout" id="takeout"> Tự đến lấy
            </label>
        </div>

        <div class="payment-method-container" id="paymentMethodContainer" style="display: none;">
            <form>
                <label>
                    <input type="radio" name="payment" value="inplace"> Thanh toán tại địa điểm giao hàng
                </label>
                <label>
                    <input type="radio" name="payment" value="transfer"> Thanh toán bằng chuyển khoản
                </label>
            </form>
        </div>
        <div class="shipping-info-container" id="shippingInfoContainer" style="display: none;">
            <form>
                <input type="text" id="customer_name" name="customer_name" placeholder="Tên">
                <input type="text" id="customer_phone" name="customer_phone" placeholder="Số điện thoại">
                <input type="text" id="customer_address" name="customer_address" placeholder="Địa chỉ" style="display: none;">
            </form>
        </div>
        <button class="submit-button" id="submitButton" style="display: none;">Thanh toán</button>

    </div>
</div>
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <p>Bạn chắc chắn muốn bỏ sản phẩm này?</p>
        <button id="confirmDelete" class="modal-btn">Có, xóa</button>
        <button id="cancelDelete" class="modal-btn">Không</button>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const itemList = document.getElementById("item-list");
    itemList.addEventListener("click", handleQuantityChange);

    const shippingRadioButtons = document.querySelectorAll('input[name="shipping"]');
    const paymentMethodContainer = document.getElementById('payment-method-container');
    shippingRadioButtons.forEach(radio => {
        radio.addEventListener('change', togglePaymentMethod);
    });
    const submitButton=document.getElementById('submitButton');
    submitButton.addEventListener('click',paymentSubmit);
    fetchItems(); // fetch items when the page loads
});

function togglePaymentMethod() {
    const paymentMethodContainer = document.getElementById('paymentMethodContainer');
    const shippingInfoContainer=document.getElementById('shippingInfoContainer');
    const addressInput=document.getElementById('customer_address');
    const submitButton=document.getElementById('submitButton');
    if (document.getElementById('ship').checked) {
        paymentMethodContainer.style.display = 'block';
        addressInput.style.display='block';
    } else {
        paymentMethodContainer.style.display = 'none';
        addressInput.style.display='none';
    }
    shippingInfoContainer.style.display='block';
    submitButton.style.display='block';
}

function handleQuantityChange(event) {
    const target = event.target;
    const itemCard = target.closest(".item-card");

    if (!itemCard) return;

    const quantityInput = itemCard.querySelector(".quantity");
    const decreaseBtn = itemCard.querySelector(".decrease-btn");
    const itemId = itemCard.dataset.itemId;
    if (target.classList.contains("increase-btn")) {
        quantityInput.value = parseInt(quantityInput.value) + 1;
        calculateTotalPrice();
        debouncedUpdateDatabase(itemId, quantityInput.value);
    }

    if (target.classList.contains("decrease-btn")) {
        if (quantityInput.value > 1) {
            quantityInput.value = parseInt(quantityInput.value) - 1;
            calculateTotalPrice();
            debouncedUpdateDatabase(itemId, quantityInput.value);
        } else {
            showDeleteModal(itemId, itemCard);
        }
    }
}




function debouncePerItem(func, delay) {
    const timers = {};

    return function (itemId, ...args) {
        if (timers[itemId]) {
            clearTimeout(timers[itemId]);
        }
        
        timers[itemId] = setTimeout(() => {
            func(itemId, ...args);
            delete timers[itemId]; // Clean up after execution
        }, delay);
    };
}


function updateDatabase(itemId, quantity) {
    const formData = new FormData();
    formData.append("item_id", itemId);
    formData.append("quantity", quantity);
    formData.append("ajax",1);
    formData.append("controller","cart");
    formData.append("action","updateQuantity");
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "index.php", true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4){
            if (xhr.status === 200) {
                const response=JSON.parse(xhr.responseText);
                if (!response.success){
                    alert(response.message);
                }
                else {
                    console.log("updated");
                }
            }
            else {
                alert("Request failed with status: " + xhr.status, true)
            }        
        }
    };

    xhr.send(formData);
}

const debouncedUpdateDatabase = debouncePerItem(updateDatabase, 500);

function deleteItem(itemId, itemCard) {
    // Cancel any pending update for the item

    if (debouncedUpdateDatabase[itemId]) {
        clearTimeout(debouncedUpdateDatabase[itemId]);
        delete debouncedUpdateDatabase[itemId];
    }

    const formData = new FormData();
    formData.append("item_id", itemId);
    formData.append("quantity", 0);
    formData.append("ajax",1);
    formData.append("controller","cart");
    formData.append("action","updateQuantity")

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "index.php", true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4){
            if (xhr.status === 200) {
                const response=JSON.parse(xhr.responseText);
                if (response.success){
                    console.log("deleted")
                    itemCard.remove();
                    calculateTotalPrice();
                }
                else {
                    alert(response.message);
                }
            }
            else {
                alert("Request failed with status: " + xhr.status, true)
            }
        }
    };

    xhr.send(formData);
}



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


// fetches cart items
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
                    <div class="item-card"  data-item-id="${item.item_id}" data-price=${item.price}>
                        <div class="image-container">
                            <img class="card-image" src="public/${item.image_path}" alt="${item.name}">
                        </div>
                        <div class="item-name-container">${item.name}</div>
                        <div class="item-price-container" >${item.price} VND</div>
                        <div class="quantity-container">
                            <button class="quantity-btn decrease-btn" type="button">&#8722;</button>
                            <input class="quantity" type="number" value="${item.quantity}" min="1">
                            <button class="quantity-btn increase-btn" type="button">&#43;</button>
                        </div>
                    </div>
                `;
            });
            calculateTotalPrice();
        }
    };
    xhr.send();
}

function calculateTotalPrice() {
    let total=0

    document.querySelectorAll('.item-card').forEach(item => {
        const price = parseFloat(item.getAttribute('data-price')) || 0;
        const quantity = parseInt(item.querySelector('.quantity').value) || 0;
        total += price * quantity;
    });
    
    document.getElementById('total-money').textContent=total.toLocaleString()+"VND";

}

function paymentSubmit() {
    const itemList = document.querySelectorAll(".item-card");
    let dataList = [];

    itemList.forEach(item => {
        dataList.push({
            item_id: item.dataset.itemId,
            quantity: item.querySelector(".quantity").value
        });
    });

    console.log(dataList);

    const payload = JSON.stringify({
        ajax: 1,
        controller: "cart",
        action: "submitOrder",
        dataList: dataList
    });

    // Create the request
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "index.php", true);
    xhr.setRequestHeader("Content-Type", "application/json"); // Set JSON header
    xhr.timeout = 10000;

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        window.location.href = "index.php?page=paymentSuccess";
                    } else {
                        showNotification(response.message, true);
                    }
                } catch (e) {
                    alert("Invalid JSON response from server.", true);
                }
            } else {
                alert("Request failed with status: " + xhr.status, true);
            }
        }
    };

    // Send JSON data
    xhr.send(payload);
}
</script>

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
