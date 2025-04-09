<div class="order-container">
  <div class="left-container">
    <div class="title-container">
      <h1 class="title">Thực đơn</h1>
    </div>
    <div class="cate-container">
      <div class="filter-title-container">
        <span class="filter-title">Lọc</span>
      </div>
      <div class="button-container">
        <button data-category="savory" class="toggle on" >Bánh Mì Mặn</button>
        <button data-category="sweet" class="toggle on" >Bánh Mì Ngọt</button>
        <button data-category="raw" class="toggle on">Bánh Mì Nguyên Bản</button>
      </div>
    </div>
    <div class="sort-container">
      <span class="sort-text">Sắp xếp:</span>
      <select class="sorter" id="sortSelect" onchange="fetchProducts(currentPage)">
        <option value="name_asc">Tên (A-Z)</option>
        <option value="name_desc">Tên (Z-A)</option>
        <option value="price_asc">Giá (Thấp-Cao)</option>
        <option value="price_desc">Giá (Cao-Thấp)</option>
      </select>
    </div>
    <input type="text" id="searchInput" class="search-bar" placeholder="Tìm kiếm...">
  </div>
  <!-- Product List -->
  <div class="right-container">
    <button style="margin: 1rem;" onclick="openCreateModal()"> Thêm món mới</button>
    <div class="scroll-container">
      <div id="product-list" class="products-container"></div>

      <!-- Pagination -->
      <div id="pagination" class="pagination">
          <button id="prevPage" class="fixed-nav">&#8592;</button>
          <div id="pageNumbers" class="page-numbers"></div>
          <button id="nextPage" class="fixed-nav"> &#8594;</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="product-modal" id="productModal">
  <div class="modal-content">
  <div id="image-wrapper" class="image-wrapper">
    <img id="modal-image" class="modal-image" src="" alt="">
    </div>
    <label id="modal-image-label" for="modal-image-input" style="display: none">Chọn ảnh mới:<span style="color: red">*</span></label>
    <input id="modal-image-input" type="file" accept="image/*" style="display: none">
    <div class="modal-title">
        <span id="modal-item-id" name="item_id"> </span>
        <span id="modal-name" class="modal-name"></span>

        <label for="modal-name-input" style="display: none">
            Tên món: <span style="color: red">*</span>
        </label>
        <input type="text" id="modal-name-input" class="modal-name" style="display: none;" required>

        <span id="modal-price" class="modal-price"></span>

        <label for="modal-price-input" style="display: none">
            Giá: <span style="color: red">*</span>
        </label>
        <input type="number" id="modal-price-input" class="modal-price" min="0" step="1000" style="display: none;" required>
    </div> 
    <p id="modal-description" class="modal-description"></p>
    <label id="modal-description-label" for="modal-description-input" style="display: none">Mô tả: <small style="color: gray;">(tùy chọn)</small></label>
    <textarea id="modal-description-input" class="modal-description" style="display: none;"></textarea>

    <div class="modal-actions">
        <button type="button" id="edit-button" onclick="enableEditMode()">Chỉnh sửa</button>
        <button type="button" id="save-button" style="display:none;" onclick="submitEdit()">Lưu</button>
        <button type="button" id="delete-button" style="display:none;" onclick="deleteItem()">Xóa</button>
        <button type="button" id="create-button" style="display:none;" onclick="submitCreate()">Tạo</button>
    </div>

    <button class="close-modal" onclick="document.getElementById('productModal').style.display='none'">X</button>
  </div>
</div>

