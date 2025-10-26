# Filid-MVC

Um framework PHP simples e eficiente para desenvolvimento web

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
cd MvcComPainelAdm
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
CRIP_KEY=7hf9f$5jh!xQ2@v4tzW3@E6kT$LH4jY0cF
CRIP_IV=9150918521046936
CRIP_TAG=Kdsfk32fSDF2
```

## Configuração

### Banco de Dados
Edite o arquivo `.env` com suas credenciais de banco de dados:
```env
DB_HOST=localhost
DB_USER=root
DB_PASS=123456
DB_NAME=nome-do-banco
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

No console digite:
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
        $users = $userModel->getAllUsers();
        $this->render('/Controlador/Paginas/usuarios', ['users' => $users]);
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

No console digite:
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
        $read->ExeRead('users', "WHERE id={$id}");
        return $read->getResult();
    }

    public function getAllUsers() {
        $read = new Read();
        $read->ExeRead('users');
        return $read->getResult();
    }
}
```

### Definindo Rotas

Arquivo `configs/routes.php`:
```php
<?php
// Arquivo de configuração de rotas
return [
    // Rotas básicas do site
    ['GET', '/', 'HomeController', 'index'],

    //--- rotas de controle carregam view
    ['GET', '/Controle', 'ControladorController', 'index'],
    ['GET', '/Controle/Usuario', 'UserController', 'index'],
    ['GET', '/Controle/Usuario/Edit/{id}', 'UserController', 'edit'],

    //--- rotas de ação não carrega view
    ['POST', '/Usuario/create', 'UserController', 'create'], 
    ['POST', '/Usuario/Edit/{id}', 'UserController', 'update'],
    ['POST', '/Usuario/Delete/{id}', 'UserController', 'delete'],

    //--- rotas de login
    ['GET', '/login', 'LoginController', 'index'],
    ['POST', '/login/post', 'LoginController', 'login'],
    ['GET', '/logoff', 'LoginController', 'logoff'],
];
```

## Sistema de Mensagens

O framework inclui um sistema para envio de mensagens:
- Popup de Alerta de Sucesso, Erro e Aviso
- Popup de Confirmação antes de executar uma ação
- Toast de Alerta

### Exemplo de Envio de Mensagens

```php
/**
** Exibe o alerta com mensagem customizada
*- Icones => success, error, warning, info, question
*- titulo => Titulo da janela
*- mensagem => Escreva a mensagem a ser exibida
*- icone => escolha um Icon acima
*- confirmButton => Texto do Botão
*/
function fldAlertaPersonalizado($titulo, $mensagem, $icone, $confirmButton)
{...}

/**
** Exibe o alerta TOAST com mensagem customizada
*- Icon => success, error, warning, info, question
*- mensagem => Escreva a mensagem a ser exibida
*- icone => escolha um Icon acima
*- posicao => top, top-start, top-end, center, center-start, center-end, bottom, bottom-start, bottom-end
*/
function fldToastAlert($mensagem, $icone, $posicao)
{...}
```

### Exemplo em Controller

```php
/**
* $icone => success, error, warning, info, question
*
* Define uma mensagem de erro e redireciona para a URL fornecida
* 
* @param string $mensagem Mensagem de erro
* @param string $redirectUrl URL para redirecionamento
* @param string $titulo Título do erro (opcional)
* @param string $icone Ícone do erro (opcional)
* @return void
*/
protected static function setMensageAndRedirect($mensagem, $redirectUrl, $titulo = 'Erro', $icone = 'error')
{
    $_SESSION['session_message'] = [
        'mensagem' => $mensagem,
        'titulo' => $titulo,
        'icone' => $icone
    ];
    header("Location: {$redirectUrl}");
    exit;
}

/**
* Define uma mensagem de sucesso e redireciona para a URL fornecida
* 
* @param string $mensagem Mensagem de sucesso
* @param string $redirectUrl URL para redirecionamento
* @param string $titulo Título da mensagem (opcional)
* @return void
*/
protected function setTostAndRedirect($mensagem, $redirectUrl, $titulo = 'Sucesso')
{
    $_SESSION['success_tost'] = [
        'mensagem' => $mensagem,
        'titulo' => $titulo
    ];
    header("Location: {$redirectUrl}");
    exit;
}
```

## Segurança

O framework inclui várias medidas de segurança:
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