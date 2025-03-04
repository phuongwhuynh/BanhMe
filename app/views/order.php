<h2>Order Page</h2>

<div id="sorting">
    <label>Sort by:</label>
    <select id="sortSelect" onchange="fetchProducts(currentPage)">
        <option value="name_asc">Name (A-Z)</option>
        <option value="name_desc">Name (Z-A)</option>
        <option value="price_asc">Price (Low-High)</option>
        <option value="price_desc">Price (High-Low)</option>
    </select>
</div></br>

<!-- Product List -->
<div id="product-list" class="products-container"></div>
<!-- Pagination -->
<div id="pagination" class="pagination">
    <button id="prevPage" class="fixed-nav">&#8592; Prev</button>
    <div id="pageNumbers" class="page-numbers"></div>
    <button id="nextPage" class="fixed-nav">Next &#8594;</button>
</div>

<!-- Modal -->
<div class="product-modal" id="productModal">
    <div class="modal-content">
        <p id="modal-image">imagePath</p>
        <p id="modal-name">name</p>
        <p id="modal-price">price</p>
        <p id="modal-description">description</p>
    </div>
    <button class="close-modal" onclick="document.getElementById('productModal').style.display='none'">Close</button>
</div>
<script>
let currentPage = 1;
const limit = 6;
const maxVisiblePages = 5; 
function fetchProducts(page = 1) {
    const sort = document.getElementById("sortSelect").value; // Get sort option
    const xhr = new XMLHttpRequest();
    xhr.open("GET", `index.php?page=order&ajax=1&pageNum=${page}&limit=${limit}&sort=${sort}`, true);

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
                    `<button class="product-card" 
                        onClick="openModal('${product.image_path}','${product.name}','${product.price}','${product.description}')">
                        <img src="/${product.image_path}">
                        ${product.name} - ${product.price}
                    </button>`;
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

function openModal(image_path, name, price, description) {
    document.getElementById("modal-image").textContent=image_path;
    document.getElementById("modal-name").textContent=name;
    document.getElementById("modal-price").textContent=price;
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

// Initial load
fetchProducts();
</script>

<style>
    .products-container {
        display: grid;
        grid-template-columns: repeat(3,1fr);
        grid-template-rows: repeat(2,auto);
        gap:10px;
        padding:10px;
    }
    .product-modal {
        display: none;
    }
    .product-card {
        color: var(--brown4);
    }
    .pagination {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: 10px;
    }
    .fixed-nav {
        padding: 8px 15px;
        border: 1px solid #ddd;
        background: #007bff;
        color: white;
        font-weight: bold;
        cursor: pointer;
    }
    .fixed-nav:disabled {
        background: #ccc;
        cursor: not-allowed;
    }
    .page-numbers {
        display: flex;
        gap: 5px;
    }
    .page-btn {
        padding: 5px 10px;
        border: 1px solid #ddd;
        background: #f8f8f8;
        cursor: pointer;
    }
    .page-btn.active {
        background: #007bff;
        color: white;
        font-weight: bold;
    }
    .ellipsis {
        padding: 5px 10px;
        color: gray;
    }
</style>
