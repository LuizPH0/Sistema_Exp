<?php
session_start();
require 'functions.php';

function isLoggedIn() {
    return isset($_SESSION['currentUser']);
}

function isAdmin() {
    return $_SESSION['currentUser']['username'] === 'adminYnsize';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: index.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ponto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="app">
        <h1>Sistema de Expediente</h1>
        <?php if (!isLoggedIn()): ?>
            <!-- Formulário de login -->
            <div id="login-form">
                <h2>Login</h2>
                <form method="POST" action="login_handler.php">
                    <input type="text" name="username" placeholder="Insira o Username" required>
                    <input type="password" name="password" placeholder="Insira a senha" required>
                    <button type="submit">Login</button>
                </form>
            </div>
        <?php else: ?>
            <!-- Se o usuário estiver logado, exiba os formulários relevantes -->
            <?php if (isAdmin()): ?>
                <!-- Formulário de cadastro (visível apenas para admin) -->
                <div id="admin-form">
                    <h2>Register User</h2>
                    <form method="POST" action="register_handler.php">
                        <input type="text" name="username" placeholder="Username" required>
                        <input type="password" name="password" placeholder="Senha" required>
                        <input type="text" name="nome" placeholder="Nome" required>
                        <input type="date" name="data_nascimento" placeholder="Data de Aniversário" required>
                        <input type="text" name="endereco" placeholder="Endereço" required>
                        <input type="date" name="data_admissao" placeholder="Data de Admissão" required>
                        <button type="submit">Registrar</button>
                    </form>
                </div>
            <?php endif; ?>

            <!-- Formulário de registro de entrada/saída -->
            <div id="attendance-form">
                <h2>Bem-vindo, <span id="user-name"><?= $_SESSION['currentUser']['username'] ?></span></h2>
                <form method="POST" action="attendance_handler.php">
                    <input type="text" name="description" placeholder="Insira a descrição de trabalho">
                    <button type="submit" name="action" value="clockIn">Entrada</button>
                    <button type="submit" name="action" value="clockOut">Saída</button>
                </form>
                <button onclick="viewHistory()">Histórico</button>
                <form method="POST">
                    <button type="submit" name="logout">Logout</button>
                </form>
            </div>
            <!-- Histórico de presença -->
            <div id="history" style="display: none;">
                <h2>History</h2>
                <ul id="history-list"></ul>
                <button onclick="hideHistory()">Esconder Histórico</button>
            </div>
        <?php endif; ?>
    </div>
    <script src="scripts.js"></script>
</body>
</html>
