<?php require_once __DIR__ . '/../layouts/header.php'; ?>

    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2>Animais Cadastrados</h2>
        <!-- Botão para navegar até o formulário de cadastro -->
        <a href="/animais/criar" class="btn">+ Novo Animal</a>
    </div>

    <!-- LEITURA DA MENSAGEM DA SESSÃO VIA COMPONENTE -->
    <?php require_once __DIR__ . '/../includes/feedback.php'; ?>

    <!-- TABELA COM OS DADOS VINDO DO CONTROLLER -->
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Espécie</th>
            <th>Idade</th>
            <th>Porte</th>
            <th>Vacinado</th>
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
                    <td><?= htmlspecialchars($animal['porte']) ?></td>
                    <td><?= !empty($animal['vacinado']) ? 'Sim' : 'Não' ?></td>
                    <td><?= htmlspecialchars($animal['status']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Nenhum animal cadastrado no momento.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>