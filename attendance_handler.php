<?php
session_start();
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $description = $_POST['description'];
    $userId = $_SESSION['currentUser']['id'];

    if ($action === 'clockIn') {
        if (recordAttendance($userId, 'entrada', $description)) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error recording clock in.";
        }
    } elseif ($action === 'clockOut') {
        if (recordAttendance($userId, 'saida', $description)) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error recording clock out.";
        }
    }
}
?>
