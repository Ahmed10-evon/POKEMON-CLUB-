<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Pokémon Club</title>
    <style>
        /* Base Styling */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }
        
        body { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; display: flex; flex-direction: column; }

        /* Main Content Wrapper */
        .main-container { max-width: 1100px; margin: 50px auto; padding: 0 20px; }

        /* Hero Section */
        .about-hero { background: white; border-radius: 24px; overflow: hidden; display: flex; box-shadow: 0 20px 40px rgba(0,0,0,0.1); margin-bottom: 50px; }
        .hero-text { flex: 1; padding: 60px; background: linear-gradient(to right, white, #fdfdfd); }
        .hero-text h1 { font-size: 3rem; color: #1a1a1a; margin-bottom: 20px; line-height: 1.1; }
        .hero-text p { font-size: 1.1rem; color: #555; line-height: 1.8; margin-bottom: 30px; }
        .hero-image { flex: 1; background: #2a75bb url('https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/25.png') center no-repeat; background-size: 70%; position: relative; }

        /* Mission Cards */
        .features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 60px; }
        .feature-item { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); padding: 30px; border-radius: 20px; border: 1px solid white; text-align: center; transition: 0.3s; }
        .feature-item:hover { transform: translateY(-10px); background: white; }
        .feature-item span { font-size: 40px; display: block; margin-bottom: 15px; }
        .feature-item h3 { margin-bottom: 10px; color: #2a75bb; }
        .feature-item p { font-size: 0.9rem; color: #777; line-height: 1.5; }

        /* Team Section */
        .team-title { text-align: center; margin-bottom: 40px; font-size: 2rem; color: #1a1a1a; }
        .team-grid { display: flex; justify-content: center; gap: 30px; flex-wrap: wrap; }
        .admin-card { background: white; width: 250px; border-radius: 20px; padding: 30px; text-align: center; box-shadow: 0 10px 20px rgba(0,0,0,0.05); border-bottom: 5px solid #2a75bb; }
        .admin-avatar { width: 100px; height: 100px; border-radius: 50%; background: #f0f4f8; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; font-size: 40px; }
        .admin-card h4 { font-size: 18px; margin-bottom: 5px; }
        .admin-card p { font-size: 14px; color: #888; margin-bottom: 15px; }
        .social-tag { background: #f0f4f8; padding: 5px 12px; border-radius: 20px; font-size: 12px; color: #2a75bb; font-weight: bold; }

        /* Footer Navigation */
        footer { text-align: center; padding: 40px; margin-top: auto; }
        .btn-home { background: #2a75bb; color: white; padding: 15px 30px; border-radius: 50px; text-decoration: none; font-weight: bold; box-shadow: 0 5px 15px rgba(42, 117, 187, 0.3); transition: 0.3s; }
        .btn-home:hover { background: #1e568d; transform: scale(1.05); }

        @media (max-width: 800px) {
            .about-hero { flex-direction: column; }
            .features-grid { grid-template-columns: 1fr; }
            .hero-image { height: 250px; }
        }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="main-container">
        <section class="about-hero">
            <div class="hero-text">
                <h1>More than just a game.</h1>
                <p>Founded in 2024, the Pokémon Club was built for trainers who believe that the journey never truly ends. We are a global collective of researchers, battlers, and collectors.</p>
                <p>Whether you're looking for a competitive edge or just a friendly place to trade, you've found your home base.</p>
            </div>
            <div class="hero-image"></div>
        </section>

        <div class="features-grid">
            <div class="feature-item">
                <span>🏆</span>
                <h3>Tournaments</h3>
                <p>Monthly VGC and TCG events with exclusive club rewards.</p>
            </div>
            <div class="feature-item">
                <span>🎨</span>
                <h3>Creative Hub</h3>
                <p>Showcase your fan art, custom sprites, and regional forms.</p>
            </div>
            <div class="feature-item">
                <span>📖</span>
                <h3>Lore Nights</h3>
                <p>Deep dives into the history of the Pokémon world and mysteries.</p>
            </div>
        </div>

        <h2 class="team-title">Our Leaders</h2>
        <div class="team-grid">
            <div class="admin-card">
                <div class="admin-avatar">🧢</div>
                <h4>Trainer Red</h4>
                <p>Head of Battling</p>
                <span class="social-tag">@the_champion</span>
            </div>
            <div class="admin-card">
                <div class="admin-avatar">🌿</div>
                <h4>Erika</h4>
                <p>Community Manager</p>
                <span class="social-tag">@celadon_nature</span>
            </div>
            <div class="admin-card">
                <div class="admin-avatar">🔬</div>
                <h4>Prof. Elm</h4>
                <p>Chief Researcher</p>
                <span class="social-tag">@egg_expert</span>
            </div>
        </div>
    </div>

    <footer>
        <a href="index.php" class="btn-home">Return to Home Base</a>
    </footer>

</body>
</html>