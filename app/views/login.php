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
  <p>Không có tài khoản? <a href="index.php?page=register">Đăng kí tại đây!</a></p>
</div>

<script>
function showLoginError(message) {
    let errorBox = document.getElementById("login-error");
    errorBox.textContent = message;
    errorBox.style.display = "block";
}

function login(event){
  event.preventDefault();
  const formData=new FormData(event.target);
  let xhr=new XMLHttpRequest();
  xhr.open("POST", "index.php",true);
  formData.append("ajax",1);
  formData.append("controller","user");
  formData.append("action","loginAttempt")
  xhr.timeout = 5000; // 5 seconds
    xhr.ontimeout=function() {
      alert("Request timed out. Please try again.", true);
    }
    xhr.onreadystatechange = function () {
      if (xhr.readyState==4){
        if (xhr.status==200){
          let response=JSON.parse(xhr.responseText);
          if (response.success) {
            if (response.user_role=='admin'){
              window.location.href="index.php?page=menu";
            }
            else {
              window.location.href = "index.php?page=home";
            }
          }
          else {
            showLoginError(response.message);
          }
        }
        else {
          alert("Request failed with status: " + xhr.status, true)
        }
      }
  }
    xhr.send(formData);     
}
</script>


