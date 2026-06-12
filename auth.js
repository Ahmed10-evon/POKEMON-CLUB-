document.addEventListener("DOMContentLoaded", () => {
    const loggedInUser = JSON.parse(localStorage.getItem('loggedInUser'));
    const signInBtn = document.querySelector('.btn-signin');

    if (signInBtn) {
        if (loggedInUser) {
           
            signInBtn.textContent = `Logout (${loggedInUser.username})`;
            signInBtn.style.backgroundColor = "#e53e3e"; 
            signInBtn.href = "#";
            
            signInBtn.addEventListener('click', (e) => {
                e.preventDefault();
                localStorage.removeItem('loggedInUser');
                window.location.reload(); 
            });
        } else {
            signInBtn.textContent = "Sign In";
            signInBtn.href = "signin.html";
            signInBtn.style.backgroundColor = "#50b47b";
        }
    }
});