// auth.js - Shared Authentication Logic across all pages
document.addEventListener("DOMContentLoaded", () => {
    const loggedInUser = JSON.parse(localStorage.getItem('loggedInUser'));
    const signInBtn = document.querySelector('.btn-signin');

    if (signInBtn) {
        if (loggedInUser) {
            // Update button UI to showcase active session
            signInBtn.textContent = `Logout (${loggedInUser.username})`;
            signInBtn.style.backgroundColor = "#e53e3e"; // Red logout styling
            signInBtn.href = "#";
            
            signInBtn.addEventListener('click', (e) => {
                e.preventDefault();
                localStorage.removeItem('loggedInUser');
                window.location.reload(); // Refresh to clean up the session states
            });
        } else {
            signInBtn.textContent = "Sign In";
            signInBtn.href = "signin.html";
            signInBtn.style.backgroundColor = "#50b47b";
        }
    }
});