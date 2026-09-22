<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2>Nova Solicitação de Adoção</h2>

<!-- LEITURA E EXIBIÇÃO DO AVISO DA SESSÃO VIA COMPONENTE -->
<?php require_once __DIR__ . '/../includes/feedback.php'; ?>

<!-- FORMULÁRIO QUE APONTA PARA O CONTROLLER -->
<form action="/solicitacoes/salvar" method="POST">

    <div class="campo">
        <label for="animal_id">Selecione o Animal:</label>
        <select id="animal_id" name="animal_id" style="width: 100%; padding: 8px; box-sizing: border-box;" required>
            <option value="">Selecione um animal</option>
            <?php if (!empty($animais)): ?>
                <?php foreach ($animais as $animal): ?>
                    <option value="<?= htmlspecialchars($animal['id']) ?>">
                        <?= htmlspecialchars($animal['nome']) ?> (<?= htmlspecialchars($animal['especie']) ?>) - Status: <?= htmlspecialchars($animal['status']) ?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>

    <div class="campo">
        <label for="adotante_id">Selecione o Adotante:</label>
        <select id="adotante_id" name="adotante_id" style="width: 100%; padding: 8px; box-sizing: border-box;" required>
            <option value="">Selecione um adotante</option>
            <?php if (!empty($adotantes)): ?>
                <?php foreach ($adotantes as $adotante): ?>
                    <option value="<?= htmlspecialchars($adotante['id']) ?>">
                        <?= htmlspecialchars($adotante['usuario_nome']) ?> (CPF: <?= htmlspecialchars($adotante['cpf']) ?> - <?= htmlspecialchars($adotante['tipo_moradia']) ?>)
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>

    <div class="campo">
        <label for="status">Status Inicial:</label>
        <select id="status" name="status" style="width: 100%; padding: 8px; box-sizing: border-box;">
            <option value="pendente" selected>Pendente</option>
            <option value="em_analise">Em análise</option>
            <option value="aprovado">Aprovado</option>
            <option value="rejeitado">Rejeitado</option>
        </select>
    </div>

    <div class="campo">
        <label for="observacoes_admin">Observações da Triagem / Análise (opcional):</label>
        <textarea id="observacoes_admin" name="observacoes_admin" rows="4" style="width: 100%; padding: 8px; box-sizing: border-box;" placeholder="Insira observações relevantes sobre o pedido de adoção..."></textarea>
    </div>

    <button type="submit">Salvar Solicitação</button>
    <a href="/solicitacoes" style="margin-left: 10px;">Cancelar</a>
</form>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
