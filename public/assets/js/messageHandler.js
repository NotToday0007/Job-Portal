function showMessage(message, type) {
    const messageDiv = document.getElementById('message');
    messageDiv.style.display = 'block'; // Show the message div

    // Set the message and style based on the type
    if (type === 'success') {
        messageDiv.innerHTML = `<p style="color: green;">${message}</p>`;
    } else if (type === 'error') {
        messageDiv.innerHTML = `<p style="color: red;">${message}</p>`;
    }

    // Fade out the message after 5 seconds
    setTimeout(() => {
        messageDiv.style.opacity = '0'; // Start fading out
        setTimeout(() => {
            messageDiv.style.display = 'none'; // Hide the message div
            messageDiv.innerHTML = ''; // Clear the message
            messageDiv.style.opacity = '1'; // Reset opacity for the next message
        }, 400); // Wait for the fade out to complete before hiding
    }, 4000);
}
// Function to handle AJAX requests
function makeRequest(url, method = 'GET', headers = {}) {
    return fetch(url, {
        method: method,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            ...headers
        }
    });
}
