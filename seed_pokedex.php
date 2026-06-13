<?php
require 'db.php'; 

for ($i = 1; $i <= 500; $i++) {
    $url = "https://pokeapi.co/api/v2/pokemon/$i";
    $json = file_get_contents($url);
    $data = json_decode($json, true);

    $id = $data['id'];
    $name = $data['name'];
    $hp = $data['stats'][0]['base_stat'];
    $attack = $data['stats'][1]['base_stat'];
    $sprite = $data['sprites']['other']['official-artwork']['front_default'];
    $type1 = $data['types'][0]['type']['name'];
    $type2 = isset($data['types'][1]) ? $data['types'][1]['type']['name'] : null;

    $stmt = $pdo->prepare("REPLACE INTO pokedex (id, name, type1, type2, hp, attack, sprite_url) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$id, $name, $type1, $type2, $hp, $attack, $sprite]);
    
    echo "Added " . ucfirst($name) . "<br>";
}

echo "<h3>All done! Database populated successfully!</h3>";
?>