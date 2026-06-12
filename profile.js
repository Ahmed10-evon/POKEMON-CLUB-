document.addEventListener("DOMContentLoaded", () => {
    // 1. Enforce route authentication security checks
    sessionUser = JSON.parse(localStorage.getItem('loggedInUser'));
    if (!sessionUser) {
        window.location.href = 'signin.html';
        return;
    }

    document.getElementById('card-username').textContent = sessionUser.username;
    
    if (!sessionUser.favoritePokemonId) {
        sessionUser.favoritePokemonId = "25"; 
    }
    document.getElementById('card-sprite').src = `https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/${sessionUser.favoritePokemonId}.png`;

    // 3. Initialize Input fields value arrays within target settings form panels
    document.getElementById('settings-username').value = sessionUser.username;
    document.getElementById('settings-email').value = sessionUser.email;
    document.getElementById('settings-fav').value = sessionUser.favoritePokemonId;

    renderActivityFeed();
});

function switchTab(tabId) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.menu-btn').forEach(el => el.classList.remove('active'));

    document.getElementById(`tab-${tabId}`).classList.add('active');
    
    const targetButton = Array.from(document.querySelectorAll('.menu-btn'))
        .find(btn => btn.textContent.toLowerCase().includes(tabId));
    if(targetButton) targetButton.classList.add('active');
}

function previewSpriteChange() {
    const chosenId = document.getElementById('settings-fav').value;
    document.getElementById('card-sprite').src = `https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/${chosenId}.png`;
}

function renderActivityFeed() {
    const feed = document.getElementById('activity-feed');
    
    const logs = [
        { title: 'Posted on Bulletin Board thread: "Scarlet & Violet Discussion"', time: '38 minutes ago', category: 'Comment' },
        { title: 'Achieved Ranked Multiplier Milestone: "Gym Leader status obtained!"', time: '2 hours ago', category: 'System Achievement' },
        { title: 'Completed interactive evaluation game module: "Who\'s That Pokémon Quiz"', time: 'Yesterday @ 4:12 PM', category: 'Game Data Record' }
    ];

    feed.innerHTML = ""; 
    logs.forEach(log => {
        const entry = document.createElement('div');
        entry.className = 'activity-item';
        entry.innerHTML = `
            <div class=\"activity-title\">${log.title}</div>
            <div class=\"activity-meta\">Category: <strong>${log.category}</strong> &bull; Registered timestamp: ${log.time}</div>
        `;
        feed.appendChild(entry);
    });
}

function updateAccount(event) {
    event.preventDefault();

    const usernameInput = document.getElementById('settings-username').value.trim();
    const favInput = document.getElementById('settings-fav').value;
    const passwordInput = document.getElementById('settings-password').value;
    const confirmInput = document.getElementById('settings-confirm').value;
    const msg = document.getElementById('status-message');

    msg.className = "";
    msg.textContent = "";

    if (usernameInput.length < 3) {
        msg.textContent = "Trainer Name must exceed 3 operational characters.";
        msg.className = "msg-error";
        return;
    }

    if (passwordInput !== "") {
        if (passwordInput.length < 4) {
            msg.textContent = "Security passwords constraints must measure minimum 4 positions.";
            msg.className = "msg-error";
            return;
        }
        if (passwordInput !== confirmInput) {
            msg.textContent = "Provided confirmation fields validation arrays do not match.";
            msg.className = "msg-error";
            return;
        }
        sessionUser.password = passwordInput;
    }

    sessionUser.username = usernameInput;
    sessionUser.favoritePokemonId = favInput;

    let userDatabase = JSON.parse(localStorage.getItem('pokemonClubUsers')) || [];
    
    const matchIndex = userDatabase.findIndex(u => u.email === sessionUser.email);
    if (matchIndex !== -1) {
        userDatabase[matchIndex] = sessionUser;
    } else {
        userDatabase.push(sessionUser);
    }

    localStorage.setItem('pokemonClubUsers', JSON.stringify(userDatabase));
    localStorage.setItem('loggedInUser', JSON.stringify(sessionUser));

    document.getElementById('card-username').textContent = sessionUser.username;
    
    msg.textContent = "Trainer credentials updated successfully!";
    msg.className = "msg-success";
    
    document.getElementById('settings-password').value = "";
    document.getElementById('settings-confirm').value = "";
}