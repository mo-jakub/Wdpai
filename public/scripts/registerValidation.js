document.addEventListener("DOMContentLoaded", () => {
    const passwordInput = document.querySelector('input[name="password"]');

    const bubble = document.createElement("div");
    bubble.textContent = "";
    bubble.style.position = "absolute";
    bubble.style.backgroundColor = "white";
    bubble.style.color = "black";
    bubble.style.padding = "5px 10px";
    bubble.style.borderRadius = "5px";
    bubble.style.fontSize = "0.9em";
    bubble.style.visibility = "hidden";
    bubble.style.zIndex = "10";

    document.body.appendChild(bubble);

    passwordInput.addEventListener("input", () => {
        const password = passwordInput.value;

        if (password.length < 8) {
            bubble.textContent = "Password is too short (at least 8 characters).";
            bubble.style.visibility = "visible";

            const inputRect = passwordInput.getBoundingClientRect();
            const bubbleOffset = 10;

            bubble.style.top = `${window.scrollY + inputRect.top}px`;
            bubble.style.left = `${window.scrollX + inputRect.right + bubbleOffset}px`;
        } else {
            bubble.style.visibility = "hidden";
        }
    });
});