<script>
function openCreateModal() {
    document.getElementById("modal-item-id").innerHTML = "";
    document.getElementById("modal-name-input").value = "";
    document.getElementById("modal-price-input").value = 0;
    document.getElementById("modal-description-input").value = "";
    document.getElementById("modal-image-input").value = "";
    document.getElementById("modal-image").src = "";

    // Hide spans
    document.getElementById("modal-name").style.display = "none";
    document.getElementById("modal-price").style.display = "none";
    document.getElementById("modal-description").style.display = "none";

    // Show inputs and labels
    document.getElementById("modal-image-input").style.display = "inline-block";
    document.getElementById("modal-image-label").style.display = "inline-block";

    document.querySelector('label[for="modal-name-input"]').style.display = "inline-block";
    document.getElementById("modal-name-input").style.display = "inline-block";

    document.querySelector('label[for="modal-price-input"]').style.display = "inline-block";
    document.getElementById("modal-price-input").style.display = "inline-block";

    document.getElementById("modal-description-label").style.display = "block";
    document.getElementById("modal-description-input").style.display = "block";

    // Show/hide buttons
    document.getElementById("productModal").style.display = "flex";
    document.getElementById("edit-button").style.display = "none";
    document.getElementById("create-button").style.display = "inline-block";
    document.getElementById("save-button").style.display = "none";
    document.getElementById("delete-button").style.display = "none";
}

function openModal(item_id, image_path, name, price, description) {
    document.getElementById("modal-item-id").value = item_id;
    document.getElementById("modal-item-id").innerHTML = item_id;
    document.getElementById("modal-image").src = "public/" + image_path;
    document.getElementById("modal-name").textContent = name;
    document.getElementById("modal-price").textContent = Math.round(price).toLocaleString('vi-VN') + " VND";
    document.getElementById("modal-description").textContent = description;

    document.getElementById("modal-name-input").value = name;
    document.getElementById("modal-price-input").value = Math.floor(price);
    document.getElementById("modal-description-input").value = description;
    document.getElementById("modal-image-input").value = "";

    // Show spans
    document.getElementById("modal-name").style.display = "inline-block";
    document.getElementById("modal-price").style.display = "inline-block";
    document.getElementById("modal-description").style.display = "block";

    // Hide inputs and labels
    document.getElementById("modal-image-input").style.display = "none";
    document.getElementById("modal-image-label").style.display = "none";

    document.querySelector('label[for="modal-name-input"]').style.display = "none";
    document.getElementById("modal-name-input").style.display = "none";

    document.querySelector('label[for="modal-price-input"]').style.display = "none";
    document.getElementById("modal-price-input").style.display = "none";

    document.getElementById("modal-description-label").style.display = "none";
    document.getElementById("modal-description-input").style.display = "none";

    // Show/hide buttons
    document.getElementById("edit-button").style.display = "inline-block";
    document.getElementById("save-button").style.display = "none";
    document.getElementById("delete-button").style.display = "none";
    document.getElementById("create-button").style.display = "none";

    document.getElementById("productModal").style.display = "flex";
}

