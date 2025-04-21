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
              window.location.href="menu";
            }
            else {
              window.location.href = "home";
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