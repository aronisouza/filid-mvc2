<header class="py-5 text-center gradient-bg-2 container-fluid texto-sombra">
  <p class="display-4 fw-bold h2">Filid-MVC</p>
  <p class="lead">Um framework PHP simples e eficiente para desenvolvimento web</p>
  <div class="mt-4">
    <a href="#instalacao" class="btn btn-primary btn-lg px-4 me-2 animate-bounce delay-2s">Começar</a>
    <a href="https://github.com/aronisouza/MvcComPainelAdm" class="btn btn-outline-light btn-lg px-4"
      target="_blank">
      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
        <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8" />
      </svg> GitHub
    </a>
  </div>
  <!-- Features -->
  <section class="row g-4 py-5">
    <div class="col-md-4">
      <div class="feature-icon text-center">
        <?= fldIco("stacks", 50, "text-dark"); ?>
      </div>
      <h3 class="text-center">Padrão MVC</h3>
      <p class="text-center">
        Estrutura organizada seguindo o padrão Model-View-Controller para separação clara de responsabilidades.</p>
    </div>
    <div class="col-md-4">
      <div class="feature-icon text-center">
        <?= fldIco("shield_lock", 50, "text-dark"); ?>
      </div>
      <h3 class="text-center">Segurança</h3>
      <p class="text-center">Proteção CSRF, headers de segurança e validação de dados para aplicações mais seguras.</p>
    </div>
    <div class="col-md-4">
      <div class="feature-icon text-center">
        <?= fldIco("electric_bolt", 50, "text-dark"); ?>
      </div>
      <h3 class="text-center">Rápido</h3>
      <p class="text-center">Leve e otimizado para desempenho, com autoload de classes e sistema de rotas eficiente.</p>
    </div>
  </section>
</header>

<div class="container py-4">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-3">
      <div class="" style="position: sticky; top: 20px;">
        <nav class="nav flex-column nav-pills" id="sidebarNav">
          <a class="nav-link active" href="#visao-geral">Visão Geral</a>
          <a class="nav-link" href="#estrutura">Estrutura do Projeto</a>
          <a class="nav-link" href="#requisitos">Requisitos</a>
          <a class="nav-link" href="#instalacao">Instalação</a>
          <a class="nav-link" href="#configuracao">Configuração</a>
          <a class="nav-link" href="#uso">Uso</a>
          <a class="nav-link" href="#mensagem">Envio de Mensagens</a>
          <a class="nav-link" href="#seguranca">Segurança</a>
        </nav>
        <a class="btn btn-link text-decoration-none animate-pulse-slow" href="animate.html">Animações</a>
      </div>
    </div>

    <!-- Main Content -->
    <div class="col-md-9">
      <!-- Visão Geral -->
      <section id="visao-geral" class="py-3">
        <h2 class="border-bottom border-dark pb-2">Visão Geral</h2>
        <p>O Filid-MVC é um framework que implementa o padrão MVC, dividindo a aplicação em três camadas
          principais:</p>
        <ul class="ms-3">
          <li><strong>Model</strong>: Responsável pela lógica de negócios e interação com o banco de dados
          </li>
          <li><strong>View</strong>: Interface do usuário, onde os dados são exibidos</li>
          <li><strong>Controller</strong>: Gerencia as requisições entre a View e o Model</li>
        </ul>
      </section>

      <!-- Estrutura do Projeto -->
      <section id="estrutura" class="py-3">
        <h2 class="border-bottom border-dark pb-2">Estrutura do Projeto</h2>
        <div class="card mb-4">
          <div class="card-body">
            <pre class="mb-0">
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
            </pre>
          </div>
        </div>
      </section>

      <!-- Requisitos -->
      <section id="requisitos" class="py-3">
        <h2 class="border-bottom border-dark pb-2">Requisitos</h2>
        <ul class="list-group mb-4">
          <li class="list-group-item">PHP 7.4 ou superior</li>
          <li class="list-group-item">MySQL 5.7 ou superior</li>
          <li class="list-group-item">Apache/Nginx</li>
          <li class="list-group-item">mod_rewrite habilitado (Apache)</li>
        </ul>
      </section>

      <!-- Instalação -->
      <section id="instalacao" class="py-3">
        <h2 class="border-bottom border-dark pb-2">Instalação</h2>
        <div class="card mb-4">
          <div class="card-body">
            <h5 class="card-title">1. Clone o repositório</h5>
            <pre class="mb-3"><code>  git clone https://github.com/aronisouza/filid-mvc2.git
  cd MvcComPainelAdm</code></pre>
            <h5 class="card-title">2. Configure seu servidor web</h5>
            <p class="card-text">Apache/Nginx para apontar para a pasta do projeto</p>

            <h5 class="card-title">3. Copie o arquivo de ambiente</h5>
            <pre class="mb-3"><code>cp .env-copy .env</code></pre>

            <h5 class="card-title">4. Configure as variáveis de ambiente</h5>
            <pre><code>  DB_HOST=localhost
  DB_USER=root
  DB_PASS=123456
  DB_NAME=nome-do-banco
  SITE_URL=http://seu-site.com
  SITE_TITLE=Filid-MVC
  SITE_NOME=Filid-MVC
  CRIP_KEY=7hf9f$5jh!xQ2@v4tzW3@E6kT$LH4jY0cF
  CRIP_IV=9150918521046936
  CRIP_TAG=Kdsfk32fSDF2</code></pre>
          </div>
        </div>
      </section>

      <!-- Configuração -->
      <section id="configuracao" class="py-3">
        <h2 class="border-bottom border-dark pb-2">Configuração</h2>
        <h4>Banco de Dados</h4>
        <p>Edite o arquivo <code>.env</code> com suas credenciais de banco de dados:</p>
        <pre><code>  DB_HOST=localhost
  DB_USER=root
  DB_PASS=123456
  DB_NAME=nome-do-banco
