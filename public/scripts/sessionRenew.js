/**
 * This script ensures the user's session is kept active by checking every 15 minutes
 * whether the user has been active. If the user is active, a request is sent
 * to the server to extend the session.
 */

document.addEventListener('DOMContentLoaded', () => {
    let lastActivityTime = Date.now(); // Tracks the last activity time of the user.

    /**
     * Function to extend the user's session by sending a request to the server.
     * The server is notified only if the user has been active in the last 15 minutes.
     */
    function extendSession() {
        const currentTime = Date.now(); // Get the current time
        const timeSinceLastActivity = currentTime - lastActivityTime;

        // If the user has been active within the last 15 minutes, send the request
        if (timeSinceLastActivity <= 900000) { // 900,000 ms = 15 minutes
            fetch('/extendSession', { method: 'POST' })
                .then(response => response.json()) // Parse response from the server
                .then(data => console.log('Session extended:', data)) // Log success message
                .catch(error => console.error('Error renewing session:', error)); // Log errors if any
        }
    }

    /**
     * Updates the `lastActivityTime` whenever the user interacts with the page.
     * These interactions include mouse movement, key presses, and clicks.
     */
    function resetActivityTimer() {
        lastActivityTime = Date.now(); // Update the last activity time to the current time
    }

    // Attach event listeners to track user activity
    document.body.addEventListener('mousemove', resetActivityTimer);
    document.body.addEventListener('keydown', resetActivityTimer);
    document.body.addEventListener('click', resetActivityTimer);

    // Periodically check if the user's session needs to be extended
    setInterval(extendSession, 900000); // Check every 15 minutes
});