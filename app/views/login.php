<div class="login-container">
  <h2>Login</h2>
  <form onsubmit="login(event)">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    
    <button type="submit">Login</button>
  </form>
  <p>Don't have an account? <a href="index.php?page=register">Register here!</a></p>
</div>

<script>
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
        alert("Request timed out. Please try again.");
    }
    xhr.onreadystatechange = function () {
      if (xhr.readyState==4){
        if (xhr.status==200){
          let response=JSON.parse(xhr.responseText);
          if (response.success) {
            //todo: return to page home
            console.log("successful login")
            window.location.href = "index.php?page=home";
          }
          else {
            alert(response.message);
          }
        }
        else {
          alert("Request failed with status: " + xhr.status)
        }
      }
  }
    xhr.send(formData);     
}
</script>

<style>
  .login-container {
    padding: 1rem;
  }
</style>