</code></pre>
        <h4 class="mt-4">Configuração do Apache (.htaccess)</h4>
        <pre>
          <code>RewriteEngine On
  Options -Indexes

  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]

  ErrorDocument 403 https://github.com/aronisouza

  &lt;FilesMatch "^(\.env|autoload\.php)$"&gt;
      Order allow,deny
      Deny from all
  &lt;/FilesMatch&gt;
          </code>
        </pre>
      </section>

      <!-- Uso -->
      <section id="uso" class="py-1">
        <h2 class="border-bottom border-dark pb-2">Uso</h2>

        <h4>Criando um Controller</h4>
        <pre>No console digite
php make controller UserController</pre>
        <pre><code>&lt;?php
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
        $this->setErrorAndRedirect(
          "Requisição inválida. Token CSRF inválido.",
          "/Controle/Usuario",
          "Erro de Segurança",
          "error"
        );
        return;
      }

      if (empty($_POST['name']) || empty($_POST['email'])) {
        $this->setErrorAndRedirect(
          "Todos os campos são obrigatórios.",
          "/Controle/Usuario",
          "Erro de Validação",
          "warning"
        );
        return;
      }

      if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $this->setErrorAndRedirect(
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
        $this->setSuccessAndRedirect(
          "Usuário criado com sucesso!",
          "/Controle/Usuario"
        );
      } else {
        $this->setErrorAndRedirect(
          "Erro ao criar usuário. Por favor, tente novamente.",
          "/Controle/Usuario",
          "Erro no Sistema",
          "error"
        );
      }
    }

    public function edit($idg)
    {...}

    public function update($idg)
    {...}

    public function delete($idg)
    {...}
  }</code></pre>

        <h4 class="mt-4">Criando um Model</h4>
        <pre>No console digite
