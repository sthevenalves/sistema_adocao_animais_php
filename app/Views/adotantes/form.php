<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2>Cadastrar Perfil de Adotante</h2>

<!-- LEITURA E EXIBIÇÃO DO AVISO DA SESSÃO VIA COMPONENTE -->
<?php require_once __DIR__ . '/../includes/feedback.php'; ?>

<!-- FORMULÁRIO QUE APONTA PARA O CONTROLLER -->
<form action="/adotantes/salvar" method="POST">

    <div class="campo">
        <label for="usuario_id">Usuário Associado:</label>
        <select id="usuario_id" name="usuario_id" style="width: 100%; padding: 8px; box-sizing: border-box;" required>
            <option value="">Selecione o usuário</option>
            <?php if (!empty($usuarios)): ?>
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?= htmlspecialchars($usuario['id']) ?>">
                        <?= htmlspecialchars($usuario['nome']) ?> (<?= htmlspecialchars($usuario['email']) ?>)
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>

    <div class="campo">
        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" maxlength="14" required>
    </div>

    <div class="campo">
        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" placeholder="(00) 00000-0000" maxlength="20" required>
    </div>

    <div class="campo">
        <label for="tipo_moradia">Tipo de Moradia:</label>
        <select id="tipo_moradia" name="tipo_moradia" style="width: 100%; padding: 8px; box-sizing: border-box;" required>
            <option value="">Selecione o tipo de moradia</option>
            <option value="Casa">Casa</option>
            <option value="Apartamento">Apartamento</option>
            <option value="Chácara">Chácara</option>
        </select>
    </div>

    <div class="campo">
        <label for="tem_outros_pets">Possui outros pets?</label>
        <select id="tem_outros_pets" name="tem_outros_pets" style="width: 100%; padding: 8px; box-sizing: border-box;">
            <option value="0" selected>Não</option>
            <option value="1">Sim</option>
        </select>
    </div>

    <button type="submit">Salvar Adotante</button>
    <a href="/adotantes" style="margin-left: 10px;">Cancelar</a>
</form>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
