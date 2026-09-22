<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Carrega a conexão com o banco e os arquivos necessários
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../app/Models/Model.php';
require_once __DIR__ . '/../app/Models/Animal.php';
require_once __DIR__ . '/../app/Controllers/AnimalController.php';

use Controllers\AnimalController;

// 2. Pega o caminho da URL acessada no navegador
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$controller = new AnimalController();

// 3. Roteamento das URLs para os métodos do Controller
if ($uri === '/animais' || $uri === '/') {
    $controller->index();
} elseif ($uri === '/animais/criar') {
    $controller->form();
} elseif ($uri === '/animais/salvar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->salvar();
} else {
    http_response_code(404);
    echo "Página não encontrada (404)";
}