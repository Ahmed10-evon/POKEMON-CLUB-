<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: signin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = $_POST['username'];
    $new_fav = $_POST['fav'];
    $user_id = $_SESSION['user']['id'];
    
    $stmt = $pdo->prepare("UPDATE users SET username = ?, fav = ? WHERE id = ?");
    $stmt->execute([$new_username, $new_fav, $user_id]);
    
    $_SESSION['user']['username'] = $new_username;
    $_SESSION['user']['fav'] = $new_fav;
    
    header("Location: profile.php?tab=settings&success=1");
    exit();
}
?>