<?php
require_once __DIR__ . '/../layouts/header.php';
?>

<h2>Entrar no Sistema</h2>

<?php require_once __DIR__ . '/../includes/feedback.php'; ?>

<form action="/login" method="POST" style="max-width: 400px;">

    <div class="campo">
        <label for="email">E-mail:</label>
        <input
            type="email"
            id="email"
            name="email"
            placeholder="seu@email.com"
            required
            autofocus
            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
        >
    </div>

    <div class="campo">
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
    </div>

    <button type="submit">Entrar</button>
</form>

<p style="margin-top: 15px; font-size: 13px; color: #666;">
    Usuários de teste (senha em texto puro, só para conferir o login):<br>
    <strong>admin@ong.com</strong> / admin123<br>
    <strong>joao@email.com</strong> / user123
</p>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
