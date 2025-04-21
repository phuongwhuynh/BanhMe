document.addEventListener("DOMContentLoaded", function () {
    const itemList = document.getElementById("item-list");
    itemList.addEventListener("click", handleQuantityChange);

    const shippingRadioButtons = document.querySelectorAll('input[name="shipping"]');
    const paymentMethodContainer = document.getElementById('payment-method-container');
    shippingRadioButtons.forEach(radio => {
        radio.addEventListener('change', togglePaymentMethod);
    });
    const submitButton=document.getElementById('submitButton');
    submitButton.addEventListener('click',  paymentSubmit);
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
            const cartContainer = document.querySelector(".cart-container");

            if (data.length === 0) {
                cartContainer.innerHTML = `<p class="empty-cart-message">Không có sản phẩm nào trong giỏ hàng.</p>`;
                return;
            }

            const itemList = document.getElementById("item-list");
            itemList.innerHTML = "";

            data.forEach(item => {
                itemList.innerHTML += `
                    <div class="item-card" data-item-id="${item.item_id}" data-price=${item.price}>
                        <div class="image-container">
                            <img class="card-image" src="public/${item.image_path}" alt="${item.name}">
                        </div>
                        <div class="item-name-container">${item.name}</div>
                        <div class="item-price-container">${Math.floor(item.price).toLocaleString()} VND</div>
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
    
    document.getElementById('total-money').textContent=total.toLocaleString()+" VND";

}

function paymentSubmit(event) {
    event.preventDefault();
    const shipOption = document.getElementById("ship");
    const takeoutOption = document.getElementById("takeout");
    const inplacePayment = document.querySelector('input[name="payment"][value="inplace"]');
    const transferPayment = document.querySelector('input[name="payment"][value="transfer"]');

    const customerName = document.getElementById("customer_name").value.trim();
    const customerPhone = document.getElementById("customer_phone").value.trim();
    const customerAddress = document.getElementById("customer_address").value.trim();

    if (shipOption.checked && !inplacePayment.checked && !transferPayment.checked) {
        showNotification("Vui lòng chọn phương thức thanh toán.",true);
        return;
    }

    if (!customerName || !customerPhone) {
        showNotification("Vui lòng điền đầy đủ họ tên và số điện thoại.",true);
        return;
    }

    if (shipOption.checked && !customerAddress) {
        showNotification("Vui lòng nhập địa chỉ giao hàng.",true);
        return;
    }

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
                        window.location.href = "orderSuccess";
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
