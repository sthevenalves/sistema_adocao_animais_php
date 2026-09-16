<?php

class Animal
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // ?string quando aceita nulo
    public function create(string $nome, string $especie, int $idade_anos, string $porte, int $vacinado, ?string $descricao, string $status): bool
    {
        // Com prepare() a query SQL é enviado ao banco sem os valores ainda, apenas com um placeholder :id no lugar do valor real
        $query = $this->db->prepare(
            "INSERT INTO animais (nome, especie, idade_anos, porte, vacinado, descricao, status) 
                   VALUES (:nome, :especie, :idade_anos, :porte, :vacinado, :descricao, :status)"
        );
        // Com execute() roda a query, substituindo o placeholder :id pelo valor de $id que você passou no array
        return $query->execute([
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

    public function delete(int $id): bool
    {
        $query = $this->db->prepare("DELETE FROM animais WHERE id = :id");
        return $query->execute(['id' => $id]);
    }

    public function findByID(int $id): bool
    {
        $query = $this->db->prepare("SELECT * FROM animais WHERE id = :id");
        return $query->execute(['id' => $id]);
    }
}