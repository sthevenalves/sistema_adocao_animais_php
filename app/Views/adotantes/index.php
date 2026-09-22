<?php require_once __DIR__ . '/../layouts/header.php'; ?>

    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2>Perfis de Adotantes</h2>
        <a href="/adotantes/criar" class="btn">+ Novo Adotante</a>
    </div>

    <!-- LEITURA DA MENSAGEM DA SESSÃO VIA COMPONENTE -->
    <?php require_once __DIR__ . '/../includes/feedback.php'; ?>

    <!-- TABELA COM OS DADOS VINDO DO CONTROLLER -->
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>CPF</th>
            <th>Telefone</th>
            <th>Moradia</th>
            <th>Outros Pets</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($adotantes)): ?>
            <?php foreach ($adotantes as $adotante): ?>
                <tr>
                    <td><?= htmlspecialchars($adotante['id']) ?></td>
                    <td><?= htmlspecialchars($adotante['usuario_nome']) ?></td>
                    <td><?= htmlspecialchars($adotante['usuario_email']) ?></td>
                    <td><?= htmlspecialchars($adotante['cpf']) ?></td>
                    <td><?= htmlspecialchars($adotante['telefone']) ?></td>
                    <td><?= htmlspecialchars($adotante['tipo_moradia']) ?></td>
                    <td><?= !empty($adotante['tem_outros_pets']) ? 'Sim' : 'Não' ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Nenhum adotante cadastrado no momento.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
