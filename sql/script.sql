CREATE DATABASE IF NOT EXISTS ong_adocao;
USE ong_adocao;

-- 1. Tabela da Parte 1 (Login/Usuários)
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('admin', 'adotante') NOT NULL DEFAULT 'adotante'
);

-- 2. Suas 3 Tabelas (Parte 2)
CREATE TABLE animais (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    especie ENUM('Cachorro', 'Gato', 'Outro') NOT NULL,
    idade_anos INT NOT NULL,
    porte ENUM('Pequeno', 'Medio', 'Grande') NOT NULL,
    vacinado TINYINT(1) DEFAULT 0,
    descricao TEXT,
    status ENUM('disponivel', 'em_processo', 'adotado') DEFAULT 'disponivel'
);

CREATE TABLE adotantes_perfis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    telefone VARCHAR(20) NOT NULL,
    tipo_moradia ENUM('Casa', 'Apartamento', 'Chácara') NOT NULL,
    tem_outros_pets TINYINT(1) DEFAULT 0,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE TABLE solicitacoes_adocao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    animal_id INT NOT NULL,
    adotante_id INT NOT NULL,
    data_solicitacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pendente', 'em_analise', 'aprovado', 'rejeitado') DEFAULT 'pendente',
    observacoes_admin TEXT,
    FOREIGN KEY (animal_id) REFERENCES animais(id),
    FOREIGN KEY (adotante_id) REFERENCES adotantes_perfis(id)
);

# Exemplos de Inserções de animais
INSERT INTO animais VALUES (NULL, 'woody', 'Cachorro', 3, 'Pequeno', 1, 'branco e caramelo', 'disponivel')
INSERT INTO animais VALUES (NULL, 'Mimi', 'Gato', 2, 'Pequeno', 1, 'Gata tricolor muito carinhosa', 'disponivel');
INSERT INTO animais VALUES (NULL, 'Thor', 'Cachorro', 5, 'Grande', 1, 'Cão de guarda dócil com a família', 'em_processo');
INSERT INTO animais VALUES (NULL, 'Pipoca', 'Outro', 1, 'Pequeno', 0, 'Coelho muito ativo e brincalhão', 'disponivel');
INSERT INTO animais VALUES (NULL, 'Luna', 'Gato', 4, 'Médio', 1, 'Gata preta castrada e quieta', 'adotado');
INSERT INTO animais VALUES (NULL, 'Bob', 'Cachorro', 7, 'Médio', 0, 'SDR idoso que gosta de caminhar', 'disponivel');