// signin.js - Form validation, interaction toggling, and storage lookup
let isLoginMode = true;

function toggleMode() {
    isLoginMode = !isLoginMode;
    const title = document.getElementById('auth-title');
    const subtitle = document.getElementById('auth-subtitle');
    const usernameGroup = document.getElementById('username-group');
    const submitBtn = document.getElementById('submit-btn');
    const toggleText = document.getElementById('toggle-text');
    const toggleLink = document.getElementById('toggle-link');
    document.getElementById('error-message').textContent = "";

    if (isLoginMode) {
        title.textContent = "Welcome Back";
        subtitle.textContent = "Log in to manage your team and access the club forum.";
        usernameGroup.style.display = "none";
        document.getElementById('username').required = false;
        submitBtn.textContent = "Sign In";
        toggleText.textContent = "New to the club? ";
        toggleLink.textContent = "Create an Account";
    } else {
        title.textContent = "Join the Club";
        subtitle.textContent = "Sign up today to collect badges and join active discussions.";
        usernameGroup.style.display = "block";
        document.getElementById('username').required = true;
        submitBtn.textContent = "Register";
        toggleText.textContent = "Already a member? ";
        toggleLink.textContent = "Sign In Here";
    }
}

function handleAuth(event) {
    event.preventDefault();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const errMsg = document.getElementById('error-message');
    
    // Fetch user array or instantiate a blank slate
    let users = JSON.parse(localStorage.getItem('pokemonClubUsers')) || [];

    if (isLoginMode) {
        // Find matching user records
        const user = users.find(u => u.email === email && u.password === password);
        if (user) {
            localStorage.setItem('loggedInUser', JSON.stringify(user));
            window.location.href = 'index.html';
        } else {
            errMsg.textContent = "Invalid email or password combination.";
        }
    } else {
        const username = document.getElementById('username').value.trim();
        
        // Form Validations
        if (users.some(u => u.email === email)) {
            errMsg.textContent = "An account with this email already exists.";
            return;
        }
        if (username.length < 3) {
            errMsg.textContent = "Trainer name must be at least 3 characters long.";
            return;
        }

        // Register and Save New User
        const newUser = { username, email, password };
        users.push(newUser);
        localStorage.setItem('pokemonClubUsers', JSON.stringify(users));
        localStorage.setItem('loggedInUser', JSON.stringify(newUser));
        
        window.location.href = 'index.html';
    }
}