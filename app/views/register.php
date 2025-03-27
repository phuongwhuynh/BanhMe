<div class="register-container">
  <h2>Register</h2>
  <form onsubmit="register(event)">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    
    <button type="submit">Register</button>
  </form>
  <p>Already have an account? <a href="index.php?page=login">Sign in here!</a></p>
</div>

<script>
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
          console.log("Successful registration");
          window.location.href = "index.php?page=home";
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
</style>