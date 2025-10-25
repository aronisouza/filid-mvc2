<?php

// make
// Uso: php make [tipo] [Nome] [extra?]
// Exemplos:
//   php make controller User
//   php make model User
//   php make view Home index

if ($argc < 3) {
    echo "Uso: php make [tipo] [Nome] [extra]\n";
    echo "Tipos disponíveis:\n";
    echo "  controller NomeController\n";
    echo "  model NomeModel\n";
    echo "  view Pasta NomeView\n";
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
        echo "Uso para view: php make.php view NomeView Pasta/SubpastaOpcional\n";
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
        <section id="bem-vindo">
            <div class="my-3">
                Olá mundo, {$name}!!!
            </div>
        </section>
        PHP;
    }

    file_put_contents($file, $content);
    echo "View {$extra} criada em {$file}\n";
}