function enableEditMode() {
    // Hide display spans
    document.getElementById("modal-name").style.display = "none";
    document.getElementById("modal-price").style.display = "none";
    document.getElementById("modal-description").style.display = "none";

    // Show inputs and labels
    document.getElementById("modal-image-input").style.display = "inline-block";
    document.getElementById("modal-image-label").style.display = "inline-block";

    document.querySelector('label[for="modal-name-input"]').style.display = "inline-block";
    document.getElementById("modal-name-input").style.display = "inline-block";

    document.querySelector('label[for="modal-price-input"]').style.display = "inline-block";
    document.getElementById("modal-price-input").style.display = "inline-block";

    document.getElementById("modal-description-label").style.display = "block";
    document.getElementById("modal-description-input").style.display = "block";

    // Buttons
    document.getElementById("edit-button").style.display = "none";
    document.getElementById("create-button").style.display = "none";
    document.getElementById("save-button").style.display = "inline-block";
    document.getElementById("delete-button").style.display = "inline-block";
}
function submitEdit() {
    const itemId = document.getElementById("modal-item-id").value.trim();
    const newName = document.getElementById("modal-name-input").value.trim();
    const newPrice = document.getElementById("modal-price-input").value.trim();
    const newDescription = document.getElementById("modal-description-input").value.trim();
    const newImage = document.getElementById("modal-image-input").files[0]; // optional

    if (!itemId || !newName || !newPrice) {
        alert("Vui lòng điền đầy đủ tất cả các trường!");
        return;
    }

    if (isNaN(newPrice) || Number(newPrice) <= 0) {
        alert("Giá phải là một số hợp lệ lớn hơn 0!");
        return;
    }
    const formData = new FormData();
    formData.append("ajax", "1");
    formData.append("controller", "admin");
    formData.append("action", "updateMenuItem");
    formData.append("item_id", itemId);
    formData.append("name", newName);
    formData.append("price", newPrice);
    formData.append("description", newDescription);
    if (newImage) {
        formData.append("image", newImage);
    }

    fetch("index.php", {
        method: "POST",
        body: formData,
    })
    .then(response => {
        if (!response.ok) throw new Error("Network response was not ok");
        return response.text(); 
    })
    .then(data => {
        alert("Cập nhật thành công!");
        fetchProducts(currentPage); // Refresh list
        document.getElementById("productModal").style.display = "none";
    })
    .catch(error => {
        console.error("Fetch error:", error);
        alert("Có lỗi xảy ra!");
    });
}
function submitCreate() {
    const newName = document.getElementById("modal-name-input").value.trim();
    const newPrice = document.getElementById("modal-price-input").value.trim();
    const newDescription = document.getElementById("modal-description-input").value.trim();
    const newImage = document.getElementById("modal-image-input").files[0]; 

    if (!newName || !newPrice || !newImage) {
        alert("Vui lòng điền đầy đủ tất cả các trường và tải lên ảnh!");
        return;
    }

    if (isNaN(newPrice) || Number(newPrice) <= 0) {
        alert("Giá phải là một số hợp lệ lớn hơn 0!");
        return;
    }
    const formData = new FormData();
    formData.append("ajax", "1");
    formData.append("controller", "admin");
    formData.append("action", "createMenuItem");
    formData.append("name", newName);
    formData.append("price", newPrice);
    formData.append("description", newDescription);
    formData.append("image", newImage);

    fetch("index.php", {
        method: "POST",
        body: formData,
    })
    .then(response => {
        if (!response.ok) throw new Error("Network response was not ok");
        return response.text(); 
    })
    .then(data => {
        alert("Thêm sản phẩm thành công!");
        fetchProducts(currentPage); 
        document.getElementById("productModal").style.display = "none";
    })
    .catch(error => {
        console.error("Fetch error:", error);
        alert("Có lỗi xảy ra!");
    });
}
function deleteItem() {
    const itemId = document.getElementById("modal-item-id").textContent.trim();

    if (!itemId) {
        alert("Không tìm thấy ID sản phẩm để xóa.");
        return;
    }

    if (!confirm("Bạn có chắc chắn muốn xóa món này?")) {
        return;
    }

    const formData = new FormData();
    formData.append("ajax", "1");
    formData.append("controller", "admin");
    formData.append("action", "deleteMenuItem");
    formData.append("item_id", itemId);

    fetch("index.php", {
        method: "POST",
        body: formData
    })
    .then(response => {
        if (!response.ok) throw new Error("Network response was not ok");
        return response.json(); 
    })
    .then(data => {
        if (data.success) {
            alert("Xóa thành công!");
            fetchProducts(currentPage); 
            document.getElementById("productModal").style.display = "none";
        } else {
            alert("Xóa thất bại: " + (data.message || "Không rõ lỗi."));
        }
    })
    .catch(error => {
        console.error("Fetch error:", error);
        alert("Có lỗi xảy ra khi gửi yêu cầu xóa!");
    });
}


let currentPage = 1;
const limit = 12;
const maxVisiblePages = 5; 

