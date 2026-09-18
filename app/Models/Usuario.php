<?php

class Usuario
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function create
    (
        string $nome,
        string $email,
        string $senha,
        string $tipo = 'adotante'): bool
    {
        $query = $this->db->prepare
        (
            "INSERT INTO 
                usuarios(nome, email, senha, tipo) 
               VALUES 
                (:nome, :email, :senha, :tipo)"
        );

        return $query->execute
        ([
            'nome' => $nome,
            'email' => $email,
            'senha' => $senha,
            'tipo' => $tipo
        ]);
    }

    public function delete(int $id): bool
    {
        $query = $this->db->prepare("DELETE FROM usuarios WHERE id = :id");
        return $query->execute(['id' => $id]);
    }

    public function findByID(int $id): ?array
    {
        $query = $this->db->prepare("SELECT * FROM usuarios WHERE id = :id");
        $query->execute(['id' => $id]);
        return $query->fetch() ?: null;
    }

    public function update
    (
        int $id,
        string $nome,
        string $email,
        string $senha,
        string $tipo): bool
    {
        $query = $this->db->prepare
        (
            "UPDATE usuarios
             SET nome = :nome,
                 email = :email,
                 senha = :senha,
                 tipo = :tipo
             WHERE id = :id"
        );

        return $query->execute
        ([
            'id' => $id,
            'nome' => $nome,
            'email' => $email,
            'senha' => $senha,
            'tipo' => $tipo
        ]);
    }
}