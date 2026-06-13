<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Who's That Pokémon? | Quiz</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background-color: #e0f2e9; display: flex; flex-direction: column; align-items: center; min-height: 100vh; }

        /* Quiz Container */
        .quiz-container { background: white; margin-top: 50px; padding: 40px; border-radius: 30px; box-shadow: 0 20px 40px rgba(0,0,0,0.05); text-align: center; width: 90%; max-width: 500px; position: relative; }
        
        .score-board { position: absolute; top: 25px; right: 30px; font-weight: bold; color: #2a75bb; font-size: 18px; background: #f0f4f8; padding: 5px 15px; border-radius: 20px; }

        .pokemon-display { position: relative; width: 250px; height: 250px; margin: 20px auto 30px; background: radial-gradient(#6fc99c 10%, transparent 70%); display: flex; align-items: center; justify-content: center; border-radius: 50%; }
        
        #pokemon-image { width: 220px; transition: filter 0.5s ease, transform 0.3s; filter: brightness(0); pointer-events: none; }
        #pokemon-image.revealed { filter: brightness(1); transform: scale(1.1); }

        h2 { margin-bottom: 5px; color: #2e604a; text-transform: uppercase; letter-spacing: 2px; }
        input { width: 100%; padding: 15px; border-radius: 15px; border: 2px solid #eee; outline: none; font-size: 18px; text-align: center; margin-bottom: 20px; }
        input:focus { border-color: #50b47b; }

        .btn-group { display: flex; gap: 10px; }
        button { flex: 1; padding: 15px; border: none; border-radius: 15px; font-weight: bold; cursor: pointer; font-size: 16px; transition: 0.2s; }
        .btn-guess { background: #50b47b; color: white; }
        .btn-guess:hover { background: #3e9a64; }
        .btn-skip { background: #cbd5e0; color: #4a5568; }
        .btn-skip:hover { background: #a0aec0; color: white; }
        
        #message { margin-top: 20px; font-weight: 600; height: 24px; }
        .correct { color: #38a169; }
        .wrong { color: #e53e3e; }
    </style>
</head>
<body style="width: 100%;">

    <?php include 'header.php'; ?>

    <div style="display: flex; justify-content: center; width: 100%;">
        <div class="quiz-container">
            <div class="score-board">Score: <span id="score">0</span></div>
            <h2>Who's That Pokémon?</h2>
            
            <div class="pokemon-display">
                <img src="" id="pokemon-image" alt="Guess the Pokemon">
            </div>

            <input type="text" id="guess-input" placeholder="Type name here..." autocomplete="off">
            
            <div class="btn-group">
                <button class="btn-skip" onclick="skipPokemon()">Skip</button>
                <button class="btn-guess" onclick="checkGuess()">Guess!</button>
            </div>

            <p id="message"></p>
        </div>
    </div>

    <script>
        let currentPokemonName = "";
        let score = 0;
        const imgElement = document.getElementById('pokemon-image');
        const inputElement = document.getElementById('guess-input');
        const messageElement = document.getElementById('message');
        const scoreElement = document.getElementById('score');

        async function fetchNewPokemon() {
            imgElement.classList.remove('revealed');
            imgElement.style.opacity = '0';
            messageElement.textContent = "Loading...";
            inputElement.value = "";
            inputElement.disabled = false;
            
            const randomId = Math.floor(Math.random() * 151) + 1;
            
            try {
                const response = await fetch(`https://pokeapi.co/api/v2/pokemon/${randomId}`);
                const data = await response.json();
                currentPokemonName = data.name;
                imgElement.src = data.sprites.other['official-artwork'].front_default;
                imgElement.onload = () => { imgElement.style.opacity = '1'; messageElement.textContent = ""; };
            } catch (error) { 
                messageElement.textContent = "Error loading Pokémon!"; 
            }
        }

        function checkGuess() {
            const userGuess = inputElement.value.toLowerCase().trim();
            if (userGuess === currentPokemonName) {
                imgElement.classList.add('revealed');
                messageElement.textContent = `Correct! It's ${currentPokemonName.toUpperCase()}!`;
                messageElement.className = "correct";
                score++;
                scoreElement.textContent = score;
                inputElement.disabled = true;
                setTimeout(fetchNewPokemon, 2000);
            } else {
                messageElement.textContent = "Try again!";
                messageElement.className = "wrong";
            }
        }

        function skipPokemon() {
            imgElement.classList.add('revealed');
            messageElement.textContent = `It was ${currentPokemonName.toUpperCase()}!`;
            messageElement.className = "";
            inputElement.disabled = true;
            setTimeout(fetchNewPokemon, 2000);
        }

        inputElement.addEventListener('keypress', (e) => { 
            if (e.key === 'Enter') checkGuess(); 
        });
        
        // Start Game
        fetchNewPokemon();
    </script>
</body>
</html>