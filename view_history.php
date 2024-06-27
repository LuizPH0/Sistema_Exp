<?php
session_start();
require 'functions.php';

$userId = $_SESSION['currentUser']['id'];
$attendance = getAttendance($userId);

echo json_encode($attendance);
?>
