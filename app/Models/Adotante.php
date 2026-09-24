<?php

namespace Models;

class Adotante extends Model
{
    public function cadastrar(
        int $usuario_id,
        string $cpf,
        string $telefone,
        string $tipo_moradia,
        int $tem_outros_pets = 0
    ): bool {
        $query = $this->db->prepare(
            "INSERT INTO adotantes_perfis 
                (usuario_id, cpf, telefone, tipo_moradia, tem_outros_pets) 
            VALUES 
                (:usuario_id, :cpf, :telefone, :tipo_moradia, :tem_outros_pets)"
        );

        return $query->execute([
            'usuario_id' => $usuario_id,
            'cpf' => $cpf,
            'telefone' => $telefone,
            'tipo_moradia' => $tipo_moradia,
            'tem_outros_pets' => $tem_outros_pets
        ]);
    }

    public function apagar(int $id): bool
    {
        $query = $this->db->prepare("DELETE FROM adotantes_perfis WHERE id = :id");
        return $query->execute(['id' => $id]);
    }

    public function findByID(int $id): ?array
    {
        $query = $this->db->prepare(
            "SELECT ap.*, u.nome AS usuario_nome, u.email AS usuario_email 
             FROM adotantes_perfis ap
             JOIN usuarios u ON ap.usuario_id = u.id
             WHERE ap.id = :id"
        );
        $query->execute(['id' => $id]);
        return $query->fetch() ?: null;
    }

    public function atualizar(
        int $id,
        int $usuario_id,
        string $cpf,
        string $telefone,
        string $tipo_moradia,
        int $tem_outros_pets
    ): bool {
        $query = $this->db->prepare(
            "UPDATE adotantes_perfis
             SET usuario_id = :usuario_id,
                 cpf = :cpf,
                 telefone = :telefone,
                 tipo_moradia = :tipo_moradia,
                 tem_outros_pets = :tem_outros_pets
             WHERE id = :id"
        );

        return $query->execute([
            'id' => $id,
            'usuario_id' => $usuario_id,
            'cpf' => $cpf,
            'telefone' => $telefone,
            'tipo_moradia' => $tipo_moradia,
            'tem_outros_pets' => $tem_outros_pets
        ]);
    }

    public function findAll(): array
    {
        $query = $this->db->query(
            "SELECT ap.*, u.nome AS usuario_nome, u.email AS usuario_email 
             FROM adotantes_perfis ap
             JOIN usuarios u ON ap.usuario_id = u.id
             ORDER BY ap.id ASC"
        );

        return $query->fetchAll();
    }

    public function buscarUsuarios(): array
    {
        $query = $this->db->query("SELECT id, nome, email, tipo FROM usuarios ORDER BY nome ASC");
        return $query->fetchAll();
    }
}