<?php

namespace Controllers;

use Models\Usuario;

class AuthController
{
    private Usuario $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new Usuario();
    }

    public function formLogin(): void
    {
        if (!empty($_SESSION['usuario'])) {
            header('Location: /');
            exit;
        }

        require_once __DIR__ . '/../Views/auth/login.php';
    }

    public function autenticar(): void
    {
        $email = trim($_POST['email'] ?? '');
        $senha = (string) ($_POST['senha'] ?? '');

        if (empty($email) || empty($senha)) {
            $_SESSION['feedback'] = [
                'tipo' => 'erro',
                'mensagem' => 'Preencha e-mail e senha.',
            ];
            header('Location: /login');
            exit;
        }

        $usuario = $this->usuarioModel->findByEmail($email);


        if (!$usuario || !password_verify($senha, $usuario['senha'])) {
            $_SESSION['feedback'] = [
                'tipo' => 'erro',
                'mensagem' => 'E-mail ou senha invalidos.',
            ];
            header('Location: /login');
            exit;
        }

        session_regenerate_id(true);

        $_SESSION['usuario'] = [
            'id' => $usuario['id'],
            'nome' => $usuario['nome'],
            'email' => $usuario['email'],
            'tipo' => $usuario['tipo'],
        ];

        $_SESSION['feedback'] = [
            'tipo' => 'sucesso',
            'mensagem' => 'Bem-vindo(a), ' . $usuario['nome'] . '!',
        ];


        $destino = $_SESSION['pos_login_redirect'] ?? '/';
        unset($_SESSION['pos_login_redirect']);

        header('Location: ' . $destino);
        exit;
    }

    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();

        session_start();
        $_SESSION['feedback'] = [
            'tipo' => 'sucesso',
            'mensagem' => 'Voce saiu do sistema.',
        ];

        header('Location: /login');
        exit;
    }
}