function removeDiacritics(str) {
    const diacritics = [
        { base: 'a', letters: /[áàảãạăắằẳẵặâấầẩẫậ]/g },
        { base: 'e', letters: /[éèẻẽẹêếềểễệ]/g },
        { base: 'i', letters: /[íìỉĩị]/g },
        { base: 'o', letters: /[óòỏõọôốồổỗộơớờởỡợ]/g },
        { base: 'u', letters: /[úùủũụưứừửữự]/g },
        { base: 'y', letters: /[ýỳỷỹỵ]/g },
        { base: 'd', letters: /[đ]/g }
    ];

    diacritics.forEach(diacritic => {
        str = str.replace(diacritic.letters, diacritic.base);
    });

    return str;
}
function createDiacriticsInsensitiveRegex(term) {
    const normalizedTerm = removeDiacritics(term.toLowerCase());
    
    let regexStr = '';
    
    for (let i = 0; i < normalizedTerm.length; i++) {
        const char = normalizedTerm[i];

        switch (char) {
            case 'a':
                regexStr += '[aàáảãạăắằẳẵặâấầẩẫậ]';
                break;
            case 'e':
                regexStr += '[eèéẻẽẹêếềểễệ]';
                break;
            case 'i':
                regexStr += '[iìíỉĩị]';
                break;
            case 'o':
                regexStr += '[oòóỏõọôốồổỗộơớờởỡợ]';
                break;
            case 'u':
                regexStr += '[uùúủũụưứừửữự]';
                break;
            case 'y':
                regexStr += '[yỳýỷỹỵ]';
                break;
            case 'd':
                regexStr += '[dđ]';
                break;
            default:
                regexStr += char;  // For non-diacritic characters, just match the character itself
        }
    }

    return new RegExp(regexStr, 'gi'); // 'gi' for global, case-insensitive matching
}
document.addEventListener('DOMContentLoaded', function () {
    let debounceTimer;
    let currentPage = 1;

    fetchProducts();

    document.getElementById('searchInput').addEventListener('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => fetchProducts(1), 300);
    });

    document.getElementById("sortSelect").addEventListener("change", () => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => fetchProducts(1), 300);
    });

    document.querySelectorAll('.toggle').forEach(button => {
        button.addEventListener('click', function () {
            this.classList.toggle("on");
            clearTimeout(debounceTimer);
            currentPage = 1;
            debounceTimer = setTimeout(() => fetchProducts(1), 300);
        });
    });
    document.getElementById("modal-image-input").addEventListener("change", function () {
        const file = this.files[0];
        if (file) {
            const imagePreview = document.getElementById("modal-image");
            imagePreview.src = URL.createObjectURL(file);
        }
    });
    const modalImage = document.getElementById("modal-image");
    const wrapper=document.getElementById("image-wrapper");
    modalImage.onerror = function () {
        this.style.display = "none";
        wrapper.classList.remove("has-image");

    };

    modalImage.onload = function () {
        this.style.display = "block";
        wrapper.classList.add("has-image");

    };

});


function fetchProducts(page = 1) {
    const sort = document.getElementById("sortSelect").value; 
    let selectedCategories = [];
    document.querySelectorAll(".toggle.on").forEach(btn => {
        selectedCategories.push(btn.getAttribute("data-category"));
    });
    const categoryQuery = selectedCategories.length ? `&categories=${selectedCategories.join(",")}` : "";

    const searchTerm = document.getElementById('searchInput').value.trim().replace(/\s+/g, ' ');
    const searchQuery = searchTerm ? `&search=${encodeURIComponent(searchTerm)}` : "";
    console.log(searchTerm);

    const xhr = new XMLHttpRequest();
    xhr.open("GET", `index.php?ajax=1&controller=order&action=handlePagination&pageNum=${page}&limit=${limit}&sort=${sort}${categoryQuery}${searchQuery}`, true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4){
            if (xhr.status === 200) {
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
                    let highlightedName = product.name;

                    const normalizedSearchTerm = removeDiacritics(searchTerm.toLowerCase());  
                    const regex = createDiacriticsInsensitiveRegex(normalizedSearchTerm);
                    
                    highlightedName = product.name.replace(regex, function(match) {
                        return `<span class="highlight">${match}</span>`; // Highlight the match
                    });

                    productList.innerHTML += 
                        `<div class="product-card"
                            onClick="openModal('${product.item_id}','${product.image_path}','${product.name}','${product.price}','${product.description}')">
                             <div class="image-container">
                                <img class="card-image" src="public/${product.image_path}" alt="${product.name}">
                            </div>
                            <div class="product-name-container">
                                ${highlightedName} <!-- Display the highlighted product name -->
                            </div>
                            <div class="product-price-container">
                                ${Math.round(product.price).toLocaleString('vi-VN')} VND
                            </div>
                        </div>`;
                });

                const totalPages = data.totalPages;

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
                nextPage.disabled = (page >= totalPages);
                nextPage.onclick = () => fetchProducts(page + 1);

                currentPage = page;
            }
            else {
                alert("Request failed with status: " + xhr.status, true)
            }
        }
    };
    xhr.send();
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
    document.getElementById('decrease-quantity').disabled = false;
}

