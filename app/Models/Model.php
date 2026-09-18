<?php

namespace Models;
use config\Database;

abstract class Model
{
    protected \PDO $db;

    public function __construct()
    {
        $database = new Database();
        // Conecta com o bd para qualquer classe que herdar de Model
        $this->db = $database->getConnection();
    }
}