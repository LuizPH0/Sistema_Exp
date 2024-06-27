<?php
session_start();
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = authenticateUser($username, $password);
    if ($user) {
        $_SESSION['currentUser'] = $user;
        header("Location: index.php");
        exit();
    } else {
        echo "Invalid credentials";
    }
}
?>
