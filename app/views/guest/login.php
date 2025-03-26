<div class="login-container">
  <h2>Login</h2>
  <form onsubmit="login(event)">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    
    <button type="submit">Login</button>
  </form>
</div>


<script>
function login(event){
  event.preventDefault();
  const formData=new FormData(event.target);
  let xhr=new XMLHttpRequest();
  xhr.open("POST", "index.php",true);
  formData.append("ajax",1);
  formData.append("controller","login");
  formData.append("action","loginAttempt")
}
</script>