function decreaseQuantity() {
    let quantityInput = document.getElementById('quantity');
    if (parseInt(quantityInput.value) > 1) {
        quantityInput.value = parseInt(quantityInput.value) - 1;
    }
    if (parseInt(quantityInput.value) === 1) {
        document.getElementById('decrease-quantity').disabled = true;
    }
}

function addCart(event) {
    event.preventDefault(); // Prevent form from refreshing the page

    let form = document.getElementById("cart-form");
    let formData = new FormData(form); 

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "index.php", true);
    formData.append("ajax", "1");
    formData.append("controller", "order");
    formData.append("action", "addCart");

    xhr.timeout = 5000; // 5 seconds
    xhr.ontimeout = function() {
        showNotification("Request timed out. Please try again.", true);
    }

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                let response = JSON.parse(xhr.responseText);
                if (response.success) {
                    showNotification("Item added to cart successfully!");
                } else {
                    if (response.message === "Unauthorized") {
                        showNotification("You must be logged in as a user to add items to the cart. Redirecting...", true);
                        setTimeout(() => {
                            window.location.href = "index.php?page=login";
                        }, 2000);
                    } else {
                        alert(response.message, true);
                    }
                }
            } else {
                alert("Request failed with status: " + xhr.status);
            }
        }
    }
    xhr.send(formData);     
}

</script>

<style>
.highlight {
    font-weight: bolder;
    background-color: var(--brown4);
}

.order-container {
    display: flex;
    flex-direction: row;
    color: var(--brown3);
    overflow: hidden;
    flex: 1; 
}
.order-container::-webkit-scrollbar {
    width: 0.2rem;
}

.order-container::-webkit-scrollbar-track {
    background: var(--brown1);
}

.order-container::-webkit-scrollbar-thumb {
    background: var(--brown3);
    border-radius: 0.1rem;
}
.order-container::-webkit-scrollbar-thumb:hover {
    background: var(--brown2); 
}
/* Base Styles */
.left-container {
    display: flex;
    margin: 0.5rem 3rem;
    flex-direction: column;
    gap: 0.5rem;
}
.title-container {
    /* padding: 1rem; */
    text-align: center;
}
.title {
    font-weight: bolder;
    font-size: 3rem;
    margin: 0.5rem 0;
    color: var(--brown3);
    white-space: nowrap;
    text-shadow: 1px 1px 2px var(--brown4);
}



.cate-container {
    position: relative; 
    padding: 1rem;
    border-radius: 1rem;
    border: 3px solid var(--brown3);
    display: flex;
    flex-direction: column;
    align-items: center;
}

.filter-title-container {
    position: absolute;
    top: -1rem;
    left: 50%;
    transform: translateX(-50%); 
    background-color: var(--brown1); 
    padding: 0 0.5rem;
}

.filter-title {
    font-weight: bold;
    font-size: x-large;
}

