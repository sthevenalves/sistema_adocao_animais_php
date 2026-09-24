<?php
/**
 * Seed de usuários
 * Usa password_hash() pra gerar o hash automaticamente
 * Precisa escrever a senha em texto aqui
 */

require_once __DIR__ . '/../config/Database.php';

$db = (new \config\Database())->getConnection();

$usuarios = [
    ['nome' => 'Admin ONG',       'email' => 'admin@ong.com',    'senha' => 'admin123',  'tipo' => 'admin'],
    ['nome' => 'João Silva',      'email' => 'joao@email.com',   'senha' => 'user123',   'tipo' => 'adotante'],
    ['nome' => 'Maria Oliveira',  'email' => 'maria@email.com',  'senha' => 'user123',   'tipo' => 'adotante'],
    ['nome' => 'Carlos Souza',    'email' => 'carlos@email.com', 'senha' => 'user123',   'tipo' => 'adotante'],
    ['nome' => 'Ana Lima',        'email' => 'ana@email.com',    'senha' => 'user123',   'tipo' => 'adotante'],
    ['nome' => 'Suporte ONG',     'email' => 'suporte@ong.com',  'senha' => 'admin123',  'tipo' => 'admin'],
];

$query = $db->prepare(
    "INSERT INTO usuarios (nome, email, senha, tipo)
     VALUES (:nome, :email, :senha, :tipo)
     ON DUPLICATE KEY UPDATE senha = VALUES(senha)"
);

foreach ($usuarios as $u) {
    $query->execute([
        'nome'  => $u['nome'],
        'email' => $u['email'],
        'senha' => password_hash($u['senha'], PASSWORD_DEFAULT), // <-- hash
        'tipo'  => $u['tipo'],
    ]);
    echo "{$u['email']} inserido\n";
}
