<?php require_once __DIR__ . '/../layouts/header.php'; ?>

    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2>Solicitações de Adoção</h2>
        <a href="/solicitacoes/criar" class="btn">+ Nova Solicitação</a>
    </div>

    <!-- LEITURA DA MENSAGEM DA SESSÃO VIA COMPONENTE -->
    <?php require_once __DIR__ . '/../includes/feedback.php'; ?>

    <!-- TABELA COM OS DADOS VINDO DO CONTROLLER -->
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Animal</th>
            <th>Adotante</th>
            <th>Data da Solicitação</th>
            <th>Status Atual</th>
            <th>Observações</th>
            <th>Alterar Status</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($solicitacoes)): ?>
            <?php foreach ($solicitacoes as $s): ?>
                <tr>
                    <td><?= htmlspecialchars($s['id']) ?></td>
                    <td><?= htmlspecialchars($s['animal_nome']) ?> (<?= htmlspecialchars($s['animal_especie']) ?>)</td>
                    <td><?= htmlspecialchars($s['adotante_nome']) ?> (CPF: <?= htmlspecialchars($s['adotante_cpf']) ?>)</td>
                    <td><?= date('d/m/Y H:i', strtotime($s['data_solicitacao'])) ?></td>
                    <td><strong><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $s['status']))) ?></strong></td>
                    <td><?= !empty($s['observacoes_admin']) ? htmlspecialchars($s['observacoes_admin']) : '-' ?></td>
                    <td>
                        <form action="/solicitacoes/status" method="POST" style="display: flex; gap: 5px; align-items: center;">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($s['id']) ?>">
                            <select name="status" style="padding: 4px; font-size: 13px;">
                                <option value="pendente" <?= $s['status'] === 'pendente' ? 'selected' : '' ?>>Pendente</option>
                                <option value="em_analise" <?= $s['status'] === 'em_analise' ? 'selected' : '' ?>>Em análise</option>
                                <option value="aprovado" <?= $s['status'] === 'aprovado' ? 'selected' : '' ?>>Aprovado</option>
                                <option value="rejeitado" <?= $s['status'] === 'rejeitado' ? 'selected' : '' ?>>Rejeitado</option>
                            </select>
                            <button type="submit" style="padding: 5px 8px; font-size: 12px; cursor: pointer;">Salvar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Nenhuma solicitação de adoção cadastrada no momento.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
