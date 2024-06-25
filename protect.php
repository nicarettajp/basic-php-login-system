<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION["id"])) {
    // Redireciona para a página de login com uma mensagem de erro
    $_SESSION['mensagem_erro'] = "Você precisa estar logado para acessar esta página.";
    header("Location: index.php");
    exit;
}