.button-container {
    margin-top: 0.25rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.toggle {
    box-shadow: 1px 1px 5px var(--brown4);
    padding: 0.8rem;
    width: 12rem;
    background-color: #444; /* Dark Gray */
    color: gray;
    white-space: nowrap; 
    flex-grow: 1;
    font-size: 1rem;
    font-weight: bold;
    border: none;
    border-radius: 20px;
    cursor: pointer;
    transition: background-color 0.3s, box-shadow 0.3s;
}

.toggle.on {
    background-color: var(--brown3); 
    color: var(--cream);
}

.sort-container {
    border-radius: 1rem;
    background-color: var(--brown3);
    display: flex;
    align-items: center; 
    padding: 1rem;
    box-shadow: 1px 1px 5px var(--brown4);
}

.sort-text {
    margin-right: 0.25rem;
    color: var(--cream);
    white-space: nowrap; 
    font-weight: bolder;
    font-size: large;
}

.sorter {
    width: auto;
    border-radius: 0.5rem;
    padding: 2px 1px;
    font-size: medium;
    color: var(--brown3);
    font-weight: bold;
    background-color: var(--cream);
}
.search-bar {
    padding: 0.5rem 0.75rem;
    border-radius: 0.5rem;
    color: var(--brown3);
    font-weight: bold;
    font-size: 1rem;
}
.right-container {
    display: flex;
    flex: 1;
    flex-direction: column;
    padding: 0.5rem;
    min-height:0;
}

.scroll-container {
    display: flex;
    flex-direction: column;
    overflow-y: auto;
    scrollbar-gutter: stable;
    align-items: center;

}

.scroll-container::-webkit-scrollbar {
    width: 0.5rem;
}

.scroll-container::-webkit-scrollbar-track {
    background: var(--brown1);
}

.scroll-container::-webkit-scrollbar-thumb {
    background: var(--brown3);
    border-radius: 0.25rem;
}
.scroll-container::-webkit-scrollbar-thumb:hover {
    background: var(--brown2); 
}

.products-container {
    display: grid;
    grid-template-columns: repeat(3, minmax(0,20rem)); 
    grid-auto-rows: 18rem;  /* Each row is 18rem tall, but number of rows is dynamic */
    gap: 1rem;
    margin: 0 2rem;
}

.product-card {
    background-color: var(--cream);
    box-shadow: 1px 1px 5px var(--brown2);
    border-radius: 0.5rem;
    padding: clamp(1rem, 2vw, 1.5rem);
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: all 0.1s ease-in-out;
}

.product-card:hover {
    box-shadow: 1px 1px 5px var(--brown2);
    /* transform: scale(1.01); */
    border: 2px solid var(--brown2); 
    cursor: pointer; 
}

.image-container {
    width: 100%;
    aspect-ratio: 4 /3; /* Ensures a consistent shape */
    overflow: hidden; 
    background-color: #f0f0f0; 
}

.card-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.product-name-container {
    padding: 0.5rem;
    font-weight: bolder;
    font-size: clamp(0.8rem, 2vw, 1.2rem); 
    white-space: nowrap; 
    overflow: hidden; 
    text-overflow: ellipsis; /* Adds "..." when text is too long */
    max-width: 100%; 
}


.product-price-container {
    font-weight: bold;
    font-size: clamp(0.6rem, 2vw, 1rem); 
}

.product-modal {
    position: fixed; 
    z-index: 100;
    left: 0;
    top: 0;
    width: 100vw;
    height: 100vh;
    background-color: rgba(0, 0, 0, 0.5); 
    display: flex;
    align-items: center;
    justify-content: center;
    display: none;

}

.modal-content {
    max-height: 80vh;
    margin: 1rem;
    padding: 2rem;
    background-color: var(--cream);
    width: 40rem;
    height: 40rem;
    border-radius: 1rem;
    display: flex;
    flex-direction: column;
    position: relative;
}

.close-modal {
    position: absolute; 
    top: -1rem; 
    right: -1rem; 
    background: var(--brown3); 
    border: none; 
    color: var(--cream); 
    font-size: 1.5rem; 
    font-weight: bolder;
    cursor: pointer;
    border-radius: 50%; 
    width: 3rem;
    height: 3rem;
}

.close-modal:hover {
    box-shadow: 1px 1px 5px var(--brown4);
}

.image-wrapper {
    border-radius: 0.2rem;
    width: 100%;
    height: 60%;
    border: 2px dashed var(--brown2);
    background-color: white;
}

.image-wrapper.has-image {
    border: none;
}

.modal-image {
    border-radius: 0.2rem;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.modal-title {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    margin: 1rem 0;
}

.modal-name {
    font-weight: bolder;
    font-size: 2rem;
}

.modal-price {
    font-weight: bold;
    font-size: 1.25rem;
}

.quantity-container {
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
}

.quantity-btn {
    all: unset;
    width: 2rem;
    height: 2rem;
    font-size: 1.25rem;
    text-align: center;
    justify-content: center;
    border-radius: 50%;
    background-color: var(--brown3);
    font-weight: bolder;
    color: var(--cream);
}

.quantity-btn:disabled {
    cursor: not-allowed;
    background-color: gray;
}

.quantity-btn:hover {
    box-shadow: 1px 1px 5px var(--brown4);
    cursor: pointer;
}

.quantity {
    width: 3rem;
    height: 2rem;
    padding-left: 1rem;
    font-weight: bolder;
    color: var(--brown3)
}

.submit-container {
    display: flex;
    flex-direction: row;
    justify-content: center;
    margin: 1.5rem;
}

.modal-submit {
    all: unset;
    background-color: var(--brown3);
    color: var(--cream);
    font-weight: bolder;
    padding: 1rem 2rem;
    border-radius: 1rem;
}

.modal-submit:hover {
    box-shadow: 2px 2px 10px var(--brown4);
    cursor: pointer;
}

.pagination {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    margin: 1rem 0;
}

.fixed-nav {
    all: unset;
    padding: 0.5rem 0.8rem;
    border-radius: 0.25rem;
    background: var(--brown3);
    color: var(--cream);
    border-color: var(--brown4);
    font-weight: bolder;
    cursor: pointer;
    transition: all 0.1s ease-in-out;
}

.fixed-nav:hover {
    box-shadow: 1px 1px 5px var(--brown4);
}

.fixed-nav:disabled {
    background: gray;
    border-color: gray;
    cursor: not-allowed;
}

.page-numbers {
    display: flex;
    gap: 0.4rem;
}

.page-btn {
    all: unset;
    border-radius: 0.25rem;
    padding: 0.5rem 0.8rem;
    background: var(--cream);
    color: var(--brown3);
    border-color: var(--brown4);
    cursor: pointer;
    font-weight: bold;
}

.page-btn:hover {
    box-shadow: 1px 1px 5px var(--brown4);
}

.page-btn.active {
    background: var(--brown3);
    color: var(--cream);
    font-weight: bolder;
}

.ellipsis {
    padding: 5px 10px;
    color: var(--cream);
}


@media (max-width: 1200px) {
    .products-container {
        grid-template-columns: repeat(2, minmax(0, 1fr)); 
        grid-template-rows: repeat(6, auto);  
    }
}



@media (max-width: 768px) {
    .order-container {
        flex-direction: column;
        overflow-y: auto;
        scrollbar-gutter: stable;    
    }
    .scroll-container {
        overflow-y: hidden;
    }
    .products-container {
        grid-template-columns: repeat(1, 1fr);
        grid-template-rows: repeat(12, auto);
    }
    .modal-content {
        width: 90%;
        height: auto;
    }

    .title {
        font-size: 2rem;
    }

    .left-container, .right-container {
        padding: 0.5rem;
    }

    .product-name-container {
        font-size: 1.25rem;
    }
}

@media (max-width: 480px) {
    .title {
        font-size: 1.5rem;
    }

    .modal-name {
        font-size: 1.5rem;
    }

    .modal-price {
        font-size: 1rem;
    }

    .product-name-container {
        font-size: 1rem;
    }

    .modal-content {
        width: 100%;
        height: auto;
    }

    .close-modal {
        font-size: 1rem;
        width: 2rem;
        height: 2rem;
    }



    .modal-image {
        height: 50%;
    }

    .quantity {
        width: 2rem;
    }
}

</style>