# Sistema de Adoção de Animais (ONG)

Aplicação web desenvolvida em **PHP 8+ (Vanilla MVC)** e **MySQL 8.4** para gestão de rotinas e processos de adoção de animais em uma ONG.

---

## 👥 Divisão de Responsabilidades

### Parte 1: Infraestrutura, Autenticação e Roteamento
* **Banco de Dados & Containerization:** Criação do arquivo `docker-compose.yml`, script SQL base (`script.sql`) e arquivo de conexão PDO (`Database.php`).
* **Arquitetura MVC & Roteamento:** Configuração do Front Controller (`public/index.php`) e resolução de rotas da aplicação.
* **Autenticação e Sessões:** Sistema de Login, Logout, criptografia de senhas (`password_hash`) e controle de acesso a áreas restritas (`$_SESSION`).
* **Layout Base:** Templates reutilizáveis de cabeçalho e rodapé (`header.php` e `footer.php`).

---

### Parte 2: Módulos de Negócio, Formulários e Validações
* **Gestão de Animais (CRUD 1):** Cadastro, edição e listagem de pets com controle de status (*Disponível*, *Em Processo*, *Adotado*).
* **Perfil do Adotante (CRUD 2):** Formulário de cadastro do interessado (CPF, moradia, outros pets) e listagem.
* **Processo de Adoção (CRUD 3):** Fluxo de solicitação de adoção e painel administrativo para alteração de etapas (*Pendente*, *Aprovado*, *Rejeitado*).
* **Validações & Feedback:** Tratamento de erros no lado do servidor em PHP e renderização de alertas de erro/sucesso.
* **Documentação:** Elaboração do relatório de entrega, mapeamento de arquivos e guias de execução.

---

## 📁 Estrutura de Arquivos e Funções

```text
sistema-adocao/
├── config/
│   └── database.php          # [Parte 1] Configura e estabelece a conexão PDO com o MySQL
│
├── sql/
│   └── script.sql            # [Parte 1/2] Script SQL de criação do banco e das tabelas
│
├── app/
│   ├── Models/               # [Classes] Interagem diretamente com o MySQL
│   │   ├── Usuario.php       # [Parte 1] Busca dados de acesso e valida senhas no login
│   │   ├── Animal.php        # [Parte 2] SQLs de inserção, edição e consulta de pets
│   │   ├── Adotante.php      # [Parte 2] SQLs do perfil do adotante
│   │   └── Solicitacao.php   # [Parte 2] SQLs do processo de adoção e mudança de status
│   │
│   ├── Controllers/          # [Classes] Intermediam regra de negócio, validações e views
│   │   ├── AuthController.php# [Parte 1] Processa login, encerra sessão e restringe acessos
│   │   ├── AnimalController.php # [Parte 2] Valida dados do pet e chama a View correspondente
│   │   ├── AdotanteController.php # [Parte 2] Valida formulário do adotante
│   │   └── SolicitacaoController.php # [Parte 2] Processa pedidos de adoção e aprovações
│   │
│   └── Views/                # [Scripts HTML/PHP] Interfaces exibidas ao usuário
│       ├── layouts/          # [Parte 1] Estrutura visual padronizada
│       │   ├── header.php    # Cabeçalho com menu de navegação
│       │   └── footer.php    # Rodapé do sistema
│       │
│       ├── auth/             # [Parte 1] Autenticação
│       │   └── login.php     # Formulário de entrada no sistema
│       │
│       ├── animais/          # [Parte 2] Módulo de Pets
│       │   ├── index.php     # Tabela/cards com listagem dos animais
│       │   └── form.php      # Formulário único de cadastro e edição de animal
│       │
│       ├── adotantes/        # [Parte 2] Módulo de Adotantes
│       │   ├── index.php     # Listagem de pessoas cadastradas
│       │   └── form.php      # Formulário de perfil do adotante
│       │
│       ├── solicitacoes/     # [Parte 2] Módulo do Processo de Adoção
│       │   ├── index.php     # Tabela de pedidos de adoção em andamento
│       │   └── form.php      # Form para o usuário solicitar a adoção de um pet
│       │
│       └── includes/         # [Parte 2] Componentes reusáveis
│           └── feedback.php  # Bloco em PHP que exibe alertas de erro/sucesso da sessão
│
├── public/
│   └── index.php             # [Parte 1] Front Controller: recebe as requisições e inicia a app
│
├── docker-compose.yml        # [Parte 1] Configuração dos containers Docker (MySQL + phpMyAdmin)
├── config.md                 # Guia de configuração do ambiente, Docker e credenciais
└── README.md                 # Documentação principal e instruções de execução
```

---

## Como Executar a Aplicação

### 1. Pré-requisitos
* **PHP 8.0+** instalado localmente na máquina.
* **Docker** e **Docker Compose** instalados e em execução.

### 2. Iniciar o Banco de Dados (Docker)
Na raiz do projeto, suba os containers em segundo plano:
```bash
docker compose up -d
```
> *Para consultar credenciais detalhadas, portas e utilitários do banco, veja o arquivo [`config.md`](./config.md).*

### 3. Iniciar o Servidor Web do PHP
No terminal na raiz do projeto, inicie o servidor embutido do PHP apontando para o diretório público:
```bash
php -S localhost:8000 -t public
```

### 4. Acessar o Sistema
* **Aplicação Web:** `http://localhost:8000`
* **Gerenciador de Banco (phpMyAdmin):** `http://localhost:8080`
