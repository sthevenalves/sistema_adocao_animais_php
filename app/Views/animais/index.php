<!-- Lista de animais cadastrados -->

<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div style="display: flex; justify-content: space-between; align-items: center;">
    <h2>Animais Cadastrados</h2>

    <!-- Botão para cadastrar um novo animal -->
    <a href="/animais/criar" class="btn">+ Novo Animal</a>
</div>

<!-- Exibe mensagens de sucesso ou erro -->
<?php require_once __DIR__ . '/../includes/feedback.php'; ?>

<!-- Tabela com os animais -->
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
            <th>Ações</th>
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

                    <td>
                        <?= !empty($animal['vacinado']) ? 'Sim' : 'Não' ?>
                    </td>

                    <td><?= htmlspecialchars($animal['status']) ?></td>

                    <!-- Botões de edição e exclusão -->
                    <td>
                        <a
                            href="/animais/editar?id=<?= $animal['id'] ?>"
                            class="btn"
                        >
                            Editar
                        </a>

                        <form
                            action="/animais/apagar"
                            method="POST"
                            style="display: inline;"
                            onsubmit="return confirm('Tem certeza que deseja excluir este animal?');"
                        >
                            <input
                                type="hidden"
                                name="id"
                                value="<?= $animal['id'] ?>"
                            >

                            <button type="submit">
                                Excluir
                            </button>
                        </form>
                    </td>
                </tr>

            <?php endforeach; ?>

        <?php else: ?>

            <tr>
                <td colspan="8">
                    Nenhum animal cadastrado no momento.
                </td>
            </tr>

        <?php endif; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>