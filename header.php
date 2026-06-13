<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<style>

    header { display: flex; justify-content: space-between; align-items: center; padding: 20px 5%; background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
    .logo { font-size: 24px; font-weight: 900; color: #fccf00; text-shadow: 1px 1px 0 #2a75bb; text-decoration: none; }
    nav ul { list-style: none; display: flex; gap: 25px; margin: 0; padding: 0; }
    nav a { text-decoration: none; color: #2e604a; font-weight: 800; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; }
    nav a:hover { color: #50b47b; }
    .btn-signin { background-color: #50b47b; color: white; padding: 10px 25px; border-radius: 25px; text-decoration: none; font-weight: bold; transition: 0.3s; }
    .btn-logout { background-color: #e53e3e; }
    .auth-controls { display: flex; align-items: center; gap: 15px; }
</style>

<header>
    <a href="index.php" class="logo">⚡ Pokémon Club</a>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="community.php">Forum</a></li>
            <li><a href="pokedex.php">Pokédex</a></li>
            <li><a href="quiz.php">Quiz Game</a></li>
        </ul>
    </nav>
    <div class="auth-controls">
        <?php if(isset($_SESSION['user'])): ?>
            <span style="font-weight: bold; color: #2a75bb;">
                <?= htmlspecialchars($_SESSION['user']['username']) ?>
            </span>
            <a href="logout.php" class="btn-signin btn-logout">Logout</a>
        <?php else: ?>
            <a href="signin.php" class="btn-signin">Sign In</a>
        <?php endif; ?>
    </div>
</header>