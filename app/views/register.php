<!-- <div class="register-container">
  <h1>Đăng ký</h1>
    <div class="password-requirements">
      <h4>Yêu cầu về mật khẩu:</h4>
      <ul>
        <li>Ít nhất 8 ký tự</li>
        <li>Ít nhất một chữ cái viết hoa (A-Z)</li>
        <li>Ít nhất một chữ cái viết thường (a-z)</li>
        <li>Ít nhất một chữ số (0-9)</li>
        <li>Ít nhất một ký tự đặc biệt (ví dụ: !@#$%^&*)</li>
      </ul>
    </div>
    <div id="register-error" class="hidden"></div>
      <form onsubmit="register(event)">
        <label for="username">Tên đăng nhập:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password" required>
        
        <label for="confirm-password">Xác nhận mật khẩu:</label>
        <input type="password" id="confirm-password" name="confirm-password" required>
            
        <button type="submit">Đăng ký</button>
      </form>
      <p>Đã có tài khoản? <a href="index.php?page=login">Đăng nhập tại đây!</a></p>
</div> -->
<div class="register-container">
  <h1>Đăng ký</h1>

  <div id="register-error" class="hidden"></div>
  <form onsubmit="register(event)">
  <div class="wrapper">
    <label for="username">Tên đăng nhập:</label>
    <input type="text" id="username" name="username" required>
  </div>
  <div class="password-wrapper">
    <label for="password">Mật khẩu:</label>
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
    <label for="confirm-password">Xác nhận mật khẩu:</label>
    <input type="password" id="confirm-password" name="confirm-password" required>
  </div>
  <button type="submit">Đăng ký</button>
  </form>
  <p>Đã có tài khoản? <a href="index.php?page=login">Đăng nhập tại đây!</a></p>
</div>

<script>
function showTooltip() {
  const tooltip = document.getElementById('password-tooltip');
  tooltip.classList.add('show');
  tooltip.classList.remove('hidden');
}

function hideTooltip() {
  const tooltip = document.getElementById('password-tooltip');
  tooltip.classList.remove('show');
  setTimeout(() => {
    tooltip.classList.add('hidden');
  }, 300); // match the CSS transition time
}


function showRegisterError(message) {
  let errorBox = document.getElementById("register-error");
  errorBox.textContent = message;
  errorBox.style.display = "block";
}

function validatePassword(password) {
  // Kiểm tra yêu cầu mật khẩu
  const minLength = 8;
  const hasUpperCase = /[A-Z]/.test(password);
  const hasLowerCase = /[a-z]/.test(password);
  const hasNumber = /[0-9]/.test(password);
  const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);

  return password.length >= minLength && hasUpperCase && hasLowerCase && hasNumber && hasSpecialChar;
}

function register(event) {
  event.preventDefault();
  const username = document.getElementById('username').value.trim();
  const password = document.getElementById('password').value;
  const confirmPassword = document.getElementById('confirm-password').value;
  
  // Kiểm tra nếu mật khẩu xác nhận trùng khớp
  if (password !== confirmPassword) {
    showRegisterError("Mật khẩu không khớp.");
    return;
  }

  // Kiểm tra yêu cầu mật khẩu
  if (!validatePassword(password)) {
    showRegisterError("Mật khẩu phải có ít nhất 8 ký tự, bao gồm một chữ cái viết hoa, một chữ cái viết thường, một chữ số và một ký tự đặc biệt.");
    return;
  }

  const formData = new FormData(event.target);
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "index.php", true);
  formData.append("ajax", 1);
  formData.append("controller", "user");
  formData.append("action", "registerAttempt");
  
  xhr.timeout = 5000; // 5 giây
  xhr.ontimeout = function() {
    alert("Yêu cầu đã hết thời gian. Vui lòng thử lại.");
  }
  
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {
      if (xhr.status == 200) {
        let response = JSON.parse(xhr.responseText);
        if (response.success) {
          showNotification("Đăng ký thành công. Vui lòng đăng nhập lại. Đang chuyển hướng...");
          setTimeout(() => {
              window.location.href = "index.php?page=login";
          }, 2000);
        } else {
          alert(response.message);
        }
      } else {
        alert("Yêu cầu thất bại với mã trạng thái: " + xhr.status);
      }
    }
  }
  xhr.send(formData);
}
</script>

<style>

</style>
