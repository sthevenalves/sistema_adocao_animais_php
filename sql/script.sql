SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

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

<<<<<<< HEAD
=======
# Inserções de usuarios
INSERT INTO usuarios (nome, email, senha, tipo) VALUES
('Admin ONG', 'admin@ong.com', '$2y$10$Hr//bw5zm/bS3sp86w.Hne1DLcdK87QqGs8bvN2XqoKK4l9rMvYay', 'admin'),
('João Silva', 'joao@email.com', 'hash_senha_user', 'adotante'),
('Maria Oliveira', 'maria@email.com', 'hash_senha_user2', 'adotante'),
('Carlos Souza', 'carlos@email.com', 'hash_senha_user3', 'adotante'),
('Ana Lima', 'ana@email.com', 'hash_senha_user4', 'adotante'),
('Suporte ONG', 'suporte@ong.com', 'hash_senha_admin2', 'admin');

>>>>>>> e72d342 (fix: corrige hash das senhas dos usuários)
# Inserções de animais
INSERT INTO animais (nome, especie, idade_anos, porte, vacinado, descricao, status) VALUES
('Woody', 'Cachorro', 3, 'Pequeno', 1, 'Branco e caramelo', 'disponivel'),
('Mimi', 'Gato', 2, 'Pequeno', 1, 'Gata tricolor muito carinhosa', 'disponivel'),
('Thor', 'Cachorro', 5, 'Grande', 1, 'Cão de guarda dócil com a família', 'em_processo'),
('Pipoca', 'Outro', 1, 'Pequeno', 0, 'Coelho muito ativo e brincalhão', 'disponivel'),
('Luna', 'Gato', 4, 'Medio', 1, 'Gata preta castrada e quieta', 'adotado'),
('Bob', 'Cachorro', 7, 'Medio', 0, 'SRD idoso que gosta de caminhar', 'disponivel');

# Inserções de adotantes_perfis
INSERT INTO adotantes_perfis (usuario_id, cpf, telefone, tipo_moradia, tem_outros_pets) VALUES
(1, '567.890.123-44', '(42) 95555-5555', 'Apartamento', 0),
(2, '123.456.789-00', '(42) 99999-9999', 'Casa', 1),
(3, '234.567.890-11', '(42) 98888-8888', 'Apartamento', 0),
(4, '345.678.901-22', '(42) 97777-7777', 'Casa', 1),
(5, '456.789.012-33', '(42) 96666-6666', 'Chácara', 1);
