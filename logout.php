<?php
session_start();

// Verifica se a sessão está ativa
if (session_status() === PHP_SESSION_ACTIVE) {
    // Limpa todas as variáveis de sessão
    $_SESSION = array();

    // Destrói a sessão
    session_destroy();
}

// Redireciona para a página de login
header("Location: index.php");
exit;