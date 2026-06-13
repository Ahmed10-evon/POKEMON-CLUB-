<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Club | Join the Community</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #e0f2e9; color: #333; }
        
        .hero { display: flex; justify-content: space-between; align-items: center; padding: 80px 10%; position: relative; }
        .hero-text { max-width: 50%; z-index: 2; }
        .hero-text h1 { font-size: 4.5rem; color: #6fc99c; line-height: 1.1; margin-bottom: 20px; text-transform: uppercase; font-weight: 900; }
        
        .email-signup { display: flex; margin-top: 40px; background: white; padding: 6px; border-radius: 30px; width: fit-content; box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        .email-signup input { border: none; padding: 12px 20px; border-radius: 30px; outline: none; width: 250px; font-size: 14px; }
        .email-signup button { background-color: #6fc99c; color: white; border: none; padding: 12px 30px; border-radius: 30px; cursor: pointer; font-weight: bold; font-size: 14px; transition: 0.2s; }
        .email-signup button:hover { background-color: #5ab588; }

        .mascot-area { font-size: 150px; user-select: none; animation: float 3s ease-in-out infinite; }
        @keyframes float { 0% { transform: translateY(0px); } 50% { transform: translateY(-20px); } 100% { transform: translateY(0px); } }

        .features { display: flex; gap: 20px; padding: 50px 10%; justify-content: space-between; }
        .card { background: white; padding: 40px 30px; border-radius: 20px; width: 31%; box-shadow: 0 10px 30px rgba(0,0,0,0.03); text-align: center; }
        .card h3 { color: #2a75bb; margin-bottom: 15px; font-size: 1.4rem; }
        .card p { color: #777; font-size: 15px; margin-bottom: 25px; line-height: 1.5; }
        .card a { color: #6fc99c; text-decoration: none; font-weight: bold; border-bottom: 2px solid transparent; padding-bottom: 2px; transition: 0.2s; }
        .card a:hover { border-bottom: 2px solid #6fc99c; }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <section class="hero">
        <div class="hero-text">
            <h1>Join The<br>Community</h1>
            <div class="email-signup">
                <input type="email" id="hero-email" placeholder="Your email address">
                <button onclick="window.location.href='signin.php'">Get Started</button>
            </div>
        </div>
        <div class="mascot-area">⚡</div> 
    </section>

    <section class="features">
        <div class="card">
            <h3>About The Club</h3>
            <p>Join trainers from around the world. Battle, trade, and discuss everything from the main series games to the TCG and anime.</p>
            <a href="about.php">Read Our Rules →</a>
        </div>
        <div class="card">
            <h3>Community Forum</h3>
            <p>Dive into active discussions, share your fan art, or find a team for your next big competitive tournament.</p>
            <a href="community.php">View Discussions →</a>
        </div>
        <div class="card">
            <h3>Official Pokédex</h3>
            <p>Look up stats, types, and abilities with our custom-built, fully searchable interactive Pokédex database.</p>
            <a href="pokedex.php">Search Pokédex →</a>
        </div>
    </section>

</body>
</html>