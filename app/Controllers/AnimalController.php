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
        require_once __DIR__ . '/../Views/animais/index.php';
    }

    /*
    Exibe o formulário de cadastro (precisa fazer!!!)
    public function form(): void
    {
        require_once __DIR__ . '/../Views/animais/form.php';
    }
    */

    // Processa o envio do formulário (POST)
    public function salvar(): void
    {
        // Recebe os dados do formulário
        $nome = trim($_POST['nome'] ?? '');
        $especie = trim($_POST['especie'] ?? '');
        $idade = $_POST['idade'] ?? null;

        // Verifica se há campos vazios
        if (empty($nome) || empty($especie) || empty($idade)) {
            $_SESSION['feedback'] = [
                'tipo' => 'erro',
                'mensagem' => 'Todos os campos são obrigatórios!'
            ];

            // Redireciona de volta para o formulário
            header('Location: /animais/criar');
            exit;
        }

        // Se passou na validação, chama o Model para salvar
        $sucesso = $this->animalModel->cadastrar([
            'nome' => $nome,
            'especie' => $especie,
            'idade' => (int) $idade,
            'status' => 'Disponível'
        ]);

        if ($sucesso) {
            $_SESSION['feedback'] = [
                'tipo' => 'sucesso',
                'mensagem' => 'Animal cadastrado com sucesso!'
            ];
            // Sucesso: vai para a listagem
            header('Location: /animais');
        } else {
            $_SESSION['feedback'] = [
                'tipo' => 'erro',
                'mensagem' => 'Erro ao salvar no banco de dados.'
            ];
            header('Location: /animais/criar');
        }
        exit;
    }
}