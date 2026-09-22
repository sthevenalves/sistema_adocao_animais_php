<?php

namespace Models;

class Animal extends Model
{
    public function cadastrar
    (
        string $nome,
        string $especie,
        int $idade_anos,
        string $porte,
        int $vacinado = 0,
        ?string $descricao = null,
        string $status = 'disponivel'): bool
    {
        // Com prepare() a query SQL é enviado ao banco sem os valores ainda, com tipo um placeholder :id no lugar do valor real
        $query = $this->db->prepare
        (
            "INSERT INTO animais 
                    (nome, especie, idade_anos, porte, vacinado, descricao, status) 
                    VALUES 
                    (:nome, :especie, :idade_anos, :porte, :vacinado, :descricao, :status)"
        );
        // Com execute() roda a query, substituindo o placeholder :id pelo valor de $id que você passou no array
        return $query->execute
        ([
            'nome' => $nome,
            'especie' => $especie,
            'idade_anos' => $idade_anos,
            'porte' => $porte,
            'vacinado' => $vacinado,
            'descricao' => $descricao,
            'status' => $status
        ]);

        // A ideia é que esses statments protegem contra SQL Injection pois o valor é tratado como um dado e não como um código SQL
    }

    public function apagar(int $id): bool
    {
        $query = $this->db->prepare("DELETE FROM animais WHERE id = :id");
        return $query->execute(['id' => $id]);
    }

    public function findByID(int $id): ?array
    {
        $query = $this->db->prepare("SELECT * FROM animais WHERE id = :id");
        $query->execute(['id' => $id]);
        return $query->fetch() ?: null; // Retorna o animal encontrado
    }

    public function atualizar
    (
        int $id,
        string $nome,
        string $especie,
        int $idade_anos,
        string $porte,
        int $vacinado,
        ?string $descricao,
        string $status): bool
    {
        $query = $this->db->prepare
        (
            "UPDATE animais
         SET nome = :nome,
             especie = :especie,
             idade_anos = :idade_anos,
             porte = :porte,
             vacinado = :vacinado,
             descricao = :descricao,
             status = :status
         WHERE id = :id"
        );

        return $query->execute
        ([
            'id' => $id,
            'nome' => $nome,
            'especie' => $especie,
            'idade_anos' => $idade_anos,
            'porte' => $porte,
            'vacinado' => $vacinado,
            'descricao' => $descricao,
            'status' => $status
        ]);
    }

    public function findAll(): array
    {
        $query = $this->db->query
        (
            "SELECT * FROM animais"
        );

        return $query->fetchAll(); // Retorna a lista de todos os animais
    }
}