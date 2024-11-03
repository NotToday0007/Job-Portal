// public/js/common.js

// Show loader
function showLoader() {
    console.log("Showing loader...");
    document.getElementById('loader').style.display = 'block';
}

// Hide loader
function hideLoader() {
    const loader = document.getElementById('loader');
    if (loader) {
        console.log("Hiding loader...");
        loader.style.display = 'none';
    }
}

// Automatically hide loader on page load and on popstate
window.onload = () => {
    hideLoader(); // Hide loader when the page is fully loaded
    console.log("Page fully loaded, hideLoader executed");
};
window.addEventListener('popstate', hideLoader);
