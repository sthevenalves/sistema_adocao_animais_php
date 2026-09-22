# Configuração do Ambiente e Banco de Dados

Este documento detalha a infraestrutura do projeto, as credenciais da base de dados, comandos de gerenciamento de containers **Docker** e instruções de conexão com IDEs.

---

## Credenciais do Banco de Dados & Serviços

O ambiente é provisionado via **Docker Compose** integrado ao **Dockerfile**, executando um container para a **Aplicação PHP** (`php_ong`), um container **MySQL 8.4 LTS** (`mysql_ong`) e uma interface visual **phpMyAdmin** (`phpmyadmin_ong`).

| Serviço | Parâmetro | Valor Padronizado |
| :--- | :--- | :--- |
| **Aplicação PHP** | URL de Acesso | `http://localhost:8000` |
| **MySQL** | Host | `localhost` (ou `127.0.0.1` / `db` internamente) |
| **MySQL** | Porta Externa | `3306` |
| **MySQL** | Usuário Root | `root` |
| **MySQL** | Senha Root | `root` |
| **MySQL** | Nome da Base | `ong_adocao` |
| **phpMyAdmin** | URL de Acesso | `http://localhost:8080` |

---

## Arquivo de Configuração (`docker-compose.yaml`)

O arquivo de orquestração dos containers na raiz do projeto possui a seguinte estrutura:

```yaml
services:
  app:
    build: .
    container_name: php_ong
    restart: always
    ports:
      - "8000:8000"
    volumes:
      - .:/app
    working_dir: /app
    command: php -S 0.0.0.0:8000 -t public
    depends_on:
      - db

  db:
    image: mysql:8.4
    container_name: mysql_ong
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: ong_adocao
    ports:
      - "3306:3306"
    volumes:
      - db_data:/var/lib/mysql
      - ./sql/script.sql:/docker-entrypoint-initdb.d/script.sql

  phpmyadmin:
    image: phpmyadmin/phpmyadmin
    container_name: phpmyadmin_ong
    restart: always
    ports:
      - "8080:80"
    environment:
      PMA_HOST: db
      MYSQL_ROOT_PASSWORD: root

volumes:
  db_data:
```

> **Nota:** O serviço `app` utiliza o `Dockerfile` para gerar a imagem PHP com as extensões `pdo` e `pdo_mysql`, enquanto o volume `./sql/script.sql` garante que a estrutura de tabelas e dados iniciais sejam carregados automaticamente na primeira criação do container `db`.

---

## Comandos Úteis do Docker

Todos os comandos abaixo devem ser executados no terminal na raiz do projeto:

* **Iniciar todos os serviços construindo a imagem do Dockerfile em segundo plano:**
  ```bash
  docker compose up -d --build
  ```

* **Iniciar os serviços sem reconstruir a imagem:**
  ```bash
  docker compose up -d
  ```

* **Verificar status dos containers:**
  ```bash
  docker compose ps
  ```

* **Pausar os serviços (mantém estado na memória):**
  ```bash
  docker compose stop
  ```

* **Religar os serviços pausados:**
  ```bash
  docker compose start
  ```

* **Desligar e remover containers (libera RAM):**
  ```bash
  docker compose down
  ```

* **Resetar completamente o banco de dados (remove o volume de dados):**
  ```bash
  docker compose down -v
  docker compose up -d --build
  ```

---

## 💻 Conexão no PhpStorm / IDEs

Para conectar a aba **Database** do PhpStorm ao container do MySQL:

1. Abra o painel lateral **Database** > clique no `+` > **Data Source** > **MySQL**.
2. Preencha os campos de conexão:
    * **Host:** `localhost`
    * **Port:** `3306`
    * **User:** `root`
    * **Password:** `root`
    * **Database:** `ong_adocao`
3. Se houver o aviso *Missing driver files*, clique em **Download Driver**.
4. Clique em **Test Connection** e confirme o sucesso.
5. Clique em **OK** para salvar.