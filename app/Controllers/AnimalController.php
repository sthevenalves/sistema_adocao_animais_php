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

    public function form(): void
    {
        require_once __DIR__ . '/../Views/animais/form.php';
    }

    // Processa o envio do formulário (POST)
    public function salvar(): void
    {
        // Recebe os dados do formulário
        $nome = trim($_POST['nome'] ?? '');
        $especie = trim($_POST['especie'] ?? '');
        $idade = $_POST['idade'] ?? ($_POST['idade_anos'] ?? null);
        $porte = trim($_POST['porte'] ?? '');
        $vacinado = !empty($_POST['vacinado']) ? 1 : 0;
        $descricao = isset($_POST['descricao']) && trim($_POST['descricao']) !== '' ? trim($_POST['descricao']) : null;
        $status = trim($_POST['status'] ?? 'disponivel');

        $statusPermitidos = ['disponivel', 'em_processo', 'adotado'];
        if (!in_array($status, $statusPermitidos, true)) {
            $status = 'disponivel';
        }

        // Verifica se há campos vazios
        if (empty($nome) || empty($especie) || $idade === null || $idade === '' || empty($porte))
        {
            // Grava uma mensagem temporária na sessão para exibir na tela do usuário
            $_SESSION['feedback'] = [
                'tipo' => 'erro',
                'mensagem' => 'Preencha todos os campos obrigatórios!'
            ];

            // Instrução HTTP para voltar ao formulário
            header('Location: /animais/criar');
            exit;
        }

        // Se passou na validação, chama o Model para salvar
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