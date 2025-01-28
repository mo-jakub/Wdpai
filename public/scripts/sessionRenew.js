let debounceTimeout;

function extendSession() {
    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(() => {
        fetch('/extendSession', { method: 'POST' })
            .then(response => response.json())
            .then(data => console.log('Session extended:', data))
            .catch(error => console.error('Error renewing session:', error));
    }, 900000); // 15-min delay
}

document.body.addEventListener('mousemove', extendSession);
document.body.addEventListener('keydown', extendSession);
document.body.addEventListener('click', extendSession);