<?php

namespace Controllers;

use \Models\Animal;

class AnimalController
{
    private Animal $animalModel;

    public function __construct()
    {
        // Instancia o Model para usar os métodos
        $this->animalModel = new Animal();
    }

    // Exibe a lista de animais
    public function index(): void
    {
        $animais = $this->animalModel->findAll();
        require_once __DIR__ . '/../Views/animais/index.php'; // Carrega o arquivo HTML/PHP da View
    }

    // Exibe o formulário de cadastro ou edição
public function form(): void
{
    $id = (int) ($_GET['id'] ?? 0);

    $animal = null;

    // Se recebeu um ID, busca o animal para edição
    if ($id > 0) {
        $animal = $this->animalModel->findByID($id);

        if (!$animal) {
            $_SESSION['feedback'] = [
                'tipo' => 'erro',
                'mensagem' => 'Animal não encontrado.'
            ];

            header('Location: /animais');
            exit;
        }
    }

    require_once __DIR__ . '/../Views/animais/form.php';
}

// Atualiza um animal existente
public function atualizar(): void
{
    $id = (int) ($_POST['id'] ?? 0);

    $nome = trim($_POST['nome'] ?? '');
    $especie = trim($_POST['especie'] ?? '');
    $idade = $_POST['idade'] ?? null;
    $vacinado = !empty($_POST['vacinado']) ? 1 : 0;
    $descricao = isset($_POST['descricao']) && trim($_POST['descricao']) !== ''
        ? trim($_POST['descricao'])
        : null;

    $porteInput = ucfirst(strtolower(trim($_POST['porte'] ?? '')));
    $portesPermitidos = ['Pequeno', 'Medio', 'Grande'];

    $porte = in_array($porteInput, $portesPermitidos, true)
        ? $porteInput
        : 'Medio';

    $status = trim($_POST['status'] ?? 'disponivel');
    $statusPermitidos = ['disponivel', 'em_processo', 'adotado'];

    if (!in_array($status, $statusPermitidos, true)) {
        $status = 'disponivel';
    }

    $dadosParaValidar = [
        'nome' => $nome,
        'especie' => $especie,
        'idade' => $idade,
        'descricao' => $descricao
    ];

    $erro = $this->validarFormulario($dadosParaValidar);

    if ($erro !== null) {
        $_SESSION['feedback'] = [
            'tipo' => 'erro',
            'mensagem' => $erro
        ];

        header('Location: /animais/editar?id=' . $id);
        exit;
    }

    $sucesso = $this->animalModel->atualizar(
        $id,
        $nome,
        $especie,
        (int) $idade,
        $porte,
        $vacinado,
        $descricao,
        $status
    );

    $_SESSION['feedback'] = [
        'tipo' => $sucesso ? 'sucesso' : 'erro',
        'mensagem' => $sucesso
            ? 'Animal atualizado com sucesso!'
            : 'Erro ao atualizar o animal.'
    ];

    header('Location: /animais');
    exit;
}

// Exclui um animal
public function apagar(): void
{
    $id = (int) ($_POST['id'] ?? 0);

    if ($id <= 0) {
        $_SESSION['feedback'] = [
            'tipo' => 'erro',
            'mensagem' => 'Animal inválido.'
        ];

        header('Location: /animais');
        exit;
    }

    $sucesso = $this->animalModel->apagar($id);

    $_SESSION['feedback'] = [
        'tipo' => $sucesso ? 'sucesso' : 'erro',
        'mensagem' => $sucesso
            ? 'Animal excluído com sucesso!'
            : 'Erro ao excluir o animal.'
    ];

    header('Location: /animais');
    exit;
}

    // Valida os dados do formulário
    private function validarFormulario(array $dados): ?string
    {
        $nome = trim($dados['nome'] ?? '');
        $especie = trim($dados['especie'] ?? '');
        $idade = $dados['idade'] ?? null;
        $descricao = $dados['descricao'] ?? null;

        // Verifica se há campos vazios
        if (empty($nome) || empty($especie) || $idade === null || $idade === '') {
            return 'Preencha todos os campos obrigatórios!';
        }

        // Limita o nome em 100 caracteres
        if (mb_strlen($nome) > 100) {
            return 'O nome não pode ter mais de 100 caracteres.';
        }

        // Limita o nome em 100 caracteres
        if (!is_numeric($idade) || (int)$idade < 0) {
            return 'A idade deve ser um número inteiro positivo.';
        }

        // Limita o nome em 1000 caracteres
        if ($descricao !== null && mb_strlen($descricao) > 1000) {
            return 'A descrição é muito longa (máximo de 1000 caracteres).';
        }

        return null; // Retorna null se não houver erros
    }

    

    // Processa o envio do formulário (POST)
    public function salvar(): void
    {
        // Recebe os dados do formulário
        $nome = trim($_POST['nome'] ?? '');
        $especie = trim($_POST['especie'] ?? '');
        $idade = $_POST['idade'] ?? ($_POST['idade_anos'] ?? null);
        $vacinado = !empty($_POST['vacinado']) ? 1 : 0;
        $descricao = isset($_POST['descricao']) && trim($_POST['descricao']) !== '' ? trim($_POST['descricao']) : null;
        $status = trim($_POST['status'] ?? 'disponivel');

        // Define o valor padrão de porte como médio se não for preenchido
        $porteInput = ucfirst(strtolower(trim($_POST['porte'] ?? '')));
        $portesPermitidos = ['Pequeno', 'Medio', 'Grande'];
        $porte = in_array($porteInput, $portesPermitidos, true) ? $porteInput : 'Medio'; // Valor padrão

        // Define o valor padrão de status como disponível se não for preenchido
        $statusPermitidos = ['disponivel', 'em_processo', 'adotado'];
        if (!in_array($status, $statusPermitidos, true)) {
            $status = 'disponivel'; // Valor padrão
        }

        $dadosParaValidar = [
            'nome' => $nome,
            'especie' => $especie,
            'idade' => $idade,
            'descricao' => $descricao
        ];

        $erro = $this->validarFormulario($dadosParaValidar);
        if ($erro !== null)
        {   // Grava uma mensagem temporária na sessão para exibir na tela do usuário
            $_SESSION['feedback'] = ['tipo' => 'erro', 'mensagem' => $erro];
            header('Location: /animais/criar'); // Instrução HTTP para voltar ao formulário
            exit;
        }

        // Se passou nas validações, chama o Model para salvar
        $sucesso = $this->animalModel->cadastrar(
            $nome,
            $especie,
            (int) $idade,
            $porte,
            $vacinado,
            $descricao,
            $status
        );

        // A função Animal dos Models retorna TRUE se foi salvo tudo e aí entra no IF
        if ($sucesso)
        {
            $_SESSION['feedback'] = [
                'tipo' => 'sucesso',
                'mensagem' => 'Animal cadastrado com sucesso!'
            ];
            // Sucesso: vai para a lista de animais
            header('Location: /animais');
        }
        else
        {
            $_SESSION['feedback'] = [
                'tipo' => 'erro',
                'mensagem' => 'Erro ao salvar no banco de dados.'
            ];
            // Falhou: volta para o forms do banco
            header('Location: /animais/criar');
        }
        exit;
    }

    
}