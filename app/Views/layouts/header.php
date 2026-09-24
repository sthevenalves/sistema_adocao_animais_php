<?php
// Garantimos que a sessão já está ativa para conseguir ler as mensagens, senão inicia a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema ONG - Adoção</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<header>
    <h1>Sistema ONG</h1>
    <nav class="nav-menu">
        <a href="/animais" class="btn-nav">Animais</a>
        <?php if (!empty($_SESSION['usuario'])): ?>
            <a href="/adotantes" class="btn-nav">Adotantes</a>
            <a href="/solicitacoes" class="btn-nav">Solicitações</a>
            <a href="/logout" class="btn-nav btn-sair">Sair (<?= htmlspecialchars($_SESSION['usuario']['nome'] ?? '') ?>)</a>
        <?php else: ?>
            <a href="/login" class="btn-nav">Entrar</a>
        <?php endif; ?>
    </nav>
</header>
<main>