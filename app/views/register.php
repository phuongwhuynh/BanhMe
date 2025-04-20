<!-- <div class="register-container">
  <h2>Register</h2>
  <div id="register-error" class="hidden"></div>

  <form onsubmit="register(event)">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
        
    <button type="submit">Register</button>
  </form>
  <p>Already have an account? <a href="index.php?page=login">Sign in here!</a></p>
</div>

<script>
//to do: make the user type password twice
function showRegisterError(message) {
  let errorBox = document.getElementById("register-error");
  errorBox.textContent = message;
  errorBox.style.display = "block";
}

function register(event){
  event.preventDefault();
  const formData = new FormData(event.target);
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "index.php", true);
  formData.append("ajax", 1);
  formData.append("controller", "user");
  formData.append("action", "registerAttempt");
  
  xhr.timeout = 5000; // 5 seconds
  xhr.ontimeout = function() {
    alert("Request timed out. Please try again.");
  }
  
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {
      if (xhr.status == 200) {
        let response = JSON.parse(xhr.responseText);
        if (response.success) {
          showNotification("Successful registration. Please Login Again. Redirecting...");
          setTimeout(() => {
              window.location.href = "index.php?page=login";
          }, 2000);
        } else {
          alert(response.message);
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
  .register-container {
    padding: 1rem;
  }
  #register-error {
    margin-bottom: 15px;
    padding: 10px;
    background-color: #dc3545; 
    color: var(--cream);
    border-radius: 5px;
    text-align: center;
    font-size: 16px;
    font-weight: bold;
    display: none;
  }

  .hidden {
      display: none;
  }

</style> -->

<div class="register-container">
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
</div>

<script>
function showRegisterError(message) {
  let errorBox = document.getElementById("register-error");
  errorBox.textContent = message;
  errorBox.style.display = "block";
}

function validatePassword(password) {
  const minLength = 8;
  const hasUpperCase = /[A-Z]/.test(password);
  const hasLowerCase = /[a-z]/.test(password);
  const hasNumber = /[0-9]/.test(password);
  const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);

  return password.length >= minLength && hasUpperCase && hasLowerCase && hasNumber && hasSpecialChar;
}

function register(event) {
  event.preventDefault();
  
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
  /* General Container Styling */
.register-container {
  width: 25rem;
  margin: 2rem auto;
  padding: 2rem;
  background-color: #f8f9fa;
  border-radius: 0.5rem;
  box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
}

h1 {
  text-align: center;
  margin-bottom: 1rem;
  font-size: 1.5rem; /* 24px */
  color: #007bff;
}

/* Password requirements styling */
.password-requirements {
  margin-bottom: 1rem;
  font-size: 0.875rem; /* 14px */
}

.password-requirements h4 {
  font-weight: bold;
  margin-bottom: 0.5rem;
}

.password-requirements ul {
  list-style: none;
  padding-left: 0;
  margin: 0;
}

.password-requirements li {
  margin-bottom: 0.5rem;
  color: #555;
}

/* Error message box */
#register-error {
  margin-bottom: 1rem;
  padding: 0.625rem;
  background-color: #dc3545;
  color: white;
  border-radius: 0.375rem;
  text-align: center;
  font-size: 1rem; /* 16px */
  font-weight: bold;
  display: none;
}

/* Form styling */
form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

label {
  font-size: 1rem; /* 16px */
  font-weight: bold;
  margin-bottom: 0.3125rem;
  color: #333;
}

input[type="text"], input[type="password"] {
  padding: 0.75rem;
  margin-bottom: 1rem;
  border-radius: 0.375rem;
  border: 1px solid #ccc;
  font-size: 1rem; /* 16px */
}

input[type="text"]:focus, input[type="password"]:focus {
  border-color: #007bff;
  outline: none;
}

button {
  padding: 0.75rem;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 0.375rem;
  cursor: pointer;
  font-size: 1rem; /* 16px */
  font-weight: bold;
}

button:hover {
  background-color: #0056b3;
}

/* Additional styling for links */
p {
  text-align: center;
  font-size: 0.875rem; /* 14px */
}

a {
  color: #007bff;
  text-decoration: none;
  font-weight: bold;
}

a:hover {
  text-decoration: underline;
}

/* Responsive Styling */
@media (max-width: 30rem) { /* Equivalent to 480px */
  .register-container {
    padding: 1.5rem;
  }

  h1 {
    font-size: 1.25rem; /* 20px */
  }

  input[type="text"], input[type="password"], button {
    font-size: 0.875rem; /* 14px */
  }
}
</style>
