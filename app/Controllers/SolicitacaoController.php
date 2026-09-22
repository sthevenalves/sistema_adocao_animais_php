<?php

namespace Controllers;

use Models\SolicitacaoAdocao;
use Models\Animal;
use Models\Adotante;

class SolicitacaoController
{
    private SolicitacaoAdocao $solicitacaoModel;
    private Animal $animalModel;
    private Adotante $adotanteModel;

    public function __construct()
    {
        $this->solicitacaoModel = new SolicitacaoAdocao();
        $this->animalModel = new Animal();
        $this->adotanteModel = new Adotante();
    }

    // Exibe a lista de pedidos de adoção
    public function index(): void
    {
        $solicitacoes = $this->solicitacaoModel->findAll();
        require_once __DIR__ . '/../Views/solicitacoes/index.php';
    }

    // Exibe o formulário de solicitação de adoção
    public function form(): void
    {
        $animais = $this->animalModel->findDisponiveis();
        if (empty($animais)) {
            $animais = $this->animalModel->findAll();
        }
        $adotantes = $this->adotanteModel->findAll();
        require_once __DIR__ . '/../Views/solicitacoes/form.php';
    }

    // Processa o envio da solicitação (POST)
    public function salvar(): void
    {
        $animal_id = $_POST['animal_id'] ?? null;
        $adotante_id = $_POST['adotante_id'] ?? null;
        $status = trim($_POST['status'] ?? 'pendente');
        $observacoes_admin = isset($_POST['observacoes_admin']) && trim($_POST['observacoes_admin']) !== '' 
            ? trim($_POST['observacoes_admin']) 
            : null;

        $statusPermitidos = ['pendente', 'em_analise', 'aprovado', 'rejeitado'];
        if (!in_array($status, $statusPermitidos, true)) {
            $status = 'pendente';
        }

        // Validação de campos obrigatórios
        if (empty($animal_id) || empty($adotante_id)) {
            $_SESSION['feedback'] = [
                'tipo' => 'erro',
                'mensagem' => 'Selecione um animal e um perfil de adotante!'
            ];
            header('Location: /solicitacoes/criar');
            exit;
        }

        $sucesso = $this->solicitacaoModel->cadastrar(
            (int) $animal_id,
            (int) $adotante_id,
            $observacoes_admin,
            $status
        );

        if ($sucesso) {
            $_SESSION['feedback'] = [
                'tipo' => 'sucesso',
                'mensagem' => 'Solicitação de adoção registrada com sucesso!'
            ];
            header('Location: /solicitacoes');
        } else {
            $_SESSION['feedback'] = [
                'tipo' => 'erro',
                'mensagem' => 'Erro ao salvar a solicitação de adoção no banco de dados.'
            ];
            header('Location: /solicitacoes/criar');
        }
        exit;
    }

    // Processa a alteração de status da solicitação (POST)
    public function atualizarStatus(): void
    {
        $id = $_POST['id'] ?? null;
        $status = trim($_POST['status'] ?? '');
        $observacoes_admin = isset($_POST['observacoes_admin']) && trim($_POST['observacoes_admin']) !== '' 
            ? trim($_POST['observacoes_admin']) 
            : null;

        $statusPermitidos = ['pendente', 'em_analise', 'aprovado', 'rejeitado'];

        if (empty($id) || !in_array($status, $statusPermitidos, true)) {
            $_SESSION['feedback'] = [
                'tipo' => 'erro',
                'mensagem' => 'Status ou solicitação inválida para atualização.'
            ];
            header('Location: /solicitacoes');
            exit;
        }

        $sucesso = $this->solicitacaoModel->atualizarStatus((int) $id, $status, $observacoes_admin);

        if ($sucesso) {
            $_SESSION['feedback'] = [
                'tipo' => 'sucesso',
                'mensagem' => 'Status da solicitação atualizado com sucesso!'
            ];
        } else {
            $_SESSION['feedback'] = [
                'tipo' => 'erro',
                'mensagem' => 'Erro ao atualizar o status da solicitação.'
            ];
        }

        header('Location: /solicitacoes');
        exit;
    }
}