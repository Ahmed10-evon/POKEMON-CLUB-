<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokédex | Pokémon Club</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f6f8fc; color: #333; }
        
        :root {
            --fire: #fd7d24; --ghost: #7b62a3; --ground: #ab9842;
            --rock: #a38c21; --water: #4592c4; --grass: #9bcc50;
            --dark: #707070; --electric: #eed535;
        }

        /* Search & Filter Bar (Moved below the PHP header) */
        .tools-bar { display: flex; justify-content: space-between; align-items: center; padding: 15px 5%; background: white; border-bottom: 1px solid #eee; }
        .search-container { position: relative; width: 350px; }
        .search-container input { width: 100%; padding: 12px 20px; background-color: #f0f2f5; border: none; border-radius: 25px; font-size: 14px; outline: none; transition: 0.3s; }
        .search-container input:focus { box-shadow: 0 0 0 2px #50b47b; background-color: white; }

        .type-filters { display: flex; gap: 20px; overflow-x: auto; scrollbar-width: none; }
        .type-filters::-webkit-scrollbar { display: none; }
        .type-filters a { text-decoration: none; color: #888; font-size: 14px; font-weight: 600; padding-bottom: 5px; }
        .type-filters a.active { color: #333; border-bottom: 2px solid #333; }

        /* Main Content */
        main { padding: 40px 5%; max-width: 1400px; margin: 0 auto; }
        .pokedex-banner { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 16px; padding: 40px 50px; color: white; display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; position: relative; overflow: hidden; }
        .banner-text h1 { font-size: 2rem; margin-bottom: 10px; }
        .banner-text p { font-size: 1.1rem; opacity: 0.9; max-width: 400px; line-height: 1.4; }
        .banner-image { height: 120px; position: absolute; right: 50px; bottom: -10px; }

        /* Grid & Cards */
        .pokemon-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 25px; }
        .card { background: white; border-radius: 16px; padding: 20px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.03); transition: transform 0.2s; cursor: pointer; }
        .card:hover { transform: translateY(-5px); }
        .type-badges { display: flex; justify-content: space-between; margin-bottom: 15px; }
        .badge { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px; }
        .card img { width: 120px; height: 120px; object-fit: contain; margin-bottom: 15px; }
        .card h3 { font-size: 1.1rem; color: #2c3e50; margin-bottom: 5px; }
        .card span.id { font-size: 0.85rem; color: #95a5a6; font-weight: 600; }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="tools-bar">
        <nav class="type-filters">
            <a href="#" class="active">All</a>
            <a href="#">Electric</a>
            <a href="#">Fire</a>
            <a href="#">Grass</a>
            <a href="#">Water</a>
            <a href="#">Ghost</a>
            <a href="#">Ground</a>
            <a href="#">Rock</a>
        </nav>
        <div class="search-container">
            <input type="text" placeholder="Search by name or number...">
        </div>
    </div>

    <main>
        <section class="pokedex-banner">
            <div class="banner-text">
                <h1>Your Official Pokédex!</h1>
                <p>Discover stats, types, and build your dream team.</p>
            </div>
            <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/59.png" alt="Arcanine" class="banner-image">
        </section>

        <section class="pokemon-grid">
            <div class="card"><div class="type-badges"><div class="badge" style="background:#9bcc50">🌿</div></div><img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/1.png"><h3>Bulbasaur</h3><span class="id">#001</span></div>
            <div class="card"><div class="type-badges"><div class="badge" style="background:#fd7d24">🔥</div></div><img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/4.png"><h3>Charmander</h3><span class="id">#004</span></div>
            <div class="card"><div class="type-badges"><div class="badge" style="background:#4592c4">💧</div></div><img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/7.png"><h3>Squirtle</h3><span class="id">#007</span></div>
            <div class="card"><div class="type-badges"><div class="badge" style="background:#eed535">⚡</div></div><img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/25.png"><h3>Pikachu</h3><span class="id">#025</span></div>
            </section>
    </main>

<script>
    // Search Filter Logic
    const searchInput = document.querySelector('.search-container input');
    const pokemonCards = document.querySelectorAll('.card');

    searchInput.addEventListener('input', () => {
        const query = searchInput.value.toLowerCase();
        pokemonCards.forEach(card => {
            const name = card.querySelector('h3').textContent.toLowerCase();
            const id = card.querySelector('.id').textContent.toLowerCase();
            card.style.display = (name.includes(query) || id.includes(query)) ? 'block' : 'none';
        });
    });

    // Type Filter Logic System 
    const typeFilters = document.querySelectorAll('.type-filters a');
    typeFilters.forEach(filter => {
        filter.addEventListener('click', (e) => {
            e.preventDefault();
            typeFilters.forEach(f => f.classList.remove('active'));
            filter.classList.add('active');

            const selectedType = filter.textContent.toLowerCase();
            pokemonCards.forEach(card => {
                const badges = card.querySelectorAll('.badge');
                let hasType = false;
                badges.forEach(badge => {
                    if (selectedType === 'all' || getIconByType(selectedType) === badge.textContent) {
                        hasType = true;
                    }
                });
                card.style.display = hasType ? 'block' : 'none';
            });
        });
    });

    function getIconByType(type) {
        const icons = { 'fire': '🔥', 'ghost': '👻', 'ground': '⛰️', 'rock': '🪨', 'electric': '⚡', 'grass': '🌿', 'water': '💧' };
        return icons[type] || '';
    }
</script>
</body>
</html>