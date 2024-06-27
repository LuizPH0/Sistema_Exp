<?php
$serverName = "DESKTOP-A3R3KI8\SQLEXPRESS";
$connectionOptions = [
    "Database" => "ynsizeTeste",
    // "Uid" => "your_username",
    // "PWD" => "your_password"
];
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

function authenticateUser($username, $password) {
    global $conn;
    $sql = "SELECT * FROM Users WHERE username = ?";
    $params = [$username];
    $stmt = sqlsrv_query($conn, $sql, $params);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    $user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }
    return false;
}

function registerUser($username, $password, $nome, $dataNascimento, $endereco, $dataAdmissao) {
    global $conn;
    $sql = "INSERT INTO Users (username, password, nome, data_nascimento, endereco, data_admissao) VALUES (?, ?, ?, ?, ?, ?)";
    $params = [$username, password_hash($password, PASSWORD_BCRYPT), $nome, $dataNascimento, $endereco, $dataAdmissao];
    $stmt = sqlsrv_query($conn, $sql, $params);
    return $stmt !== false;
}

function recordAttendance($userId, $type, $description) {
    global $conn;
    $sql = "INSERT INTO Attendance (user_id, type, timestamp, description) VALUES (?, ?, GETDATE(), ?)";
    $params = [$userId, $type, $description];
    $stmt = sqlsrv_query($conn, $sql, $params);
    return $stmt !== false;
}

function getAttendance($userId) {
    global $conn;
    $sql = "SELECT * FROM Attendance WHERE user_id = ?";
    $params = [$userId];
    $stmt = sqlsrv_query($conn, $sql, $params);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    $attendance = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $attendance[] = $row;
    }
    return $attendance;
}
?>
