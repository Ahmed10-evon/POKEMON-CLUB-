<?php
// signin.php
session_start();

// If already logged in, redirect away
if(isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$error = "";
$usersFile = 'users.json';

// Create the JSON database file if it doesn't exist yet
if (!file_exists($usersFile)) {
    file_put_contents($usersFile, json_encode([]));
}

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $users = json_decode(file_get_contents($usersFile), true);
    $action = $_POST['action'];
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($action === 'register') {
        $username = trim($_POST['username']);
        
        // Check if email already exists
        $exists = false;
        foreach($users as $u) {
            if($u['email'] === $email) { $exists = true; break; }
        }

        if ($exists) {
            $error = "This email is already registered.";
        } elseif (strlen($username) < 3) {
            $error = "Trainer Name must be at least 3 characters.";
        } else {
            // Hash the password securely and save
            $newUser = [
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'fav' => '25' // Default Pikachu
            ];
            $users[] = $newUser;
            file_put_contents($usersFile, json_encode($users));
            
            // Log them in immediately
            $_SESSION['user'] = $newUser;
            header("Location: index.php");
            exit();
        }
    } 
    elseif ($action === 'login') {
        $loggedIn = false;
        foreach($users as $u) {
            // Verify email and the hashed password
            if($u['email'] === $email && password_verify($password, $u['password'])) {
                $_SESSION['user'] = $u;
                $loggedIn = true;
                header("Location: index.php");
                exit();
            }
        }
        if (!$loggedIn) {
            $error = "Invalid email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign In | Pokémon Club</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background-color: #e0f2e9; display: flex; flex-direction: column; align-items: center; min-height: 100vh; }
        .auth-container { background: white; margin-top: 60px; padding: 40px; border-radius: 24px; box-shadow: 0 15px 35px rgba(0,0,0,0.05); width: 90%; max-width: 420px; text-align: center; }
        .form-group { margin-bottom: 20px; text-align: left; }
        label { display: block; font-size: 13px; font-weight: bold; margin-bottom: 6px; text-transform: uppercase; }
        input { width: 100%; padding: 12px; border: 2px solid #edf2f7; border-radius: 12px; outline: none; }
        .btn-submit { width: 100%; padding: 14px; background: #50b47b; color: white; border: none; border-radius: 12px; font-weight: bold; cursor: pointer; }
        .msg-error { color: #e53e3e; margin-top: 15px; font-weight: 600; }
        .toggle-form { margin-top: 20px; cursor: pointer; color: #2a75bb; font-weight: bold; }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="auth-container">
        <h2 id="auth-title">Welcome Back</h2>
        
        <form method="POST" action="signin.php">
            <input type="hidden" name="action" id="form-action" value="login">
            
            <div class="form-group" id="username-group" style="display: none;">
                <label>Trainer Name</label>
                <input type="text" name="username" id="username" placeholder="Choose a trainer name">
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            
            <button type="submit" class="btn-submit" id="submit-btn">Sign In</button>
        </form>

        <?php if($error): ?>
            <p class="msg-error"><?= $error ?></p>
        <?php endif; ?>

        <div class="toggle-form" onclick="toggleMode()">
            <span id="toggle-text">New here? Create an Account</span>
        </div>
    </div>

    <script>
        let isLogin = true;
        function toggleMode() {
            isLogin = !isLogin;
            document.getElementById('form-action').value = isLogin ? 'login' : 'register';
            document.getElementById('auth-title').textContent = isLogin ? 'Welcome Back' : 'Join the Club';
            document.getElementById('username-group').style.display = isLogin ? 'none' : 'block';
            document.getElementById('username').required = !isLogin;
            document.getElementById('submit-btn').textContent = isLogin ? 'Sign In' : 'Register';
            document.getElementById('toggle-text').textContent = isLogin ? 'New here? Create an Account' : 'Already a member? Sign In';
        }
    </script>
</body>
</html>