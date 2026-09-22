<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['feedback'])):
    $tipo = $_SESSION['feedback']['tipo'] ?? 'erro';
    $mensagem = $_SESSION['feedback']['mensagem'] ?? '';
    unset($_SESSION['feedback']);
?>
    <div class="alerta-<?= htmlspecialchars($tipo) ?>">
        <?= htmlspecialchars($mensagem) ?>
    </div>
<?php endif; ?>
