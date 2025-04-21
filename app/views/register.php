
<div class="register-container">
  <h1>Đăng ký</h1>

  <div id="register-error" class="hidden"></div>
  <form onsubmit="register(event)">
  <div class="wrapper">
    <label for="username">Tên đăng nhập:<span style="color: red;">*</span></label>
    <input type="text" id="username" name="username" required>
  </div>
  <div class="password-wrapper">
    <label for="password">Mật khẩu:<span style="color: red;">*</span></label>
    <input type="password" id="password" name="password" required
           onfocus="showTooltip()" onblur="hideTooltip()">

    <div id="password-tooltip" class="tooltip hidden">
      <h4>Yêu cầu về mật khẩu:</h4>
      <ul>
        <li>Ít nhất 8 ký tự</li>
        <li>Ít nhất một chữ cái viết hoa (A-Z)</li>
        <li>Ít nhất một chữ cái viết thường (a-z)</li>
        <li>Ít nhất một chữ số (0-9)</li>
        <li>Ít nhất một ký tự đặc biệt (ví dụ: !@#$%^&*)</li>
      </ul>
    </div>
  </div>
  <div class="wrapper">
    <label for="confirm-password">Xác nhận mật khẩu:<span style="color: red;">*</span></label>
    <input type="password" id="confirm-password" name="confirm-password" required>
  </div>
  <button type="submit">Đăng ký</button>
  </form>
  <p>Đã có tài khoản? <a href="login">Đăng nhập tại đây!</a></p>
</div>


