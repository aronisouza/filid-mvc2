<?php

// make
// Uso: php make [tipo] [Nome] [extra?]
// Exemplos:
//   php make controller User
//   php make model User
//   php make view Home index

// Permite comandos que não precisam de segundo argumento (ex: env)
if ($argc < 2 || ($argc < 3 && strtolower($argv[1] ?? '') !== 'env')) {
    echo "Uso: php make [tipo] [Nome] [extra]\n";
    echo "Tipos disponíveis:\n";
    echo "  controller NomeController\n";
    echo "  model NomeModel\n";
    echo "  view Pasta NomeView\n";
    echo "  env (gera/atualiza CRIP_KEY, CRIP_IV, CRIP_TAG no .env)\n";
    exit(1);
}

$type = strtolower($argv[1]);
$name = $argv[2];
$extra = $argv[3] ?? null;

switch ($type) {
    case 'controller':
        createController($name);
        break;

    case 'model':
        createModel($name);
        break;

    case 'crud':
        createController($name);
        createModel($name);
        break;

    case 'view':
        createView($name, $extra);
        break;

    case 'env':
        // Gera/atualiza chaves no arquivo .env (CRIP_KEY, CRIP_IV, CRIP_TAG)
        generateEnv();
        break;

    default:
        echo "Tipo inválido. Use: controller, model ou crud.\n";
        break;
}

function createController($name)
{
    $dir = __DIR__ . '/Controllers/';
    $file = $dir . $name . 'Controller.php';

    if (file_exists($file)) {
        echo "Controller já existe: $file\n";
        return;
    }

    $content = <<<PHP
    <?php

    class {$name}Controller extends Controller
    {
    
        public function __construct()
        {
            \$this->checkSessionTimeout();
        }

        public function index()
        {
            \$this->render('{$name}');
        }
    }
    PHP;

    file_put_contents($file, $content);
    echo "Controller criado: $file\n";
}

function createModel($name)
{
    $dir = __DIR__ . '/Models/';
    $file = $dir . $name . 'Model.php';

    if (file_exists($file)) {
        echo "Model já existe: $file\n";
        return;
    }
    $table = strtolower($name);
    $content = <<<PHP
    <?php

    class {$name}Model
    {
        public function get{$name}ById(\$id){
            \$read = new Read();
            \$read->ExeRead('{$table}', "WHERE id = :id", "id={\$id}");
            return \$read->getResult();
        }

        public function getAll{$name}() {
            \$read = new Read();
            \$read->ExeRead('{$table}');
            return \$read->getResult();
        }

        public function create{$name}(\$data) {
            \$create = new Create();
            \$create->ExeCreate('{$table}', \$data);
            return \$create->getResult();
        }

        public function update{$name}(\$id, \$data) {
            \$update = new Update();
            \$update->ExeUpdate('{$table}', \$data, "WHERE id = :id", "id={\$id}");
            return \$update->getResult();
        }

        public function delete{$name}(\$id) {
            \$delete = new Delete();
            \$delete->ExeDelete('{$table}', "WHERE id = :id", "id={\$id}");
            return \$delete->getResult();
        }
    }
    PHP;

    file_put_contents($file, $content);
    echo "Model criado: $file\n";
}

function createView($name, $extra)
{
    if (!$extra) {
        echo "Uso para view: php make view NomeView Pasta/SubpastaOpcional\n";
        exit(1);
    }

    // $extra é o caminho relativo da subpasta, ex: Controlador/Usuarios
    $dir = __DIR__ . '/Views/' . $extra;

    // cria todas as pastas necessárias
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    // nome do arquivo final
    $file = $dir . '/' . $name . '.php';

    if (file_exists($file)) {
        echo "A view {$name} já existe em {$dir}\n";
        return;
    }

    if (!file_exists($file)) {
        $content = <<<PHP
        <section role="main" id="bem-vindo">
            <div class="my-3">
                Olá mundo, {$name}!!!
            </div>
        </section>
        PHP;
    }

    file_put_contents($file, $content);
    echo "View {$extra} criada em {$file}\n";
}

function generateEnv()
{
    $envFile = __DIR__ . '/.env';

    // cria backup se existir
    if (file_exists($envFile)) {
        $backup = $envFile . '.bak.' . date('YmdHis');
        if (!copy($envFile, $backup)) {
            echo "Falha ao criar backup do .env em $backup\n";
            return;
        }
        echo "Backup criado: $backup\n";
        $content = file_get_contents($envFile);
    } else {
        $content = '';
    }

    // Geradores de valores
    $key = generateRandomString(48); // CRIP_KEY
    $iv = generateNumericString(16); // CRIP_IV (16 dígitos)
    $tag = generateRandomString(8, false); // CRIP_TAG

    $replacements = [
        'CRIP_KEY' => $key,
        'CRIP_IV' => $iv,
        'CRIP_TAG' => $tag,
    ];

    foreach ($replacements as $k => $v) {
        if (preg_match('/^' . preg_quote($k, '/') . '=/m', $content)) {
            $content = preg_replace('/^' . preg_quote($k, '/') . '=.*$/m', $k . '=' . $v, $content);
        } else {
            $content .= ($content === '' ? '' : PHP_EOL) . $k . '=' . $v;
        }
    }

    // garante quebra de linha final
    $content = rtrim($content, "\n") . "\n";

    if (file_put_contents($envFile, $content) === false) {
        echo "Erro ao escrever em $envFile\n";
        return;
    }

    echo ".env atualizado: $envFile\n";
    echo "CRIP_KEY=$key\nCRIP_IV=$iv\nCRIP_TAG=$tag\n";
}

function generateRandomString($length = 32, $useSymbols = true)
{
    $alpha = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $symbols = '!@#$%^&*-_=+?,.';
    $chars = $alpha . ($useSymbols ? $symbols : '');
    $max = strlen($chars) - 1;
    $str = '';
    for ($i = 0; $i < $length; $i++) {
        $str .= $chars[random_int(0, $max)];
    }
    return $str;
}

function generateNumericString($length = 16)
{
    $str = '';
    for ($i = 0; $i < $length; $i++) {
        $str .= (string) random_int(0, 9);
    }
    return $str;
}

