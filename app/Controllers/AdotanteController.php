<?php

namespace Controllers;

use Models\Adotante;

class AdotanteController
{
    private Adotante $adotanteModel;

    public function __construct()
    {
        $this->adotanteModel = new Adotante();
    }

    // Exibe a lista de adotantes cadastrados
    public function index(): void
    {
        $adotantes = $this->adotanteModel->findAll();
        require_once __DIR__ . '/../Views/adotantes/index.php'; // Carrega o arquivo HTML/PHP da View
    }

    // Exibe o formulário de cadastro de adotante
    public function form(): void
    {
        $usuarios = $this->adotanteModel->buscarUsuarios();
        require_once __DIR__ . '/../Views/adotantes/form.php';
    }

    // Valida os dados do formulário
    private function validarFormulario(array $dados): ?string
    {
        $usuario_id = $dados['usuario_id'] ?? null;
        $cpf = trim($dados['cpf'] ?? '');
        $telefone = trim($dados['telefone'] ?? '');
        $tipo_moradia = trim($dados['tipo_moradia'] ?? '');

        // Verifica se há campos vazios
        if (empty($usuario_id) || empty($cpf) || empty($telefone) || empty($tipo_moradia)) {
            return 'Preencha todos os campos obrigatórios!';
        }

        if (!is_numeric($usuario_id) || (int)$usuario_id <= 0) {
            return 'Selecione um usuário válido.';
        }

        // Limita o CPF em 14 caracteres
        if (mb_strlen($cpf) > 14) {
            return 'O CPF não pode ter mais de 14 caracteres.';
        }

        // Limita o telefone em 20 caracteres
        if (mb_strlen($telefone) > 20) {
            return 'O telefone não pode ter mais de 20 caracteres.';
        }

        return null; // Retorna null se não houver erros
    }

    // Processa o envio do formulário (POST)
    public function salvar(): void
    {
        // Recebe os dados do formulário
        $usuario_id = $_POST['usuario_id'] ?? null;
        $cpf = trim($_POST['cpf'] ?? '');
        $telefone = trim($_POST['telefone'] ?? '');
        $tem_outros_pets = !empty($_POST['tem_outros_pets']) ? 1 : 0;

        $tipo_moradiaInput = ucfirst(strtolower(trim($_POST['tipo_moradia'] ?? '')));
        $moradiasValidas = ['Casa', 'Apartamento', 'Chácara'];
        $tipo_moradia = in_array($tipo_moradiaInput, $moradiasValidas, true) ? $tipo_moradiaInput : '';

        $dadosParaValidar = [
            'usuario_id' => $usuario_id,
            'cpf' => $cpf,
            'telefone' => $telefone,
            'tipo_moradia' => $tipo_moradia
        ];

        $erro = $this->validarFormulario($dadosParaValidar);
        if ($erro !== null)
        {   // Grava uma mensagem temporária na sessão para exibir na tela do usuário
            $_SESSION['feedback'] = ['tipo' => 'erro', 'mensagem' => $erro];
            header('Location: /adotantes/criar'); // Instrução HTTP para voltar ao formulário
            exit;
        }

        try {
            // Se passou nas validações, chama o Model para salvar
            $sucesso = $this->adotanteModel->cadastrar(
                (int) $usuario_id,
                $cpf,
                $telefone,
                $tipo_moradia,
                $tem_outros_pets
            );

            if ($sucesso)
            {
                $_SESSION['feedback'] = [
                    'tipo' => 'sucesso',
                    'mensagem' => 'Perfil do adotante cadastrado com sucesso!'
                ];
                // Sucesso: vai para a lista de adotantes
                header('Location: /adotantes');
            }
            else
            {
                $_SESSION['feedback'] = [
                    'tipo' => 'erro',
                    'mensagem' => 'Erro ao salvar o perfil do adotante no banco de dados.'
                ];
                // Falhou: volta para o forms do banco
                header('Location: /adotantes/criar');
            }
        } catch (\PDOException $e) {
            $_SESSION['feedback'] = [
                'tipo' => 'erro',
                'mensagem' => 'Erro ao cadastrar adotante. Verifique se o CPF já está cadastrado.'
            ];
            header('Location: /adotantes/criar');
        }
        exit;
    }
}