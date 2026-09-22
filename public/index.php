<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Carrega a conexão com o banco e os arquivos necessários
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../app/Models/Model.php';
require_once __DIR__ . '/../app/Models/Animal.php';
require_once __DIR__ . '/../app/Models/Adotante.php';
require_once __DIR__ . '/../app/Models/SolicitacaoAdocao.php';

require_once __DIR__ . '/../app/Controllers/AnimalController.php';
require_once __DIR__ . '/../app/Controllers/AdotanteController.php';
require_once __DIR__ . '/../app/Controllers/SolicitacaoController.php';

use Controllers\AnimalController;
use Controllers\AdotanteController;
use Controllers\SolicitacaoController;

// 2. Pega o caminho da URL acessada no navegador
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// 3. Roteamento das URLs para os métodos do Controller
if ($uri === '/animais' || $uri === '/') {
    (new AnimalController())->index();
} elseif ($uri === '/animais/criar') {
    (new AnimalController())->form();
} elseif ($uri === '/animais/salvar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    (new AnimalController())->salvar();
} elseif ($uri === '/adotantes') {
    (new AdotanteController())->index();
} elseif ($uri === '/adotantes/criar') {
    (new AdotanteController())->form();
} elseif ($uri === '/adotantes/salvar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    (new AdotanteController())->salvar();
} elseif ($uri === '/solicitacoes') {
    (new SolicitacaoController())->index();
} elseif ($uri === '/solicitacoes/criar') {
    (new SolicitacaoController())->form();
} elseif ($uri === '/solicitacoes/salvar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    (new SolicitacaoController())->salvar();
} elseif ($uri === '/solicitacoes/status' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    (new SolicitacaoController())->atualizarStatus();
} else {
    http_response_code(404);
    echo "Página não encontrada (404)";
}