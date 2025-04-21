
document.addEventListener('DOMContentLoaded', () => {
    const logoutButton=document.getElementById("logout-button");
    logoutButton.addEventListener('click', logout);
});

function logout() {
    let xhr=new XMLHttpRequest();
    xhr.open("POST", "index.php",true);
    let formData = new FormData(); 
    formData.append("ajax", "1");
    formData.append("controller", "user");
    formData.append("action", "logOut");

    xhr.timeout = 5000; // 5 seconds
    xhr.ontimeout=function() {
        alert("Request timed out. Please try again.");
    }
    xhr.onreadystatechange = function () {
        if (xhr.readyState==4){
            if (xhr.status==200){
                let response=JSON.parse(xhr.responseText);
                if (response.success) {
                    window.location.href = "home";
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