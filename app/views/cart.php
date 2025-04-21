<h1>Giỏ hàng</h1>
<div class="cart-container">
    <div class="left-container">
        <div class="item-list" id="item-list">
    </div>
    </div>
    <div class="right-container">
        <div class="payment-container">
            <div class="money-container">
                <span>Tổng cộng: </span>
                <div class="total-money-container" id="total-money">0VND</div>
            </div>
            <div class="shipping-method-container">
                <input type="radio" name="shipping" value="ship" id="ship" hidden>
                <label for="ship" class="shipping-button">Giao hàng</label>

                <input type="radio" name="shipping" value="takeout" id="takeout" hidden>
                <label for="takeout" class="shipping-button">Tự đến lấy</label>
            </div>
            <div class="payment-method-container" id="paymentMethodContainer" style="display: none;">
                <form>
                    <div class="method-choice-container" >
                        <input type="radio" name="payment" id="inplace" value="inplace">
                        <label for="inplace" class="payment-option">Thanh toán tại địa điểm giao hàng</label>
                    </div>
                    <div class="method-choice-container">
                        <input type="radio" name="payment" id="transfer" value="transfer">
                        <label for="transfer" class="payment-option">Thanh toán bằng chuyển khoản</label>
                    </div>
                </form>
            </div>
            <div class="shipping-info-container" id="shippingInfoContainer" style="display: none;">
                <form>
                    <div class="name-phone-container">
                        <input type="text" id="customer_name" name="customer_name" placeholder="Tên">
                        <input type="text" id="customer_phone" name="customer_phone" placeholder="Số điện thoại">
                    </div>
                    <textarea id="customer_address" name="customer_address" placeholder="Địa chỉ" style="display: none;"></textarea>
                </form>
            </div>
            <button class="submit-button" id="submitButton" style="display: none;">Thanh toán</button>
        </div>
    </div>
</div>
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <p>Bạn chắc chắn muốn bỏ sản phẩm này?</p>
        <button id="confirmDelete" class="modal-btn">Có, xóa</button>
        <button id="cancelDelete" class="modal-btn">Không</button>
    </div>
</div>

