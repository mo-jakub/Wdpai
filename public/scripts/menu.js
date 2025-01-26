document.addEventListener("DOMContentLoaded", function () {
    const menuIcon = document.querySelector(".menu-icon");
    const dropdownMenu = document.querySelector(".dropdown-menu");

    menuIcon.addEventListener("click", function () {
        dropdownMenu.classList.toggle("active");
    });
    
    document.addEventListener("click", function (e) {
        if (!menuIcon.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.remove("active");
        }
    });
});