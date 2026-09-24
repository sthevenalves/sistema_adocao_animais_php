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

    // Exibe o formulário de cadastro ou edição
    public function form(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        $adotante = null;

        // Se recebeu um ID, busca o adotante para edição
        if ($id > 0) {
            $adotante = $this->adotanteModel->findByID($id);

            if (!$adotante) {
                $_SESSION['feedback'] = [
                    'tipo' => 'erro',
                    'mensagem' => 'Adotante não encontrado.'
                ];

                header('Location: /adotantes');
                exit;
            }
        }

        // Busca os usuários para preencher o select do formulário
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

        // Verifica se o usuário é válido
        if (!is_numeric($usuario_id) || (int) $usuario_id <= 0) {
            return 'Selecione um usuário válido.';
        }

        // Limita o tamanho do CPF
        if (mb_strlen($cpf) > 14) {
            return 'O CPF não pode ter mais de 14 caracteres.';
        }

        // Limita o tamanho do telefone
        if (mb_strlen($telefone) > 20) {
            return 'O telefone não pode ter mais de 20 caracteres.';
        }

        return null;
    }

    // Processa o cadastro de um novo adotante
    public function salvar(): void
    {
        $usuario_id = $_POST['usuario_id'] ?? null;
        $cpf = trim($_POST['cpf'] ?? '');
        $telefone = trim($_POST['telefone'] ?? '');
        $tem_outros_pets = !empty($_POST['tem_outros_pets']) ? 1 : 0;

        $tipo_moradiaInput = ucfirst(
            strtolower(trim($_POST['tipo_moradia'] ?? ''))
        );

        $moradiasValidas = ['Casa', 'Apartamento', 'Chácara'];

        $tipo_moradia = in_array(
            $tipo_moradiaInput,
            $moradiasValidas,
            true
        )
            ? $tipo_moradiaInput
            : '';

        $dadosParaValidar = [
            'usuario_id' => $usuario_id,
            'cpf' => $cpf,
            'telefone' => $telefone,
            'tipo_moradia' => $tipo_moradia
        ];

        $erro = $this->validarFormulario($dadosParaValidar);

        if ($erro !== null) {
            $_SESSION['feedback'] = [
                'tipo' => 'erro',
                'mensagem' => $erro
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

    // Atualiza um adotante existente
    public function atualizar(): void
    {
        $id = (int) ($_POST['id'] ?? 0);

        $usuario_id = $_POST['usuario_id'] ?? null;
        $cpf = trim($_POST['cpf'] ?? '');
        $telefone = trim($_POST['telefone'] ?? '');
        $tem_outros_pets = !empty($_POST['tem_outros_pets']) ? 1 : 0;

        $tipo_moradiaInput = ucfirst(
            strtolower(trim($_POST['tipo_moradia'] ?? ''))
        );

        $moradiasValidas = ['Casa', 'Apartamento', 'Chácara'];

        $tipo_moradia = in_array(
            $tipo_moradiaInput,
            $moradiasValidas,
            true
        )
            ? $tipo_moradiaInput
            : '';

        $dadosParaValidar = [
            'usuario_id' => $usuario_id,
            'cpf' => $cpf,
            'telefone' => $telefone,
            'tipo_moradia' => $tipo_moradia
        ];

        $erro = $this->validarFormulario($dadosParaValidar);

        if ($erro !== null) {
            $_SESSION['feedback'] = [
                'tipo' => 'erro',
                'mensagem' => $erro
            ];

            header('Location: /adotantes/editar?id=' . $id);
            exit;
        }

        try {
            $sucesso = $this->adotanteModel->atualizar(
                $id,
                (int) $usuario_id,
                $cpf,
                $telefone,
                $tipo_moradia,
                $tem_outros_pets
            );

            $_SESSION['feedback'] = [
                'tipo' => $sucesso ? 'sucesso' : 'erro',
                'mensagem' => $sucesso
                    ? 'Perfil do adotante atualizado com sucesso!'
                    : 'Erro ao atualizar o perfil do adotante.'
            ];
        } catch (\PDOException $e) {
            $_SESSION['feedback'] = [
                'tipo' => 'erro',
                'mensagem' => 'Erro ao atualizar adotante. Verifique se o CPF já está cadastrado.'
            ];
        }

        header('Location: /adotantes');
        exit;
    }

    // Exclui um adotante
    public function apagar(): void
    {
        $id = (int) ($_POST['id'] ?? 0);

        if ($id <= 0) {
            $_SESSION['feedback'] = [
                'tipo' => 'erro',
                'mensagem' => 'Adotante inválido.'
            ];

            header('Location: /adotantes');
            exit;
        }

        try {
            $sucesso = $this->adotanteModel->apagar($id);

            $_SESSION['feedback'] = [
                'tipo' => $sucesso ? 'sucesso' : 'erro',
                'mensagem' => $sucesso
                    ? 'Adotante excluído com sucesso!'
                    : 'Erro ao excluir o adotante.'
            ];
        } catch (\PDOException $e) {
            $_SESSION['feedback'] = [
                'tipo' => 'erro',
                'mensagem' => 'Não foi possível excluir o adotante. Ele pode possuir solicitações de adoção vinculadas.'
            ];
        }

        header('Location: /adotantes');
        exit;
    }
}