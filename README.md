# Flowkey

## Introdução

O **Flowkey** é uma sistema desenvolvido para a Universidade Federal do Oeste do Pará (UFOPA) com o objetivo de gerenciar o processo de empréstimo de chaves de salas e laboratórios dos campi. O sistema permite controlar o acesso aos espaços da universidade, registrando quem retirou determinada chave, em qual horário, e quando foi devolvida, garantindo maior segurança e organização no acesso a esses espaços.

## Funcionalidades Principais

- **Cadastro e gerenciamento de chaves**
- **Registro de empréstimos e devoluções**
- **Controle de acesso**

## Requisitos

- [Git](https://git-scm.com/)
- [Node.js e npm](https://nodejs.org/)
- [Composer](https://getcomposer.org/)
- PHP
- Banco de dados configurado (PostgreSQL, MySQL, etc.)

## Instalação e Configuração

Siga os passos abaixo para clonar e configurar o projeto:

1. **Clonar o repositório:**

   ```bash
   git clone https://github.com/jpsantosbembe/flowkey.git
   ```

2. **Acessar o diretório do projeto:**

   ```bash
   cd flowkey
   ```

3. **Instalar dependências do Node.js:**

   ```bash
   npm install
   ```

4. **Instalar dependências do Composer:**

   ```bash
   composer install
   ```

5. **Configurar o ambiente:**
      Copie o arquivo de exemplo e ajuste as variáveis conforme necessário:
      ```bash
      cp .env.example .env
      ```
    >**Nota:** O arquivo `.env` já está configurado para se conectar ao banco de dados PostgreSQL com o nome `projetochave`, usando o usuário `root` e aceitando conexões sem senha a partir do localhost.
    >
    >Caso sua configuração de banco de dados seja diferente, será necessário fazer os ajustes apropriados no arquivo `.env`. 
    >
    >Este documento não fornece instruções sobre como realizar essas alterações, pois assume-se que você já tenha conhecimento sobre como configurar conexões de banco de dados.
6. **Executar as migrações (simulação e efetiva):**

   Para verificar a conexão com o banco e simular as migrações:

   ```bash
   php artisan migrate --pretend
   ```

   Em seguida, execute as migrações com os seeders:

   ```bash
   php artisan migrate --seed
   ```

7. **Gerar a chave do aplicativo:**

   ```bash
   php artisan key:generate
   ```

## Execução do Projeto

Após concluir a instalação e configuração, você pode iniciar o servidor para testar o sistema:

```bash
composer run dev
```

Acesse o sistema através do endereço indicado no terminal (normalmente `localhost:8000`).

