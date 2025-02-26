# Sistema de Empréstimo de Chaves - UFOPA

## Introdução

O Sistema de Empréstimo de Chaves é uma solução desenvolvida para a Universidade Federal do Oeste do Pará (UFOPA) com o objetivo de gerenciar o processo de empréstimo de chaves de salas e laboratórios dos campi.

Este sistema permite controlar o acesso aos espaços da universidade, registrando quem retirou determinada chave, em qual horário, e quando foi devolvida, garantindo maior segurança e organização na gestão das chaves da universidade.

## Funcionalidades Principais

- Cadastro e gerenciamento de chaves de salas e laboratórios
- Registro de empréstimos e devoluções
- Controle de acesso baseado em perfis de usuário
- Histórico completo de movimentações

## Requisitos do Sistema

### Requisitos de Hardware
- Processador: 1.0 GHz ou superior
- Memória RAM: 2 GB ou superior
- Espaço em disco: 1 GB para instalação

### Requisitos de Software
- PHP 8.1 ou superior
- Composer 2.0 ou superior
- Node.js 16.x ou superior
- NPM 8.x ou superior
- MySQL 8.0 ou MariaDB 10.5
- Servidor Web (Apache/Nginx)
- Git

## Configuração do Projeto

### 1. Clone o Repositório

```bash
git clone https://github.com/seu-usuario/sistema-emprestimo-chaves.git
cd sistema-emprestimo-chaves
```

### 2. Instalação de Dependências

```bash
# Instalação das dependências do PHP
composer install

# Instalação das dependências do Node.js
npm install
```

### 3. Configuração do Ambiente

```bash
# Copie o arquivo de ambiente
cp .env.example .env

# Gere a chave da aplicação
php artisan key:generate
```

Edite o arquivo `.env` com as configurações do seu ambiente, especialmente as conexões de banco de dados:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistema_chaves
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 4. Configuração do Banco de Dados

```bash
# Crie a estrutura do banco de dados
php artisan migrate

# (Opcional) Popule o banco com dados de exemplo
php artisan db:seed
```

### 5. Compilação de Assets

```bash
# Desenvolvimento
npm run dev

# Produção
npm run build
```

### 6. Iniciando o Servidor

```bash
php artisan serve
```

O sistema estará disponível em `http://localhost:8000`

## Estrutura do Projeto

O projeto segue a estrutura padrão do Laravel com algumas adaptações para integração com Vue.js e Inertia.js:

- `app/` - Contém os modelos, controladores e lógica principal
- `resources/js/` - Componentes Vue.js e lógica de frontend
- `resources/views/` - Templates Blade e arquivos base do Inertia
- `routes/` - Definições de rotas da aplicação
- `database/` - Migrações e seeders do banco de dados
- `public/` - Arquivos públicos e ponto de entrada da aplicação

## Implantação em Produção

Para implantar o sistema em ambiente de produção, siga estas recomendações adicionais:

1. Configure um servidor web adequado (Nginx ou Apache)
2. Utilize HTTPS para garantir a segurança das comunicações
3. Configure backups regulares do banco de dados
4. Ajuste as permissões de arquivo conforme necessário
5. Otimize as configurações do PHP para ambiente de produção

## Contribuição

Para contribuir com o desenvolvimento deste projeto:

1. Crie um fork do repositório
2. Crie uma branch para sua feature (`git checkout -b feature/nova-funcionalidade`)
3. Faça commit das suas alterações (`git commit -m 'Adiciona nova funcionalidade'`)
4. Envie para a branch (`git push origin feature/nova-funcionalidade`)
5. Abra um Pull Request

## Suporte

Em caso de dúvidas ou problemas, entre em contato com a equipe de TI da UFOPA ou abra uma issue no repositório do projeto.

## Licença

Este projeto está licenciado sob [inserir tipo de licença].
