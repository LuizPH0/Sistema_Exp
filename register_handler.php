<?php
session_start();
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_SESSION['currentUser']['username'] !== 'adminYnsize') {
        echo "Access denied.";
        exit();
    }

    $username = $_POST['username'];
    $password = $_POST['password'];
    $nome = $_POST['nome'];
    $dataNascimento = $_POST['data_nascimento'];
    $endereco = $_POST['endereco'];
    $dataAdmissao = $_POST['data_admissao'];

    if (registerUser($username, $password, $nome, $dataNascimento, $endereco, $dataAdmissao)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error registering user.";
    }
}
?>
