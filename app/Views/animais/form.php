<!-- Inclui o topo do layout padronizado header.php -->
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2>Cadastrar Novo Pet</h2>

<!-- LEITURA E EXIBIÇÃO DO AVISO DA SESSÃO -->
<?php if (isset($_SESSION['feedback'])): ?> <!-- Vê se o Controller deixou alguma mensagem guardada na $_SESSION['feedback'] -->
    <?php
    // Recupera 'erro' ou 'sucesso' e o texto da mensagem enviados pelo Controller na sessão
    $tipo = $_SESSION['feedback']['tipo'];
    $mensagem = $_SESSION['feedback']['mensagem'];

    // Limpa a sessão logo após ler, pois a mensagem precisa desaparecer se o usuário recarregar a página
    unset($_SESSION['feedback']);
    ?>
    <!-- A classe CSS muda dependendo da variável $tipo, virando 'alerta-erro' ou 'alerta-sucesso' -->
    <div class="alerta-<?= $tipo ?>">
        <?= htmlspecialchars($mensagem) ?>
    </div>
<?php endif; ?>

<!-- FORMULÁRIO QUE APONTA PARA O CONTROLLER -->
<!-- 'action': Para qual rota da aplicação esses dados serão enviados ao clicar em Salvar -->
<form action="/animais/salvar" method="POST">

    <!-- Os inputs name="" criam a variável que o Controller lê -->
    <div class="campo">
        <label for="nome">Nome do Animal:</label>
        <!-- nesse caso: name="nome" -> $_POST['nome'] -->
        <input type="text" id="nome" name="nome" placeholder="Ex: Rex">
    </div>

    <div class="campo">
        <label for="especie">Espécie:</label>
        <select id="especie" name="especie" style="width: 100%; padding: 8px; box-sizing: border-box;" required>
            <option value="">Selecione a espécie</option>
            <option value="Cachorro">Cachorro</option>
            <option value="Gato">Gato</option>
            <option value="Outro">Outro</option>
        </select>
    </div>

    <div class="campo">
        <label for="idade">Idade (em anos):</label>
        <input type="number" id="idade" name="idade" min="0" placeholder="Ex: 3" required>
    </div>

    <div class="campo">
        <label for="porte">Porte:</label>
        <select id="porte" name="porte" style="width: 100%; padding: 8px; box-sizing: border-box;" required>
            <option value="">Selecione o porte</option>
            <option value="Pequeno">Pequeno</option>
            <option value="Medio">Médio</option>
            <option value="Grande">Grande</option>
        </select>
    </div>

    <div class="campo">
        <label for="vacinado">Vacinado:</label>
        <select id="vacinado" name="vacinado" style="width: 100%; padding: 8px; box-sizing: border-box;">
            <option value="0">Não</option>
            <option value="1">Sim</option>
        </select>
    </div>

    <div class="campo">
        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" rows="4" style="width: 100%; padding: 8px; box-sizing: border-box;" placeholder="Descrição do animal"></textarea>
    </div>

    <div class="campo">
        <label for="status">Status:</label>
        <select id="status" name="status" style="width: 100%; padding: 8px; box-sizing: border-box;">
            <option value="disponivel" selected>Disponível</option>
            <option value="em_processo">Em Processo</option>
            <option value="adotado">Adotado</option>
        </select>
    </div>

    <button type="submit">Salvar Animal</button>
    <a href="/animais">Cancelar</a>
</form>

<!-- Inclui o rodapé do layout padronizado footer.php -->
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>