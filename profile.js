document.addEventListener("DOMContentLoaded", () => {
    const user = JSON.parse(localStorage.getItem('loggedInUser'));

    if (!user) {
        window.location.href = 'signin.html';
        return; 
    }

  
    document.getElementById('profile-username').textContent = user.username;
    document.getElementById('profile-email').textContent = user.email;

    
    const activityFeed = document.getElementById('activity-feed');
    
    const mockActivities = [
        {
            title: `Replied to: "Best moveset for Gengar in Gen 9?"`,
            date: "Today at 2:30 PM",
            type: "Comment"
        },
        {
            title: `Started a new discussion: "Looking to trade Violet exclusives!"`,
            date: "Yesterday at 6:15 PM",
            type: "New Post"
        },
        {
            title: `Joined the club! Welcome, ${user.username}!`,
            date: "Account Creation",
            type: "Milestone"
        }
    ];

    activityFeed.innerHTML = "";

    mockActivities.forEach(activity => {
        const li = document.createElement('li');
        li.className = 'activity-item';
        
        li.innerHTML = `
            <div class="activity-title">${activity.title}</div>
            <div class="activity-meta">Type: <strong>${activity.type}</strong> • ${activity.date}</div>
        `;
        
        activityFeed.appendChild(li);
    });
});