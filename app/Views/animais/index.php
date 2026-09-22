<?php require_once __DIR__ . '/../layouts/header.php'; ?>

    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2>Animais Cadastrados</h2>
        <!-- Botão para navegar até o formulário de cadastro -->
        <a href="/animais/criar" class="btn">+ Novo Animal</a>
    </div>

    <!-- LEITURA DA MENSAGEM DA SESSÃO: "Animal cadastrado com sucesso!" -->
<?php if (isset($_SESSION['feedback'])): ?>
    <?php
    $tipo = $_SESSION['feedback']['tipo'];
    $mensagem = $_SESSION['feedback']['mensagem'];
    unset($_SESSION['feedback']);
    ?>
    <div class="alerta-<?= $tipo ?>">
        <?= htmlspecialchars($mensagem) ?>
    </div>
<?php endif; ?>

    <!-- TABELA COM OS DADOS VINDO DO CONTROLLER -->
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Espécie</th>
            <th>Idade</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($animais)): ?>
            <?php foreach ($animais as $animal): ?>
                <tr>
                    <td><?= htmlspecialchars($animal['id']) ?></td>
                    <td><?= htmlspecialchars($animal['nome']) ?></td>
                    <td><?= htmlspecialchars($animal['especie']) ?></td>
                    <td><?= htmlspecialchars($animal['idade_anos']) ?> ano(s)</td>
                    <td><?= htmlspecialchars($animal['status']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Nenhum animal cadastrado no momento.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>