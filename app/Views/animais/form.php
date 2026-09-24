<!-- Formulário de cadastro e edição de animais -->

<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<?php
$editando = isset($animal) && $animal !== null;
?>

<h2><?= $editando ? 'Editar Animal' : 'Cadastrar Novo Pet' ?></h2>

<!-- Exibe mensagens de sucesso ou erro -->
<?php require_once __DIR__ . '/../includes/feedback.php'; ?>

<!-- Formulário -->
<form
    action="<?= $editando ? '/animais/atualizar' : '/animais/salvar' ?>"
    method="POST"
>

    <!-- ID do animal: usado somente durante a edição -->
    <?php if ($editando): ?>
        <input type="hidden" name="id" value="<?= $animal['id'] ?>">
    <?php endif; ?>

    <!-- Nome -->
    <div class="campo">
        <label for="nome">Nome do Animal:</label>

        <input
            type="text"
            id="nome"
            name="nome"
            placeholder="Ex: Rex"
            value="<?= htmlspecialchars($animal['nome'] ?? '') ?>"
            required
        >
    </div>

    <!-- Espécie -->
    <div class="campo">
        <label for="especie">Espécie:</label>

        <select
            id="especie"
            name="especie"
            style="width: 100%; padding: 8px; box-sizing: border-box;"
            required
        >
            <option value="">Selecione a espécie</option>

            <option value="Cachorro"
                <?= ($animal['especie'] ?? '') === 'Cachorro' ? 'selected' : '' ?>>
                Cachorro
            </option>

            <option value="Gato"
                <?= ($animal['especie'] ?? '') === 'Gato' ? 'selected' : '' ?>>
                Gato
            </option>

            <option value="Outro"
                <?= ($animal['especie'] ?? '') === 'Outro' ? 'selected' : '' ?>>
                Outro
            </option>
        </select>
    </div>

    <!-- Idade -->
    <div class="campo">
        <label for="idade">Idade (em anos):</label>

        <input
            type="number"
            id="idade"
            name="idade"
            min="0"
            placeholder="Ex: 3"
            value="<?= htmlspecialchars($animal['idade_anos'] ?? '') ?>"
            required
        >
    </div>

    <!-- Porte -->
    <div class="campo">
        <label for="porte">Porte:</label>

        <select
            id="porte"
            name="porte"
            style="width: 100%; padding: 8px; box-sizing: border-box;"
            required
        >
            <option value="">Selecione o porte</option>

            <option value="Pequeno"
                <?= ($animal['porte'] ?? '') === 'Pequeno' ? 'selected' : '' ?>>
                Pequeno
            </option>

            <option value="Medio"
                <?= ($animal['porte'] ?? '') === 'Medio' ? 'selected' : '' ?>>
                Médio
            </option>

            <option value="Grande"
                <?= ($animal['porte'] ?? '') === 'Grande' ? 'selected' : '' ?>>
                Grande
            </option>
        </select>
    </div>

    <!-- Vacinação -->
    <div class="campo">
        <label for="vacinado">Vacinado:</label>

        <select
            id="vacinado"
            name="vacinado"
            style="width: 100%; padding: 8px; box-sizing: border-box;"
        >
            <option value="0"
                <?= ($animal['vacinado'] ?? 0) == 0 ? 'selected' : '' ?>>
                Não
            </option>

            <option value="1"
                <?= ($animal['vacinado'] ?? 0) == 1 ? 'selected' : '' ?>>
                Sim
            </option>
        </select>
    </div>

    <!-- Descrição -->
    <div class="campo">
        <label for="descricao">Descrição:</label>

        <textarea
            id="descricao"
            name="descricao"
            rows="4"
            style="width: 100%; padding: 8px; box-sizing: border-box;"
            placeholder="Descrição do animal"
        ><?= htmlspecialchars($animal['descricao'] ?? '') ?></textarea>
    </div>

    <!-- Status -->
    <div class="campo">
        <label for="status">Status:</label>

        <select
            id="status"
            name="status"
            style="width: 100%; padding: 8px; box-sizing: border-box;"
        >
            <option value="disponivel"
                <?= ($animal['status'] ?? 'disponivel') === 'disponivel' ? 'selected' : '' ?>>
                Disponível
            </option>

            <option value="em_processo"
                <?= ($animal['status'] ?? '') === 'em_processo' ? 'selected' : '' ?>>
                Em Processo
            </option>

            <option value="adotado"
                <?= ($animal['status'] ?? '') === 'adotado' ? 'selected' : '' ?>>
                Adotado
            </option>
        </select>
    </div>

    <!-- Botões -->
    <button type="submit">
        <?= $editando ? 'Atualizar Animal' : 'Salvar Animal' ?>
    </button>

    <a href="/animais">Cancelar</a>

</form>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>