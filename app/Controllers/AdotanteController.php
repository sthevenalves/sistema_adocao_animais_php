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
        require_once __DIR__ . '/../Views/adotantes/index.php';
    }

    // Exibe o formulário de cadastro de adotante
    public function form(): void
    {
        $usuarios = $this->adotanteModel->buscarUsuarios();
        require_once __DIR__ . '/../Views/adotantes/form.php';
    }

    // Processa o envio do formulário (POST)
    public function salvar(): void
    {
        $usuario_id = $_POST['usuario_id'] ?? null;
        $cpf = trim($_POST['cpf'] ?? '');
        $telefone = trim($_POST['telefone'] ?? '');
        $tipo_moradia = trim($_POST['tipo_moradia'] ?? '');
        $tem_outros_pets = !empty($_POST['tem_outros_pets']) ? 1 : 0;

        $moradiasValidas = ['Casa', 'Apartamento', 'Chácara'];
        if (!in_array($tipo_moradia, $moradiasValidas, true)) {
            $tipo_moradia = '';
        }

        // Validação de campos obrigatórios
        if (empty($usuario_id) || empty($cpf) || empty($telefone) || empty($tipo_moradia)) {
            $_SESSION['feedback'] = [
                'tipo' => 'erro',
                'mensagem' => 'Preencha todos os campos obrigatórios!'
            ];
            header('Location: /adotantes/criar');
            exit;
        }

        try {
            $sucesso = $this->adotanteModel->cadastrar(
                (int) $usuario_id,
                $cpf,
                $telefone,
                $tipo_moradia,
                $tem_outros_pets
            );

            if ($sucesso) {
                $_SESSION['feedback'] = [
                    'tipo' => 'sucesso',
                    'mensagem' => 'Perfil do adotante cadastrado com sucesso!'
                ];
                header('Location: /adotantes');
            } else {
                $_SESSION['feedback'] = [
                    'tipo' => 'erro',
                    'mensagem' => 'Erro ao salvar o perfil do adotante no banco de dados.'
                ];
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