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
        // Instancia o Model para usar os métodos
        $this->solicitacaoModel = new SolicitacaoAdocao();
        $this->animalModel = new Animal();
        $this->adotanteModel = new Adotante();
    }

    // Exibe a lista de pedidos de adoção
    public function index(): void
    {
        $solicitacoes = $this->solicitacaoModel->findAll();
        require_once __DIR__ . '/../Views/solicitacoes/index.php'; // Carrega o arquivo HTML/PHP da View
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

    // Valida os dados do formulário
    private function validarFormulario(array $dados): ?string
    {
        $animal_id = $dados['animal_id'] ?? null;
        $adotante_id = $dados['adotante_id'] ?? null;
        $observacoes_admin = $dados['observacoes_admin'] ?? null;

        // Verifica se há campos vazios
        if (empty($animal_id) || empty($adotante_id)) {
            return 'Selecione um animal e um perfil de adotante!';
        }

        if (!is_numeric($animal_id) || (int)$animal_id <= 0) {
            return 'Selecione um animal válido.';
        }

        if (!is_numeric($adotante_id) || (int)$adotante_id <= 0) {
            return 'Selecione um adotante válido.';
        }

        if ($observacoes_admin !== null && mb_strlen($observacoes_admin) > 1000) {
            return 'As observações não podem ter mais de 1000 caracteres.';
        }

        return null; // Retorna null se não houver erros
    }

    // Processa o envio da solicitação (POST)
    public function salvar(): void
    {
        // Recebe os dados do formulário
        $animal_id = $_POST['animal_id'] ?? null;
        $adotante_id = $_POST['adotante_id'] ?? null;
        $status = trim($_POST['status'] ?? 'pendente');
        $observacoes_admin = isset($_POST['observacoes_admin']) && trim($_POST['observacoes_admin']) !== ''
            ? trim($_POST['observacoes_admin'])
            : null;

        // Define o valor padrão de status como pendente se não for preenchido
        $statusPermitidos = ['pendente', 'em_analise', 'aprovado', 'rejeitado'];
        if (!in_array($status, $statusPermitidos, true)) {
            $status = 'pendente'; // Valor padrão
        }

        $dadosParaValidar = [
            'animal_id' => $animal_id,
            'adotante_id' => $adotante_id,
            'observacoes_admin' => $observacoes_admin
        ];

        $erro = $this->validarFormulario($dadosParaValidar);
        if ($erro !== null)
        {   // Grava uma mensagem temporária na sessão para exibir na tela do usuário
            $_SESSION['feedback'] = ['tipo' => 'erro', 'mensagem' => $erro];
            header('Location: /solicitacoes/criar'); // Instrução HTTP para voltar ao formulário
            exit;
        }

        // Se passou nas validações, chama o Model para salvar
        $sucesso = $this->solicitacaoModel->cadastrar(
            (int) $animal_id,
            (int) $adotante_id,
            $observacoes_admin,
            $status
        );

        if ($sucesso)
        {
            $_SESSION['feedback'] = [
                'tipo' => 'sucesso',
                'mensagem' => 'Solicitação de adoção registrada com sucesso!'
            ];
            // Sucesso: vai para a lista de solicitacoes
            header('Location: /solicitacoes');
        }
        else
        {
            $_SESSION['feedback'] = [
                'tipo' => 'erro',
                'mensagem' => 'Erro ao salvar a solicitação de adoção no banco de dados.'
            ];
            // Falhou: volta para o forms do banco
            header('Location: /solicitacoes/criar');
        }
        exit;
    }

    // Processa a alteração de status da solicitação (POST)
    public function atualizarStatus(): void
    {
        // Recebe os dados do formulário
        $id = $_POST['id'] ?? null;
        $status = trim($_POST['status'] ?? '');
        $observacoes_admin = isset($_POST['observacoes_admin']) && trim($_POST['observacoes_admin']) !== ''
            ? trim($_POST['observacoes_admin'])
            : null;

        $statusPermitidos = ['pendente', 'em_analise', 'aprovado', 'rejeitado'];

        if (empty($id) || !is_numeric($id) || (int)$id <= 0 || !in_array($status, $statusPermitidos, true)) {
            $_SESSION['feedback'] = [
                'tipo' => 'erro',
                'mensagem' => 'Status ou solicitação inválida para atualização.'
            ];
            header('Location: /solicitacoes');
            exit;
        }

        if ($observacoes_admin !== null && mb_strlen($observacoes_admin) > 1000) {
            $_SESSION['feedback'] = [
                'tipo' => 'erro',
                'mensagem' => 'As observações não podem ter mais de 1000 caracteres.'
            ];
            header('Location: /solicitacoes');
            exit;
        }

        // Busca a solicitação para saber a qual animal ela pertence
        $solicitacao = $this->solicitacaoModel->findByID((int) $id);

        if (!$solicitacao) {
            $_SESSION['feedback'] = [
                'tipo' => 'erro',
                'mensagem' => 'Solicitação não encontrada.'
            ];
            header('Location: /solicitacoes');
            exit;
        }

        $sucesso = $this->solicitacaoModel->atualizarStatus((int) $id, $status, $observacoes_admin);

        if ($sucesso) {
            // Regra de negócio: Sincroniza o status do animal conforme a solicitação
            if ($status === 'aprovado') {
                $this->animalModel->atualizarStatus((int) $solicitacao['animal_id'], 'adotado');
            } elseif ($status === 'em_analise') {
                $this->animalModel->atualizarStatus((int) $solicitacao['animal_id'], 'em_processo');
            } elseif ($status === 'rejeitado') {
                $this->animalModel->atualizarStatus((int) $solicitacao['animal_id'], 'disponivel');
            }

            $_SESSION['feedback'] = [
                'tipo' => 'sucesso',
                'mensagem' => 'Status da solicitação e do animal atualizados com sucesso!'
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