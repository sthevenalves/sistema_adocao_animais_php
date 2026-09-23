<?php

namespace Models;
class Usuario extends Model
{
    public function cadastrar
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

    public function apagar(int $id): bool
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

    public function findByEmail(string $email): ?array
    {
        $query = $this->db->prepare("SELECT * FROM usuarios WHERE email = :email");
        $query->execute(['email' => $email]);
        return $query->fetch() ?: null;
    }

    public function atualizar
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