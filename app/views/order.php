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
    <img src="" id="modal-image" class="modal-image">
   <div class="modal-title">
      <span id="modal-name" class="modal-name"></span>
      <span id="modal-price" class="modal-price"></span>
    </div> 
    <p id="modal-description" class="modal-description">description</p>
    <form id="cart-form" onsubmit="addCart(event)">
        <input type="hidden" id="modal-item-id" name="item_id">
        <div class="quantity-container">
          <button class="quantity-btn disabled" type="button" id="decrease-quantity" onclick="decreaseQuantity()">&#8722;</button>
          <input class="quantity" type="number" id="quantity" name="quantity" value="1" min="1">
          <button class="quantity-btn" type="button" id="increase-quantity" onclick="increaseQuantity()">&#43;</button>
        </div>
        <div class="submit-container">
          <button class="modal-submit" id="cart-submit" type="submit">Thêm vào giỏ hàng</button>
        </div>
    </form>

    <button class="close-modal" onclick="document.getElementById('productModal').style.display='none'">X</button>
  </div>
</div>