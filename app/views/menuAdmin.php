<div class="order-container">
  <div class="left-container">
    <div class="title-container">
      <h1 class="title">Thực đơn</h1>
    </div>
    <input type="text" id="searchInput" class="search-bar" placeholder="Tìm kiếm...">
    <div class="cate-container">
      <div class="filter-title-container">
        <span class="filter-title">Lọc</span>
      </div>
      <div class="button-container">
        <button data-category="savory" class="toggle on" >Bánh Mì Mặn</button>
        <button data-category="sweet" class="toggle on" >Bánh Mì Ngọt</button>
        <button data-category="raw" class="toggle on">Bánh Mì Lạt</button>
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
  </div>
  <!-- Product List -->
  <div class="right-container">
    <div class="scroll-container">
      <button class="add-button" style="margin: 1rem;" onclick="openCreateModal()">
          <i class="fas fa-plus-circle" style="margin-right: 0.5rem;"></i>
          Thêm món mới
      </button>  
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
    <div class="modal-body">
        <div id="image-wrapper" class="image-wrapper">
        <img id="modal-image" class="modal-image" src="" alt="">
        </div>
        <label id="modal-image-label" for="modal-image-input" style="display: none">Chọn ảnh mới:<span style="color: red">*</span></label>
        <input id="modal-image-input" type="file" accept="image/*" style="display: none">
        <div class="modal-title" id="modal-title">
            <span id="modal-item-id" name="item_id"> </span>
            <span id="modal-name" class="modal-name"></span>
            <div class="edit-container" style="display: none">
            <label for="modal-name-input" style="display: none">
                Tên món: <span style="color: red">*</span>
            </label>
            <input type="text" id="modal-name-input" class="modal-name" style="display: none;" required>
            </div>
            <span id="modal-price" class="modal-price"></span>
            <div class="edit-container" style="display: none">
            <label for="modal-price-input" style="display: none">
                Giá: <span style="color: red">*</span>
            </label>
            <input type="number" id="modal-price-input" class="modal-price" min="0" step="1000" style="display: none;" required>
            </div>
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
    </div>
    <button class="close-modal" onclick="document.getElementById('productModal').style.display='none'">X</button>
  </div>
</div>