php make model UserModel</pre>
        <pre>
        <pre><code>&lt;?php
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

    public function createUser($data) {...}

    public function updateUser($id, $data) {...}

    public function deleteUser($id) {...}
  }</code></pre>

        <h4 class="mt-1">Definindo Rotas</h4>
        <p>Arquivo configs/routes.php:</p>
        <pre><code>&lt;?php

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
  ];</code></pre>
      </section>

      <!-- Mensagem -->
      <section id="mensagem" class="py-1">
        <h2 class="border-bottom border-dark pb-2">Envio de Mensagens</h2>
        <p>O framework inclui um sistema para envio de mensagens:</p>
        <ul class="ms-3">
          <li>Popup de Alerta de Sucesso, Erro e Aviso</li>
          <li>Popup de Confirmação antes de executar uma ação</li>
          <li>Toast de Alerta</li>
        </ul>

        <h4 class="mt-4">Exemplo de Envio de Mensagens</h4>
        <pre><code>  /**
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
  {...}</code></pre>
        <h4 class="mt-4">Exemplo em controller</h4>
        <pre><code>  /**
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
  protected static function setErrorAndRedirect($mensagem, $redirectUrl, $titulo = 'Erro', $icone = 'error') {
      setErrorMessage($mensagem, $titulo, $icone);
      header("Location: {$redirectUrl}");
      exit;
  }
  //-- Exemplo de uso
  $this->setErrorAndRedirect(
      "Requisição inválida. Token inválido.",
      "/login",
      "Erro de Segurança"
  );
  

  /**
  * Define uma mensagem de sucesso e redireciona para a URL fornecida
  * 
  * @param string $mensagem Mensagem de sucesso
  * @param string $redirectUrl URL para redirecionamento
  * @param string $titulo Título da mensagem (opcional)
  * @return void
  */
  protected function setSuccessAndRedirect($mensagem, $redirectUrl, $titulo = 'Sucesso') {
      setSuccessMessage($mensagem, $titulo);
      header("Location: {$redirectUrl}");
      exit;
  }
  //-- Exemplo de uso
  $this->setSuccessAndRedirect(
      "Logado com sucesso!",
      "/Controle",
      "LOGIN"
  );</code></pre>
      </section>

      <!-- Segurança -->
      <section id="seguranca" class="py-1">
        <h2 class="border-bottom border-dark pb-2">Segurança</h2>
        <p>O framework inclui algumas medidas de segurança:</p>
        <ul>
          <li>Proteção contra CSRF</li>
          <li>Validação de dados</li>
          <li>Escape de saída HTML</li>
        </ul>

        <h4 class="mt-4">Exemplo de Proteção CSRF</h4>
        <pre>
          <code>
  // No formulário
  &lt;form action="/Usuario/create" method="POST" enctype="multipart/form-data"&gt;
      &lt;?= token(); ?&gt;
      &lt;!-- campos do formulário --&gt;
  &lt;/form&gt;

  // No controller
  public function create()
  {       
    // Valida o token CSRF
    if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
      $this->setErrorAndRedirect(
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
          </code>
        </pre>
      </section>

    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('#sidebarNav .nav-link');

    // Função para atualizar o link ativo
    function setActiveLink() {
      const scrollPosition = window.scrollY + 100;

      // Verificar cada seção
      document.querySelectorAll('section').forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        const sectionId = section.getAttribute('id');

        if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
          navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${sectionId}`) {
              link.classList.add('active');
            }
          });
        }
      });
    }

    // Atualizar ao carregar a página
    setActiveLink();

    // Atualizar ao rolar
    window.addEventListener('scroll', setActiveLink);

    // Atualizar ao clicar nos links (para navegação suave)
    navLinks.forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();

        // Remover classe active de todos os links
        navLinks.forEach(item => item.classList.remove('active'));

        // Adicionar classe active ao link clicado
        this.classList.add('active');

        // Rolagem suave para a seção
        const targetId = this.getAttribute('href');
        const targetSection = document.querySelector(targetId);
        window.scrollTo({
          top: targetSection.offsetTop - 80,
          behavior: 'smooth'
        });
      });
    });
  });
</script>