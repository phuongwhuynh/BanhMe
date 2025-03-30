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

</style>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const itemList = document.getElementById("item-list");
    function debounce(func, delay) {
        let timer;
        return function (...args) {
            clearTimeout(timer);
            timer = setTimeout(() => func.apply(this, args), delay);
        };
    }
    itemList.addEventListener("click", function (event) {
        const target = event.target;
        const itemCard = target.closest(".item-card");

        if (!itemCard) return; // Ignore clicks outside item cards

        const quantityInput = itemCard.querySelector(".quantity");
        const decreaseBtn = itemCard.querySelector(".decrease-btn");

        if (target.classList.contains("increase-btn")) {
            quantityInput.value = parseInt(quantityInput.value) + 1;
            debouncedUpdateDatabase(itemId, quantityInput.value);

        }

        if (target.classList.contains("decrease-btn")) {
            if (quantityInput.value > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
                debouncedUpdateDatabase(itemId, quantityInput.value);
            }
            else if (quantityInput.value===1) {
                /*
                make a modal appear for confirmation to delete the item,
                if user confirms to delete the item, delete that item-card from the item-list
                and update the database
                */
            }
        }
    });


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

    const debouncedUpdateDatabase = debounce(updateDatabase, 500);


    fetchItems();
    function fetchItems() {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "index.php?ajax=1&controller=cart&action=getAll", true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const data=JSON.parse(xhr.responseText);
                const itemList=document.getElementById("item-list");
                itemList.innerHTML="";
                data.forEach(item => {
                    itemList.innerHTML += `
                        <div class="item-card">
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
        }
        xhr.send();

    }

});

</script>

