/**
 * This script handles the functionality of a dropdown menu controlled by a "menu icon".
 * Users can toggle the visibility of the dropdown menu by clicking on the menu icon.
 * The dropdown menu automatically hides when the user clicks outside of it.
 */

document.addEventListener("DOMContentLoaded", function () {
    // Select the menu icon element
    const menuIcon = document.querySelector(".menu-icon");

    // Select the dropdown menu element
    const dropdownMenu = document.querySelector(".dropdown-menu");

    /**
     * Toggles the "active" class on the dropdown menu when the menu icon is clicked.
     */
    menuIcon.addEventListener("click", function () {
        dropdownMenu.classList.toggle("active");
    });

    /**
     * Hides the dropdown menu when the user clicks out of the menu icon or the dropdown menu.
     *
     * @param {Event} e - The click event triggered on the document.
     */
    document.addEventListener("click", function (e) {
        // Check if the click was outside the menu icon and the dropdown menu
        if (!menuIcon.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.remove("active"); // Hide the dropdown menu
        }
    });
});