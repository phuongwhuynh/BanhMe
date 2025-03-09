let currentPage = 1;
const limit = 6;
const maxVisiblePages = 5; 
let debounceTimer;


fetchProducts();
function fetchProducts(page = 1) {
    const sort = document.getElementById("sortSelect").value; 
    let selectedCategories = [];
    document.querySelectorAll(".toggle.on").forEach(btn => {
        selectedCategories.push(btn.getAttribute("data-category"));
    });
    const categoryQuery = selectedCategories.length ? `&categories=${selectedCategories.join(",")}` : "";

    const xhr = new XMLHttpRequest();
    xhr.open("GET", `index.php?ajax=1&controller=order&action=handlePagination&pageNum=${page}&limit=${limit}&sort=${sort}${categoryQuery}`, true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);
            const productList = document.getElementById("product-list");
            const pageNumbers = document.getElementById("pageNumbers");
            const prevPage = document.getElementById("prevPage");
            const nextPage = document.getElementById("nextPage");
            // Clear previous content
            productList.innerHTML = "";
            pageNumbers.innerHTML = "";

            // Add products
            data.products.forEach(product => {
                productList.innerHTML += 
                    `<div class="product-card"
                    onClick="openModal('${product.item_id}','${product.image_path}','${product.name}','${product.price}','${product.description}')">
                        <img class="card-image" src="public/${product.image_path}" class="card-image"">
                        <div class="product-name-container">
                        ${product.name} 
                        </div>
                        <div class="product-price-container">
                            ${Math.round(product.price).toLocaleString('vi-VN')} VND
                        </div>
                    </div>`;
            });

            // const totalPages = data.totalProducts/limit;
            const totalPages=data.totalPages;

            // Handle "Previous" button
            prevPage.disabled = (page === 1);
            prevPage.onclick = () => fetchProducts(page - 1);

            // Pagination range
            let startPage = Math.max(1, page - Math.floor(maxVisiblePages / 2));
            let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
            if (endPage - startPage + 1 < maxVisiblePages) {
                startPage = Math.max(1, endPage - maxVisiblePages + 1);
            }

            // First page
            if (startPage > 1) {
                pageNumbers.appendChild(createPageButton(1));
                if (startPage > 2) pageNumbers.appendChild(createEllipsis());
            }

            // Page buttons
            for (let i = startPage; i <= endPage; i++) {
                pageNumbers.appendChild(createPageButton(i, i === page));
            }

            // Last page
            if (endPage < totalPages) {
                if (endPage < totalPages - 1) pageNumbers.appendChild(createEllipsis());
                pageNumbers.appendChild(createPageButton(totalPages));
            }

            // Handle "Next" button
            nextPage.disabled = (page === totalPages);
            nextPage.onclick = () => fetchProducts(page + 1);

            currentPage = page;
        }
    };
    xhr.send();
}

function cateToggle(button) {
    button.classList.toggle("on"); 
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => fetchProducts(currentPage), 300);

}
function openModal(item_id, image_path, name, price, description) {
    document.getElementById("quantity").value=1;
    document.getElementById("decrease-quantity").disabled=true;
    document.getElementById("modal-item-id").value = item_id;
    document.getElementById("modal-image").src="public/"+image_path;
    document.getElementById("modal-name").textContent=name;
    document.getElementById("modal-price").textContent= Math.round(price).toLocaleString('vi-VN') + " VND";
    document.getElementById("modal-description").textContent=description;
    document.getElementById("productModal").style.display="flex";
}

function createPageButton(page, isActive = false) {
    let button = document.createElement("button");
    button.innerText = page;
    button.classList.add("page-btn");
    if (isActive) button.classList.add("active");
    button.onclick = () => fetchProducts(page);
    return button;
}

function createEllipsis() {
    let span = document.createElement("span");
    span.innerText = "...";
    span.classList.add("ellipsis");
    return span;
}
function increaseQuantity() {
    let quantityInput = document.getElementById('quantity');
    quantityInput.value = parseInt(quantityInput.value) + 1;
    document.getElementById('decrease-quantity').disabled=false;

};

function decreaseQuantity() {
    let quantityInput = document.getElementById('quantity');
    if (parseInt(quantityInput.value) > 1) {
        quantityInput.value = parseInt(quantityInput.value) - 1;
    }
    if (parseInt(quantityInput.value) === 1) {
        decreaseBtn.disabled=true;
    }

};

function addCart(event) {
    event.preventDefault(); //prevents form from refreshing the page

    let form = document.getElementById("cart-form");
    let formData = new FormData(form); 

    let xhr=new XMLHttpRequest();
    xhr.open("POST", "index.php",true);
    formData.append("ajax", "1");
    formData.append("controller", "order");
    formData.append("action", "addCart");

    xhr.timeout = 5000; // 5 seconds
    xhr.ontimeout=function() {
        alert("Request timed out. Please try again.");
    }
    xhr.onreadystatechange = function () {
        if (xhr.readyState==4){
            if (xhr.status==200){
                let response=JSON.parse(xhr.responseText);
                if (response.success) {
                    alert("Item added to cart successfully!");
                }
                else {
                    alert(response.message);
                }
            }
            else {
                alert("Request failed with status: " + xhr.status)
            }
        }
    }
    xhr.send(formData);     
}
