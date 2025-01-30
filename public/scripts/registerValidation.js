/**
 * This script provides live validation feedback for a password input field on a registration form.
 * It dynamically displays a tooltip to inform the user if the entered password is too short.
 */

document.addEventListener("DOMContentLoaded", () => {
    // Select the password input field
    const passwordInput = document.querySelector('input[name="password"]');

    // Create a tooltip element for displaying validation messages
    const bubble = document.createElement("div");
    bubble.textContent = ""; // Initial message is empty
    bubble.style.position = "absolute"; // Position the bubble near the input field
    bubble.style.backgroundColor = "white";
    bubble.style.color = "black";
    bubble.style.padding = "5px 10px";
    bubble.style.borderRadius = "5px";
    bubble.style.fontSize = "0.9em";
    bubble.style.visibility = "hidden"; // Initially hidden
    bubble.style.zIndex = "10"; // Ensure it appears above other elements

    // Append the bubble to the document body
    document.body.appendChild(bubble);

    /**
     * Event listener for the password input field.
     * Checks the length of the entered password and updates the tooltip message and position.
     */
    passwordInput.addEventListener("input", () => {
        const password = passwordInput.value; // Current value of the password field

        if (password.length < 8) {
            // Update the tooltip message and make it visible
            bubble.textContent = "Password is too short (at least 8 characters).";
            bubble.style.visibility = "visible";

            // Get the position of the password input field relative to the viewport
            const inputRect = passwordInput.getBoundingClientRect();
            const bubbleOffset = 10; // Offset distance of the bubble from the input field

            // Position the bubble near the input field
            bubble.style.top = `${window.scrollY + inputRect.top}px`;
            bubble.style.left = `${window.scrollX + inputRect.right + bubbleOffset}px`;
        } else {
            // Hide the tooltip if the password is valid
            bubble.style.visibility = "hidden";
        }
    });
});