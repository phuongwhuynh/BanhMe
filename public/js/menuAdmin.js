function openCreateModal() {
    document.getElementById("modal-item-id").innerHTML = "";
    document.getElementById("modal-name-input").value = "";
    document.getElementById("modal-price-input").value = 0;
    document.getElementById("modal-description-input").value = "";
    document.getElementById("modal-image-input").value = "";
    document.getElementById("modal-image").src = "";

    // Hide spans
    document.getElementById("modal-title").classList.add("edit");
    document.getElementById("modal-name").style.display = "none";
    document.getElementById("modal-price").style.display = "none";
    document.getElementById("modal-description").style.display = "none";
    document.querySelectorAll(".edit-container").forEach(function(element) {
      element.style.display = "flex";
    });

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
    document.querySelectorAll(".edit-container").forEach(function(element) {
      element.style.display = "none";
    });

    // Show spans
    document.getElementById("modal-title").classList.remove("edit");
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
    document.querySelectorAll(".edit-container").forEach(function(element) {
      element.style.display = "flex";
    });
    document.getElementById("modal-title").classList.add("edit");
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
