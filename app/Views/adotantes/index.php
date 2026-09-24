<!-- Lista de perfis de adotantes -->

<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div style="display: flex; justify-content: space-between; align-items: center;">
    <h2>Perfis de Adotantes</h2>

    <!-- Botão para cadastrar um novo adotante -->
    <a href="/adotantes/criar" class="btn">
        + Novo Adotante
    </a>
</div>

<!-- Exibe mensagens de sucesso ou erro -->
<?php require_once __DIR__ . '/../includes/feedback.php'; ?>

<!-- Tabela com os adotantes -->
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
            <th>Ações</th>
        </tr>
    </thead>

    <tbody>

        <?php if (!empty($adotantes)): ?>

            <?php foreach ($adotantes as $adotante): ?>

                <tr>
                    <td><?= htmlspecialchars($adotante['id']) ?></td>

                    <td>
                        <?= htmlspecialchars($adotante['usuario_nome']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($adotante['usuario_email']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($adotante['cpf']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($adotante['telefone']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($adotante['tipo_moradia']) ?>
                    </td>

                    <td>
                        <?= !empty($adotante['tem_outros_pets']) ? 'Sim' : 'Não' ?>
                    </td>

                    <!-- Botões de edição e exclusão -->
                    <td>

                        <a
                            href="/adotantes/editar?id=<?= $adotante['id'] ?>"
                            class="btn"
                        >
                            Editar
                        </a>

                        <form
                            action="/adotantes/apagar"
                            method="POST"
                            style="display: inline;"
                            onsubmit="return confirm('Tem certeza que deseja excluir este adotante?');"
                        >
                            <input
                                type="hidden"
                                name="id"
                                value="<?= $adotante['id'] ?>"
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
                    Nenhum adotante cadastrado no momento.
                </td>
            </tr>

        <?php endif; ?>

    </tbody>
</table>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>