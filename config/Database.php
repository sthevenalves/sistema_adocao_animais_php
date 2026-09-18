<?php

namespace config;
use PDO;
class database
{
    private string $host = 'db';
    private string $database = 'ong_adocao';
    private string $user = 'root';
    private string $password = 'root';

    public function getConnection(): PDO
    {
        // Código pra conectar nesse MySQL, nesse banco, usando UTF-8
        $dsn = "mysql:host={$this->host}; dbname={$this->database}; charset=utf8mb4";

        // Criação do PDO para conversar com o BD
        return new PDO($dsn, $this->user, $this->password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }
}