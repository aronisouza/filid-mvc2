<?php

session_start();

// Configuração do manipulador de exceções
set_exception_handler(function ($exception) {
    logError($exception->getMessage() . ' in ' . $exception->getFile() . ' on line ' . $exception->getLine());

    // Redireciona para a página inicial ou exibe um erro
    if (!headers_sent()) {
        header('Location: /');
    } else {
        echo "Erro inesperado: " . $exception->getMessage();
    }
    exit;
});

// Configuração do manipulador de erros
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    if (!(error_reporting() & $errno)) {
        // Este código de erro não está incluído na configuração de error_reporting
        return false;
    }

    logError("Erro [$errno] $errstr em $errfile:$errline");

    if (in_array($errno, [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR])) {
       
        if (!headers_sent()) {
            header('Location: /');
        } else {
            echo "Erro crítico: $errstr";
        }
        exit(1);
    }

    return true;
});

header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");

require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/helpers.php';

loadEnv();

$router = new Router();

// Carrega as rotas do arquivo de configuração
$routes = require_once __DIR__ . '/Configs/routes.php';

// Registra as rotas
foreach ($routes as $route) {
    $router->addRoute($route[0], $route[1], $route[2], $route[3] ?? 'index');
}

$router->dispatch();
