<?php
session_start();
require 'db.php';


$stmt = $pdo->query("SELECT * FROM pokedex ORDER BY id ASC");
$pokemon_list = $stmt->fetchAll(PDO::FETCH_ASSOC);


$typeIcons = [
    'fire' => '🔥', 'ghost' => '👻', 'ground' => '⛰️', 
    'rock' => '🪨', 'water' => '💧', 'grass' => '🌿', 
    'dark' => '🌑', 'electric' => '⚡', 'normal' => '⚪'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokédex | Pokémon Club</title>
    <style>
    
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f6f8fc; color: #333; }
        .tools-bar { display: flex; justify-content: space-between; align-items: center; padding: 15px 5%; background: white; border-bottom: 1px solid #eee; }
        .search-container { position: relative; width: 350px; }
        .search-container input { width: 100%; padding: 12px 20px; background-color: #f0f2f5; border: none; border-radius: 25px; font-size: 14px; outline: none; transition: 0.3s; }
        .type-filters { display: flex; gap: 20px; overflow-x: auto; scrollbar-width: none; }
        .type-filters a { text-decoration: none; color: #888; font-size: 14px; font-weight: 600; padding-bottom: 5px; cursor: pointer; }
        .type-filters a.active { color: #333; border-bottom: 2px solid #333; }
        main { padding: 40px 5%; max-width: 1400px; margin: 0 auto; }
        .pokedex-banner { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 16px; padding: 40px 50px; color: white; display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; position: relative; overflow: hidden; }
        .pokemon-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 25px; }
        .card { background: white; border-radius: 16px; padding: 20px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.03); transition: transform 0.2s; }
        .card img { width: 120px; height: 120px; object-fit: contain; margin-bottom: 15px; }
        .type-badges { display: flex; justify-content: center; gap: 5px; margin-bottom: 15px; }
        .badge { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px; }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="tools-bar">
        <nav class="type-filters">
            <a href="#" class="active" onclick="filterType('all', this)">All</a>
            <a href="#" onclick="filterType('electric', this)">Electric</a>
            <a href="#" onclick="filterType('fire', this)">Fire</a>
            <a href="#" onclick="filterType('grass', this)">Grass</a>
            <a href="#" onclick="filterType('water', this)">Water</a>
        </nav>
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Search by name or number...">
        </div>
    </div>

    <main>
        <section class="pokedex-banner">
            <div class="banner-text">
                <h1>Your Official Pokédex!</h1>
                <p>Data loaded dynamically from your MySQL Database.</p>
            </div>
        </section>

        <section class="pokemon-grid">
            <?php foreach ($pokemon_list as $poke): ?>
                <div class="card" data-type1="<?= $poke['type1'] ?>" data-type2="<?= $poke['type2'] ?>">
                    <div class="type-badges">
                        <?php if($poke['type1']): ?>
                            <div class="badge" style="background:#555"><?= $typeIcons[$poke['type1']] ?? '❓' ?></div>
                        <?php endif; ?>
                    </div>
                    <img src="<?= htmlspecialchars($poke['sprite_url']) ?>" alt="<?= $poke['name'] ?>">
                    <h3><?= ucfirst($poke['name']) ?></h3>
                    <span class="id">#<?= str_pad($poke['id'], 3, '0', STR_PAD_LEFT) ?></span>
                </div>
            <?php endforeach; ?>
        </section>
    </main>

<script>

    document.getElementById('searchInput').addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase();
        document.querySelectorAll('.card').forEach(card => {
            const name = card.querySelector('h3').textContent.toLowerCase();
            const id = card.querySelector('.id').textContent.toLowerCase();
            card.style.display = (name.includes(query) || id.includes(query)) ? 'block' : 'none';
        });
    });

    function filterType(type, element) {
    
        document.querySelectorAll('.type-filters a').forEach(a => a.classList.remove('active'));
        element.classList.add('active');

        document.querySelectorAll('.card').forEach(card => {
            const t1 = card.getAttribute('data-type1');
            const t2 = card.getAttribute('data-type2');
            
            if (type === 'all' || t1 === type || t2 === type) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>
</body>
</html>