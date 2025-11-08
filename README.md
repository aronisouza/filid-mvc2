# Filid-MVC

Um framework PHP simples e eficiente para desenvolvimento web

Imagens de projetos feitos com Filid-MVC

<img src="https://aronisouza.com.br/Public/Images/outras-img/Lista-de-Compra.png" alt="Filid-MVC Logo" width="300"/> <img src="https://aronisouza.com.br/Public/Images/Projetos/Sistema-Resifin.webp" alt="Filid-MVC Logo" width="300"/> <img src="https://aronisouza.com.br/Public/Images/Projetos/Filid-MVC.webp" alt="Filid-MVC Logo" width="300"/>

## Visão Geral

O Filid-MVC é um framework que implementa o padrão MVC, dividindo a aplicação em três camadas principais:

- **Model**: Responsável pela lógica de negócios e interação com o banco de dados
- **View**: Interface do usuário, onde os dados são exibidos
- **Controller**: Gerencia as requisições entre a View e o Model

## Estrutura do Projeto

```
MVC/
  ├── Configs/                # Arquivos de configuração
  ├── Controllers/            # Controladores da aplicação
  ├── Core/                   # Classes principais do framework
  ├── logs/                   # Salva os erros em log
  ├── Migrations/             # Tabelas do Banco
  ├── Models/                 # Modelos e lógica de negócios
  ├── Public/                 # Arquivos públicos (CSS, JS, imagens)
  ├── Views/                  # Arquivos de visualização
  │   ├── Controlador/        # Pastas principal da Dashboard
  │   │  └── User             # Páginas de Usuários
  │   └── errors/             # Páginas de erro
  ├── .env                    # Variáveis de ambiente
  ├── .htaccess               # Configurações do Apache
  ├── autoload.php            # Carregador automático de classes
  ├── helpers.php             # Funções auxiliares
  ├── index.php               # Ponto de entrada da aplicação
  ├── make                    # CLI básica para criar Controllers, Models e Views
  └── migrate                 # Roda as Migrations
```

## Requisitos

- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Apache/Nginx
- mod_rewrite habilitado (Apache)

## Instalação

1. Clone o repositório
```bash
git clone https://github.com/aronisouza/filid-mvc2.git
cd filid-mvc2
```

2. Configure seu servidor web
Apache/Nginx para apontar para a pasta do projeto

3. Copie o arquivo de ambiente
```bash
cp .env-copy .env
```

4. Configure as variáveis de ambiente
```env
DB_HOST=localhost
DB_USER=root
DB_PASS=123456
DB_NAME=nome-do-banco
SITE_URL=http://seu-site.com
SITE_TITLE=Filid-MVC
SITE_NOME=Filid-MVC
```
5. rode o comando para gerar as CRIP_KEY, CRIP_IV e CRIP_TAG<br>
<strong>Note:</strong> Usar o comando abaixo no terminal apenas uma vez para gerar as chaves de criptografia
```bash
php make env
```

## Configuração

### Banco de Dados Mysql
Edite o arquivo `.env` com suas credenciais de banco de dados:
```env
DB_HOST=localhost
DB_USER=root
DB_PASS=123456
DB_NAME=nome-do-banco
```

Rode o comando para gerar as CRIP_KEY, CRIP_IV e CRIP_TAG<br>
<strong>Note:</strong> Usar o comando abaixo no terminal apenas uma vez para gerar as chaves de criptografia
```bash
php make env
```

## Migrations

Crie suas tabelas na pasta Migrations.<br>
O nome do arquivo deve seguir o padrão: `{000}-Create{nome_da_tabela}Table.php`<br>
Exemplo: `001-CreateUsersTable.php`

Exemplo de Migration para criar a tabela users
```php
<?php

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->createTable('users', [
            '`id` INT AUTO_INCREMENT PRIMARY KEY',
            '`nome` VARCHAR(255) NOT NULL',
            '`email` VARCHAR(255) NOT NULL UNIQUE',
            '`senha_hash` VARCHAR(255) NOT NULL',
            '`status` ENUM("active", "inactive") NOT NULL DEFAULT "active"',
            '`role` ENUM("admin", "user") NOT NULL DEFAULT "user"',
            '`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            '`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ]);
        $this->addIndex('users', 'idx_user_email', 'email');
    }

    public function down()
    {
        $this->dropTable('users');
    }
}
```
### Funções disponíveis na classe Migration
function up()
```php
createTable - Cria tabela
ex: $this->createTable('users',[arrays de colunas]);

addIndex - Adiciona índices a tabela
ex: $this->addIndex('users', 'idx_user_email', 'email');

addPrimaryKey - Adiciona chave primária
ex: $this->addPrimaryKey('users', 'id');

addUniqueKey - Adiciona chave única
ex: $this->addUniqueKey('users', 'email');

addForeignKey - Adiciona chave estrangeira
ex: $this->addForeignKey('orders', 'fk_user_order', 'user_id', 'users', 'id', 'CASCADE', 'CASCADE');

modifyColumn - Modifica coluna
ex: $this->modifyColumn('users', 'email', 'VARCHAR(320) NOT NULL UNIQUE');

dropIndex - Remove índice
ex: $this->dropIndex('users', 'idx_user_email');
```

function down()
```php
dropTable - Remove tabela
ex: $this->dropTable('users');
```

### Configuração do Apache (.htaccess)
```apache
RewriteEngine On
Options All -Indexes

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]

# Protege arquivos sensíveis
<FilesMatch "^(\.env|autoload\.php|helpers\.php|migrate|make)$">
    Require all denied
</FilesMatch>

# Proteção contra injeção de SQL e XSS
<IfModule mod_rewrite.c>
    RewriteCond %{QUERY_STRING} (\<|%3C).*script.*(\>|%3E) [NC,OR]
    RewriteCond %{QUERY_STRING} UNION.*SELECT.* [NC]
    RewriteRule .* - [F,L]
