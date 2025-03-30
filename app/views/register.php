<div class="register-container">
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

</style>