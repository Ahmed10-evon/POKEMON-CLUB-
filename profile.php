<?php
// profile.php
session_start();

// SECURITY CHECK: Kick them out if they aren't logged in
if(!isset($_SESSION['user'])) {
    header("Location: signin.php");
    exit();
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile | Pokémon Club</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background-color: #f0f4f8; color: #444; }
        .container { display: grid; grid-template-columns: 350px 1fr; gap: 30px; padding: 40px 5%; max-width: 1200px; margin: 0 auto; }
        .card { background: white; padding: 30px; border-radius: 16px; text-align: center; }
        .avatar-lg img { width: 100px; border-radius: 50%; border: 4px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .content-panel { background: white; border-radius: 12px; padding: 40px; }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <aside>
            <div class="card">
                <div class="avatar-lg">
                    <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/<?= htmlspecialchars($user['fav']) ?>.png">
                </div>
                <h3 style="margin-top: 15px;"><?= htmlspecialchars($user['username']) ?></h3>
                <span style="background: #ffcb05; padding: 5px 15px; border-radius: 20px; font-size: 12px; font-weight: bold;">Gym Leader</span>
                
                <p style="margin-top:20px; font-size: 13px; color: #777;">Email: <?= htmlspecialchars($user['email']) ?></p>
            </div>
        </aside>

        <main class="content-panel">
            <h2>Your Bulletin Board Activities</h2>
            <hr style="margin: 15px 0; border: 1px solid #eee;">
            <p style="color: #777;">Activity feed rendered securely via PHP...</p>
        </main>
    </div>
</body>
</html>