<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Carrega a conexão com o banco e os arquivos necessários
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../app/Models/Model.php';
require_once __DIR__ . '/../app/Models/Usuario.php';
require_once __DIR__ . '/../app/Models/Animal.php';
require_once __DIR__ . '/../app/Models/Adotante.php';
require_once __DIR__ . '/../app/Models/SolicitacaoAdocao.php';

require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/AnimalController.php';
require_once __DIR__ . '/../app/Controllers/AdotanteController.php';
require_once __DIR__ . '/../app/Controllers/SolicitacaoController.php';

use Controllers\AuthController;
use Controllers\AnimalController;
use Controllers\AdotanteController;
use Controllers\SolicitacaoController;


function exigirLogin(string $uriAtual): void
{
    if (empty($_SESSION['usuario'])) {
        $_SESSION['feedback'] = [
            'tipo' => 'erro',
            'mensagem' => 'Faça login para acessar essa página.',
        ];
        // guarda a pagina que o usuario queria ver, pra AuthController::autenticar()
        // poder mandar de volta pra ela depois do login
        $_SESSION['pos_login_redirect'] = $uriAtual;
        header('Location: /login');
        exit;
    }
}

// Pega o caminho da URL acessada no navegador
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$metodo = $_SERVER['REQUEST_METHOD'];

/// Roteamento das URLs para os métodos do Controller
if ($uri === '/animais' || $uri === '/') {
    (new AnimalController())->index();

// rotas de login/logout (Autenticacao)
} elseif ($uri === '/login' && $metodo === 'GET') {
    (new AuthController())->formLogin();
} elseif ($uri === '/login' && $metodo === 'POST') {
    (new AuthController())->autenticar();
} elseif ($uri === '/logout') {
    (new AuthController())->logout();

// cadastro/edicao/exclusao de animais agora exige login
} elseif ($uri === '/animais/criar') {
    exigirLogin($uri);
    (new AnimalController())->form();
} elseif ($uri === '/animais/editar') {
    exigirLogin($uri);
    (new AnimalController())->form();
} elseif ($uri === '/animais/salvar' && $metodo === 'POST') {
    exigirLogin($uri);
    (new AnimalController())->salvar();
} elseif ($uri === '/animais/atualizar' && $metodo === 'POST') {
    exigirLogin($uri);
    (new AnimalController())->atualizar();
} elseif ($uri === '/animais/apagar' && $metodo === 'POST') {
    exigirLogin($uri);
    (new AnimalController())->apagar();

// modulo de adotantes exige login
} elseif ($uri === '/adotantes') {
    exigirLogin($uri);
    (new AdotanteController())->index();
} elseif ($uri === '/adotantes/criar') {
    exigirLogin($uri);
    (new AdotanteController())->form();
} elseif ($uri === '/adotantes/editar') {
    exigirLogin($uri);
    (new AdotanteController())->form();
} elseif ($uri === '/adotantes/salvar' && $metodo === 'POST') {
    exigirLogin($uri);
    (new AdotanteController())->salvar();
} elseif ($uri === '/adotantes/atualizar' && $metodo === 'POST') {
    exigirLogin($uri);
    (new AdotanteController())->atualizar();
} elseif ($uri === '/adotantes/apagar' && $metodo === 'POST') {
    exigirLogin($uri);
    (new AdotanteController())->apagar();

// solicitacoes de adocao exigem login (inclusive aprovar/rejeitar)
} elseif ($uri === '/solicitacoes') {
    exigirLogin($uri);
    (new SolicitacaoController())->index();
} elseif ($uri === '/solicitacoes/criar') {
    exigirLogin($uri);
    (new SolicitacaoController())->form();
} elseif ($uri === '/solicitacoes/salvar' && $metodo === 'POST') {
    exigirLogin($uri);
    (new SolicitacaoController())->salvar();
} elseif ($uri === '/solicitacoes/status' && $metodo === 'POST') {
    exigirLogin($uri);
    (new SolicitacaoController())->atualizarStatus();
} else {
    http_response_code(404);
    echo "Página não encontrada (404)";
}