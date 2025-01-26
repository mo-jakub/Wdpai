document.addEventListener("DOMContentLoaded", () => {
    const passwordInput = document.querySelector('input[name="password"]');

    const bubble = document.createElement("div");
    bubble.textContent = "";
    bubble.style.position = "absolute";
    bubble.style.backgroundColor = "rgba(255, 0, 0, 0.8)";
    bubble.style.color = "white";
    bubble.style.padding = "5px 10px";
    bubble.style.borderRadius = "5px";
    bubble.style.fontSize = "0.9em";
    bubble.style.whiteSpace = "nowrap";
    bubble.style.display = "none";
    bubble.style.zIndex = "10";

    passwordInput.parentElement.appendChild(bubble);

    passwordInput.addEventListener("input", () => {
        const password = passwordInput.value;

        if (password.length < 8) {
            bubble.textContent = "Password is too short (at least 8 characters).";
            bubble.style.display = "flex";

            const inputRect = passwordInput.getBoundingClientRect();
            const bubbleOffset = 10;
            bubble.style.top = `${passwordInput.offsetTop}px`;
            bubble.style.left = `${passwordInput.offsetWidth + bubbleOffset}px`;
        } else {
            bubble.style.display = "none";
        }
    });
});