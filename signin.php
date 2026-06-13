<?php
session_start();
require 'db.php'; 

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    
    if ($_POST['action'] === 'register') {
        $user = $_POST['username'];
        $email = $_POST['email'];
        $pass = $_POST['password'];
        
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        
        try {
            $stmt->execute([$user, $email, $hashed_password]);
            $success = "Trainer registered successfully! You can now sign in.";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $error = "That email is already registered.";
            } else {
                $error = "Registration Error: " . $e->getMessage();
            }
        }
    }

    if ($_POST['action'] === 'login') {
        $email = $_POST['email'];
        $pass = $_POST['password'];
        
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($pass, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'fav' => $user['fav'],
                'rank' => $user['rank']
            ];
            
            header("Location: community.php");
            exit();
        } else {
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
        .msg-error { color: #e53e3e; margin-top: 15px; font-weight: 600; font-size: 14px; }
        .msg-success { color: #38a169; margin-top: 15px; font-weight: 600; font-size: 14px; }
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

        <?php if(!empty($error)): ?>
            <p class="msg-error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        
        <?php if(!empty($success)): ?>
            <p class="msg-success"><?= htmlspecialchars($success) ?></p>
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