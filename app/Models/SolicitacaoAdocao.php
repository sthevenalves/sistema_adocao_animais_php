<?php

namespace Models;

class SolicitacaoAdocao extends Model
{
    public function cadastrar(
        int $animal_id,
        int $adotante_id,
        ?string $observacoes_admin = null,
        string $status = 'pendente'
    ): bool {
        $query = $this->db->prepare(
            "INSERT INTO solicitacoes_adocao 
                (animal_id, adotante_id, observacoes_admin, status) 
             VALUES 
                (:animal_id, :adotante_id, :observacoes_admin, :status)"
        );

        return $query->execute([
            'animal_id' => $animal_id,
            'adotante_id' => $adotante_id,
            'observacoes_admin' => $observacoes_admin,
            'status' => $status
        ]);
    }

    public function apagar(int $id): bool
    {
        $query = $this->db->prepare("DELETE FROM solicitacoes_adocao WHERE id = :id");
        return $query->execute(['id' => $id]);
    }

    public function findByID(int $id): ?array
    {
        $query = $this->db->prepare(
            "SELECT s.*, 
                    a.nome AS animal_nome, a.especie AS animal_especie,
                    u.nome AS adotante_nome, ap.cpf AS adotante_cpf
             FROM solicitacoes_adocao s
             JOIN animais a ON s.animal_id = a.id
             JOIN adotantes_perfis ap ON s.adotante_id = ap.id
             JOIN usuarios u ON ap.usuario_id = u.id
             WHERE s.id = :id"
        );
        $query->execute(['id' => $id]);
        return $query->fetch() ?: null;
    }

    public function atualizarStatus(int $id, string $status, ?string $observacoes_admin = null): bool
    {
        $query = $this->db->prepare(
            "UPDATE solicitacoes_adocao 
         SET status = :status, observacoes_admin = :observacoes_admin 
         WHERE id = :id"
        );

        return $query->execute([
            'id' => $id,
            'status' => $status,
            'observacoes_admin' => $observacoes_admin
        ]);
    }

    public function findAll(): array
    {
        $query = $this->db->query(
            "SELECT s.*, 
                    a.nome AS animal_nome, a.especie AS animal_especie,
                    u.nome AS adotante_nome, ap.cpf AS adotante_cpf
             FROM solicitacoes_adocao s
             JOIN animais a ON s.animal_id = a.id
             JOIN adotantes_perfis ap ON s.adotante_id = ap.id
             JOIN usuarios u ON ap.usuario_id = u.id
             ORDER BY s.data_solicitacao DESC"
        );

        return $query->fetchAll();
    }
}