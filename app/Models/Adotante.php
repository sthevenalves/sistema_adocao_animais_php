<?php

namespace Models;
/*
 *
 * AQUI PRECISA Buscar dados de acesso e validaR senhas no login, só copiei e colei das outras classes
 *
 * PRECISA AJUSTAR!!!!
 *
 * */
class Adotante extends Model
{
    // ?string quando aceita nulo
    public function cadastrar
    (
        string $cpf,
        string $telefone,
        string $tipo_moradia,
        int $tem_outros_pets): bool
    {
        // Com prepare() a query SQL é enviado ao banco sem os valores ainda, apenas com um placeholder :id no lugar do valor real
        $query = $this->db->prepare
        (
            "INSERT INTO 
                    adotantes_perfis(cpf, telefone, tipo_moradia, tem_outros_pets) 
                   VALUES 
                    (:cpf, :telefone, :tipo_moradia, :tem_outros_pets)"
        );
        // Com execute() roda a query, substituindo o placeholder :id pelo valor de $id que você passou no array
        return $query->execute
        ([
            'cpf' => $cpf,
            'telefone' => $telefone,
            'tipo_moradia' => $tipo_moradia,
            'tem_outros_pets' => $tem_outros_pets
        ]);

        // A ideia é que esses statments protegem contra SQL Injection pois o valor é tratado como um dado e não como um código SQL
    }

    public function apagar(int $id): bool
    {
        $query = $this->db->prepare("DELETE FROM adotantes_perfis WHERE id = :id");
        return $query->execute(['id' => $id]);
    }

    public function findByID(int $id): ?array
    {
        $query = $this->db->prepare("SELECT * FROM adotantes_perfis WHERE id = :id");
        $query->execute(['id' => $id]);
        return $query->fetch() ?: null; // Retorna o adotante encontrado
    }

    public function atualizar
    (
        int $id,
        int $usuario_id,
        string $cpf,
        string $telefone,
        string $tipo_moradia,
        int $tem_outros_pets): bool
    {
        $query = $this->db->prepare
        (
            "UPDATE adotantes_perfis
             SET usuario_id = :usuario_id,
                 cpf = :cpf,
                 telefone = :telefone,
                 tipo_moradia = :tipo_moradia,
                 tem_outros_pets = :tem_outros_pets
             WHERE id = :id"
        );

        return $query->execute
        ([
            'id' => $id,
            'usuario_id' => $usuario_id,
            'cpf' => $cpf,
            'telefone' => $telefone,
            'tipo_moradia' => $tipo_moradia,
            'tem_outros_pets' => $tem_outros_pets
        ]);
    }
}