<?php
session_start();

if(!isset($_SESSION['user'])) {
    header("Location: signin.php");
    exit();
}

$current_tab = isset($_GET['tab']) ? $_GET['tab'] : 'activity';
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | Pokémon Club</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background-color: #f0f4f8; color: #444; }
        
        .container { display: grid; grid-template-columns: 320px 1fr; gap: 30px; padding: 40px 5%; max-width: 1300px; margin: 0 auto; }
        
        .card { background: white; padding: 30px 20px; border-radius: 16px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .avatar-lg { width: 110px; height: 110px; background: #e2e8f0; border-radius: 50%; margin: 0 auto 15px; border: 4px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.08); display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .avatar-lg img { width: 95px; height: 95px; object-fit: contain; }
        
        .trainer-name { font-size: 22px; font-weight: bold; color: #2d3748; margin-bottom: 5px; text-transform: lowercase; }
        .rank-badge { background: #ffcb05; color: #2d3748; font-weight: 800; font-size: 11px; padding: 4px 14px; border-radius: 12px; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block; }
        
        .profile-nav { margin-top: 30px; display: flex; flex-direction: column; gap: 8px; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 12px 20px; background: #f7fafc; color: #4a5568; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 14px; transition: 0.2s; text-align: left; border: 1px solid transparent; }
        .nav-item:hover { background: #edf2f7; color: #2b6cb0; }
        .nav-item.active { background: #2b6cb0; color: white; box-shadow: 0 4px 12px rgba(43, 108, 176, 0.2); }

        .content-panel { background: white; border-radius: 16px; padding: 40px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .content-panel h2 { color: #2b6cb0; font-size: 24px; margin-bottom: 20px; }
        .divider { margin: 15px 0 25px 0; border: none; border-bottom: 1px solid #edf2f7; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .form-group { display: flex; flex-direction: column; gap: 8px; }
        .form-group.full-width { grid-column: span 2; }
        
        .form-group label { font-size: 11px; font-weight: bold; color: #4a5568; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-group input, .form-group select { width: 100%; padding: 14px 18px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 15px; background: #fff; color: #2d3748; outline: none; transition: 0.2s; }
        .form-group input:focus, .form-group select:focus { border-color: #3182ce; box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1); }
        .form-group input[disabled] { background: #f7fafc; color: #a0aec0; cursor: not-allowed; }
        
        .btn-save { background: #48bb78; color: white; border: none; padding: 12px 30px; font-size: 16px; font-weight: bold; border-radius: 8px; cursor: pointer; transition: 0.2s; margin-top: 10px; display: inline-block; }
        .btn-save:hover { background: #38a169; transform: translateY(-1px); }

        .activity-list { display: flex; flex-direction: column; gap: 15px; }
        .activity-card { background: #f7fafc; border-left: 4px solid #ffcb05; border-radius: 0 8px 8px 0; padding: 20px; box-shadow: inset 0 0 4px rgba(0,0,0,0.01); }
        .activity-card h4 { font-size: 15px; color: #2d3748; margin-bottom: 4px; }
        .activity-card p { font-size: 12px; color: #718096; }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="container">
        <aside>
            <div class="card">
                <div class="avatar-lg">
                    <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/<?= htmlspecialchars($user['fav']) ?>.png" alt="Trainer Avatar">
                </div>
                <h3 class="trainer-name"><?= htmlspecialchars($user['username']) ?></h3>
                <span class="rank-badge">Gym Leader</span>
                
                <nav class="profile-nav">
                    <a href="profile.php?tab=activity" class="nav-item <?= $current_tab === 'activity' ? 'active' : '' ?>">
                        📜 Bulletin Activity
                    </a>
                    <a href="profile.php?tab=settings" class="nav-item <?= $current_tab === 'settings' ? 'active' : '' ?>">
                        ⚙️ Account Settings
                    </a>
                </nav>
            </div>
        </aside>

        <main class="content-panel">
            <?php if($current_tab === 'settings'): ?>
                <h2>Update Trainer Credentials</h2>
                <div class="divider"></div>
                
                <form action="update_profile.php" method="POST">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Trainer Name</label>
                            <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Favorite Partner Pokémon</label>
                            <select name="fav">
                                <option value="3" <?= $user['fav'] == 3 ? 'selected' : '' ?>>Venusaur 🌿</option>
                                <option value="6" <?= $user['fav'] == 6 ? 'selected' : '' ?>>Charizard 🔥</option>
                                <option value="9" <?= $user['fav'] == 9 ? 'selected' : '' ?>>Blastoise 💧</option>
                                <option value="25" <?= $user['fav'] == 25 ? 'selected' : '' ?>>Pikachu ⚡</option>
                            </select>
                        </div>
                        
                        <div class="form-group full-width">
                            <label>Email Address (Immutable)</label>
                            <input type="email" value="<?= htmlspecialchars($user['email']) ?>" disabled>
                        </div>
                        
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" name="password" placeholder="•••••">
                        </div>
                        
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm_password" placeholder="Confirm your new password">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-save">Save Changes</button>
                </form>

            <?php else: ?>
                <h2>Your Bulletin Board Activities</h2>
                <div class="divider"></div>
                
                <div class="activity-list">
                    <div class="activity-card">
                        <h4>Posted on Bulletin Board thread: "Scarlet & Violet Discussion"</h4>
                        <p>Category: <strong>Comment</strong> • Registered timestamp: 38 minutes ago</p>
                    </div>
                    <div class="activity-card">
                        <h4>Achieved Ranked Multiplier Milestone: "Gym Leader status obtained!"</h4>
                        <p>Category: <strong>System Achievement</strong> • Registered timestamp: 2 hours ago</p>
                    </div>
                    <div class="activity-card">
                        <h4>Completed interactive evaluation game module: "Who's That Pokémon Quiz"</h4>
                        <p>Category: <strong>Game Data Record</strong> • Registered timestamp: Yesterday @ 4:12 PM</p>
                    </div>
                </div>
            <?php endif; ?>
        </main>
    </div>

</body>
</html>