</IfModule>

# Cabeçalhos de segurança
<IfModule mod_headers.c>
    Header always set X-Content-Type-Options "nosniff"
    Header always set X-Frame-Options "SAMEORIGIN"
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
    Header always set Permissions-Policy "geolocation=(), microphone=()"
</IfModule>

# Cache estático
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType text/css "access plus 1 year"
    ExpiresByType application/javascript "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/webp "access plus 1 year"
</IfModule>

ErrorDocument 403 https://github.com/aronisouza

```

## Uso

### Criando um Controller

No terminal digite:
```bash
php make controller UserController
```

Exemplo de código:
```php
<?php
class UserController extends Controller
{
    public function index()
    {
        // Lista todos os usuários
        $userModel = new UserModel();
        $this->render('/Controlador/Paginas/usuarios', ['users' => $userModel->getAllUsers()]);
    }

    public function create()
    {
        // Valida o token CSRF
        if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->setMensageAndRedirect(
                "Requisição inválida. Token CSRF inválido.",
                "/Controle/Usuario",
                "Erro de Segurança",
                "error"
            );
            return;
        }

        if (empty($_POST['name']) || empty($_POST['email'])) {
            $this->setMensageAndRedirect(
                "Todos os campos são obrigatórios.",
                "/Controle/Usuario",
                "Erro de Validação",
                "warning"
            );
            return;
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $this->setMensageAndRedirect(
                "Email inválido. Por favor, informe um email válido.",
                "/Controle/Usuario",
                "Erro de Validação",
                "warning"
            );
            return;
        }

        // Remove o campo csrf_token dos dados
        unset($_POST['csrf_token']);

        $_POST['password'] = fldCrip($_POST['password'], 0);
        $data = $_POST;

        $userModel = new UserModel();
        $result = $userModel->createUser($data);
        
        if ($result) {
            $this->setTostAndRedirect(
                "Usuário criado com sucesso!",
                "/Controle/Usuario"
            );
        } else {
            $this->setMensageAndRedirect(
                "Erro ao criar usuário. Por favor, tente novamente.",
                "/Controle/Usuario",
                "Erro no Sistema",
                "error"
            );
        }
    }
}
```

### Criando um Model

No terminal digite:
```bash
php make model UserModel
```

Exemplo de código:
```php
<?php
class UserModel
{
    public function getUserById($id){
        $read = new Read();
        $read->ExeRead('users', "WHERE id=:id", "id={$id}");
        return $read->getResult();
    }

    public function getAllUsers() {
        $read = new Read();
        $read->ExeRead('users');
        return $read->getResult();
    }
}
```

### Criando uma View

No terminal digite:
```bash
php make view NomeView Pasta/SubpastaOpcional
```

Exemplo de código:
```php
<section role="main" id="bem-vindo">
    <div class="my-3">
        Olá mundo, NomeView!!!
    </div>
</section>
```

### Definindo Rotas

Arquivo `configs/routes.php`:
```php
<?php
// Arquivo de configuração de rotas
// Caso Action for index, não precisa definir, por padrão já é index
return [
    // Rotas básicas do site
    ['GET', '/', 'HomeController'],

    //--- rotas de controle carregam view
    ['GET', '/Controle', 'ControladorController'],
    ['GET', '/Controle/Usuario', 'UserController'],
    ['GET', '/Controle/Usuario/Edit/{id}', 'UserController', 'edit'],

    //--- rotas de ação não carrega view
    ['POST', '/Usuario/create', 'UserController', 'create'], 
    ['POST', '/Usuario/Edit/{id}', 'UserController', 'update'],
    ['POST', '/Usuario/Delete/{id}', 'UserController', 'delete'],

    //--- rotas de login
    ['GET', '/login', 'LoginController'],
    ['POST', '/login/post', 'LoginController', 'login'],
    ['GET', '/logoff', 'LoginController', 'logoff'],
];
```

## Sistema de Mensagens

O framework inclui um sistema para envio de mensagens:
- Popup de Alerta de Sucesso, Erro e Aviso
- Popup de Confirmação antes de executar uma ação
- Toast de Alerta

### Exemplo em Controller

```php
// Mensagem modo popup
if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
    $this->setMensageAndRedirect(
        "Requisição inválida. Token inválido.",
        "/login",
        "Erro de Segurança"
    );
}

// Mensagem modo toast
$userModel = new UserModel();
if ($userModel->createUser($data)) {
    $this->setTostAndRedirect(
        "Usuário criado com sucesso!",
        "/Controle/Usuario"
    );
}

// Mensagem de confirmação javascript
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.form-excluir').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Confirmar exclusão',
                text: "Tem certeza que deseja excluir? Ao clicar em SIM não poderá retornar!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33000',
                cancelButtonColor: '#30d670ff',
                confirmButtonText: 'SIM',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Remove o event listener temporariamente para evitar loop
                    form.removeEventListener('submit', arguments.callee);
                    form.submit();
                }
            });
        });
    });
});
</script>
```

## Segurança

O framework inclui algumas medidas de segurança:
- Proteção contra CSRF
- Validação de dados
- Escape de saída HTML

### Exemplo de Proteção CSRF

```php
// No formulário
<form action="/Usuario/create" method="POST" enctype="multipart/form-data">
    <?= token(); ?>
    <!-- campos do formulário -->
</form>

// No controller
public function create()
{       
    // Valida o token CSRF
    if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
        $this->setMensageAndRedirect(
            "Requisição inválida. Token CSRF inválido.",
            "/Controle/Usuario",
            "Erro de Segurança",
            "error"
        );
        return;
    }

    // Restante do código
    {...}
}
```
