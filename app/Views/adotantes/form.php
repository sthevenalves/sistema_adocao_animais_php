<!-- Formulário de cadastro e edição de adotantes -->

<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<?php
$editando = isset($adotante) && $adotante !== null;
?>

<h2><?= $editando ? 'Editar Perfil de Adotante' : 'Cadastrar Perfil de Adotante' ?></h2>

<!-- Exibe mensagens de sucesso ou erro -->
<?php require_once __DIR__ . '/../includes/feedback.php'; ?>

<!-- Formulário -->
<form
    action="<?= $editando ? '/adotantes/atualizar' : '/adotantes/salvar' ?>"
    method="POST"
>

    <!-- ID do adotante: usado somente durante a edição -->
    <?php if ($editando): ?>
        <input
            type="hidden"
            name="id"
            value="<?= htmlspecialchars($adotante['id']) ?>"
        >
    <?php endif; ?>

    <!-- Usuário associado -->
    <div class="campo">
        <label for="usuario_id">Usuário Associado:</label>

        <select
            id="usuario_id"
            name="usuario_id"
            style="width: 100%; padding: 8px; box-sizing: border-box;"
            required
        >
            <option value="">Selecione o usuário</option>

            <?php if (!empty($usuarios)): ?>

                <?php foreach ($usuarios as $usuario): ?>

                    <option
                        value="<?= htmlspecialchars($usuario['id']) ?>"
                        <?= ($adotante['usuario_id'] ?? '') == $usuario['id'] ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($usuario['nome']) ?>
                        (<?= htmlspecialchars($usuario['email']) ?>)
                    </option>

                <?php endforeach; ?>

            <?php endif; ?>
        </select>
    </div>

    <!-- CPF -->
    <div class="campo">
        <label for="cpf">CPF:</label>

        <input
            type="text"
            id="cpf"
            name="cpf"
            placeholder="000.000.000-00"
            maxlength="14"
            value="<?= htmlspecialchars($adotante['cpf'] ?? '') ?>"
            required
        >
    </div>

    <!-- Telefone -->
    <div class="campo">
        <label for="telefone">Telefone:</label>

        <input
            type="text"
            id="telefone"
            name="telefone"
            placeholder="(00) 00000-0000"
            maxlength="20"
            value="<?= htmlspecialchars($adotante['telefone'] ?? '') ?>"
            required
        >
    </div>

    <!-- Tipo de moradia -->
    <div class="campo">
        <label for="tipo_moradia">Tipo de Moradia:</label>

        <select
            id="tipo_moradia"
            name="tipo_moradia"
            style="width: 100%; padding: 8px; box-sizing: border-box;"
            required
        >
            <option value="">Selecione o tipo de moradia</option>

            <option
                value="Casa"
                <?= ($adotante['tipo_moradia'] ?? '') === 'Casa' ? 'selected' : '' ?>
            >
                Casa
            </option>

            <option
                value="Apartamento"
                <?= ($adotante['tipo_moradia'] ?? '') === 'Apartamento' ? 'selected' : '' ?>
            >
                Apartamento
            </option>

            <option
                value="Chácara"
                <?= ($adotante['tipo_moradia'] ?? '') === 'Chácara' ? 'selected' : '' ?>
            >
                Chácara
            </option>
        </select>
    </div>

    <!-- Outros pets -->
    <div class="campo">
        <label for="tem_outros_pets">Possui outros pets?</label>

        <select
            id="tem_outros_pets"
            name="tem_outros_pets"
            style="width: 100%; padding: 8px; box-sizing: border-box;"
        >
            <option
                value="0"
                <?= ($adotante['tem_outros_pets'] ?? 0) == 0 ? 'selected' : '' ?>
            >
                Não
            </option>

            <option
                value="1"
                <?= ($adotante['tem_outros_pets'] ?? 0) == 1 ? 'selected' : '' ?>
            >
                Sim
            </option>
        </select>
    </div>

    <!-- Botões -->
    <button type="submit">
        <?= $editando ? 'Atualizar Adotante' : 'Salvar Adotante' ?>
    </button>

    <a href="/adotantes" style="margin-left: 10px;">
        Cancelar
    </a>

</form>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>