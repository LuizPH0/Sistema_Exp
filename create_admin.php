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

$adminUsername = 'adminYnsize';
$adminPassword = 'adminPassword123';
$hashedPassword = password_hash($adminPassword, PASSWORD_BCRYPT);
$nome = 'Admin';
$dataNascimento = '1990-01-01';
$endereco = '123 Admin St';
$dataAdmissao = '2020-01-01';

// Verificar se o usuário admin já existe
$sqlCheck = "SELECT * FROM Users WHERE username = ?";
$paramsCheck = [$adminUsername];
$stmtCheck = sqlsrv_query($conn, $sqlCheck, $paramsCheck);

if ($stmtCheck === false) {
    die(print_r(sqlsrv_errors(), true));
}

if (sqlsrv_fetch_array($stmtCheck, SQLSRV_FETCH_ASSOC)) {
    echo "Admin user already exists.";
} else {
    $sql = "INSERT INTO Users (username, password, nome, data_nascimento, endereco, data_admissao) VALUES (?, ?, ?, ?, ?, ?)";
    $params = [$adminUsername, $hashedPassword, $nome, $dataNascimento, $endereco, $dataAdmissao];

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "Admin user created successfully.";
    }
}

sqlsrv_close($conn);
?>
