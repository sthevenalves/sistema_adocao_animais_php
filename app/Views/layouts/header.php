<?php
// Garantimos que a sessão já está ativa para conseguir ler as mensagens, senão inicia a sessão
if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema ONG - Adoção</title>
    <!-- O navegador busca o CSS da pasta public/css/style.css -->
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<header>
    <h1>Sistema ONG</h1>
</header>
<main>