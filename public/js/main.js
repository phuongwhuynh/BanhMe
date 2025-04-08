let notificationTimeout = null;

function showNotification(message = "Item added to cart", isError = false) {
    const popup = document.getElementById("notification-popup");
    const content = popup.querySelector(".notification-content");

    content.textContent = message;
    content.classList.remove("pulse", "error");

    if (isError) content.classList.add("error");

    // Re-trigger pulse animation
    void content.offsetWidth;
    content.classList.add("pulse");

    popup.style.display = "block";
    popup.style.opacity = "1";

    if (notificationTimeout) clearTimeout(notificationTimeout);

    notificationTimeout = setTimeout(() => {
        popup.style.opacity = "0";
        setTimeout(() => {
            popup.style.display = "none";
        }, 500);
        notificationTimeout = null;
    }, 1000);
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

window.addEventListener("DOMContentLoaded", () => {
    const userRole = document.body.getAttribute("data-user-role");
    if (userRole === "user") {
        window.onclick = function(event) {
            if (!event.target.closest('.profile-container')) {
                document.getElementById("dropdown-menu").style.display = "none";
            }
        };
    }
});