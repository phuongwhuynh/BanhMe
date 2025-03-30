function showNotification(message, isError = false) {
    let notification = document.getElementById("notification-popup");
    notification.textContent = message;
    notification.classList.remove("hidden");

    if (isError) {
        notification.classList.add("error");
    } else {
        notification.classList.remove("error");
    }

    notification.style.display = "block";

    // Auto-hide after 3 seconds
    setTimeout(() => {
        notification.style.opacity = "0";
        setTimeout(() => {
            notification.style.display = "none";
            notification.style.opacity = "1";
        }, 500);
    }, 3000);
}

function toggleDropdown() {
    let menu = document.getElementById("dropdown-menu");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
}

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

window.onclick = function(event) {
    if (!event.target.closest('.profile-container')) {
        document.getElementById("dropdown-menu").style.display = "none";
    }
};
