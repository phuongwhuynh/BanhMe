<div class="logger-container">
  <h2>Đăng nhập</h2>
  <div id="login-error" class="hidden"></div>

  <form onsubmit="login(event)">
    <label for="username">Tài khoản:</label>
    <input type="text" id="username" name="username" required>
    
    <label for="password">Mật khẩu:</label>
    <input type="password" id="password" name="password" required>
    
    <button type="submit">Đăng nhập</button>
  </form>
  <p>Không có tài khoản? <a href="register">Đăng kí tại đây!</a></p>
</div>




