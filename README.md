# Sistema de Adoção de Animais (ONG)

Aplicação web desenvolvida em **PHP 8+ (Vanilla MVC)** e **MySQL 8.4** para gestão de rotinas e processos de adoção de animais em uma ONG.

---

## 👤 Integrantes

* **Nome do Integrante 1**: Tobias Rocha
* **Nome do Integrante 2**: Stheven Alves

---

## 👥 Divisão de Responsabilidades

### Parte 1: Infraestrutura, Autenticação e Roteamento
* **Banco de Dados & Containerization:** Criação do `Dockerfile`, arquivo `docker-compose.yaml`, script SQL base (`script.sql`) e arquivo de conexão PDO (`Database.php`).
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

## ⚠️ Limitações Conhecidas

### 1. Validação de CPF
* O CPF **não tem validação completa**: os dígitos verificadores não são conferidos, então CPFs inválidos (ex.: `111.111.111-11`) podem ser cadastrados.
* Não há tratamento padronizado do formato (com ou sem pontos e traço), o que pode gerar registros inconsistentes no banco.

### 2. Validação e formato do telefone
* O telefone **não é validado nem normalizado** em relação ao formato definido no banco de dados. Números fora do padrão esperado (DDD, quantidade de dígitos, máscara) podem ser aceitos no formulário e causar inconsistência ou erro ao salvar.

### 3. Ausência de controle de perfis (Admin × Usuário comum)
* **Não existe separação de permissões entre administrador e usuário comum.** Qualquer usuário autenticado tem acesso a **todas** as funcionalidades do sistema.
* Ações que deveriam ser exclusivas de um administrador, como **aprovar/rejeitar solicitações de adoção**, cadastrar/editar animais e listar adotantes, ficam disponíveis para todos.
* Não há validação de perfil nas rotas nem nos controllers, e a interface exibe os mesmos menus para qualquer usuário.

---

## 📁 Estrutura de Arquivos e Funções

```text
sistema-adocao/
├── config/
│   └── Database.php          # [Parte 1] Configura e estabelece a conexão PDO com o MySQL
│
├── sql/
│   └── script.sql            # [Parte 1/2] Script SQL de criação do banco e das tabelas
│
├── app/
│   ├── Models/               # [Classes] Interagem diretamente com o MySQL
│   │   ├── Model.php         # [Parte 1] Classe base para modelos com conexão PDO
│   │   ├── Usuario.php       # [Parte 1] Busca dados de acesso e valida senhas no login
│   │   ├── Animal.php        # [Parte 2] SQLs de inserção, edição e consulta de pets
│   │   ├── Adotante.php      # [Parte 2] SQLs do perfil do adotante
│   │   └── SolicitacaoAdocao.php # [Parte 2] SQLs do processo de adoção e mudança de status
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
│       │   ├── index.php     # Tabela com listagem dos animais
│       │   └── form.php      # Formulário de cadastro de animal
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
│   ├── css/
│   │   └── style.css         # [Parte 1] Folha de estilos CSS da aplicação
│   └── index.php             # [Parte 1] Front Controller: recebe as requisições e inicia a app
│
├── Dockerfile                # [Parte 1] Configuração da imagem PHP CLI com extensões PDO MySQL
├── docker-compose.yaml       # [Parte 1] Configuração dos containers Docker (PHP App, MySQL + phpMyAdmin)
├── config.md                 # Guia de configuração do ambiente, Docker e credenciais
└── README.md                 # Documentação principal e instruções de execução
```

---

## Como Executar a Aplicação

### 1. Pré-requisitos
* **Docker** e **Docker Compose** instalados e em execução.
* **PHP 8.0+** instalado localmente na máquina (opcional caso execute via container).

### 2. Iniciar o Ambiente com Docker (Dockerfile + Docker Compose)
Na raiz do projeto, construa a imagem do Dockerfile e suba todos os containers (aplicação PHP, MySQL e phpMyAdmin) em segundo plano:
```bash
docker compose up -d --build
```
> *Para consultar credenciais detalhadas, portas e utilitários do banco, veja o arquivo [`config.md`](./config.md).*

*(Opcional: Iniciar o Servidor Web do PHP Localmente)*
Caso deseje executar o PHP localmente na máquina hospedeira em vez de usar o container da aplicação:
```bash
php -S localhost:8000 -t public
```

### 3. Acessar o Sistema
* **Aplicação Web:** `http://localhost:8000`
* **Gerenciador de Banco (phpMyAdmin):** `http://localhost:8080`