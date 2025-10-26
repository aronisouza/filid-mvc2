<?php

class Controller
{
    protected function render(string $view, array $data = []): void
    {
        // Extrai os dados para variáveis locais (sem sobrescrever variáveis internas)
        if (!empty($data)) {
            extract($data, EXTR_SKIP);
        }

        // Caminho completo da view
        $viewPath = __DIR__ . "/../Views/{$view}.php";

        // Se a view não existir, renderiza a página de erro
        if (!file_exists($viewPath)) {
            require_once __DIR__ . '/../Views/errors/404.php';
            return;
        }

        // Define qual layout base será usado
        $baseView = $_SESSION['base-view'] ?? 'Site';

        // Define a view que será injetada no layout
        $content = $viewPath;

        // Caminho do layout conforme o tipo de base
        if ($baseView === 'Controlador') {
            $layoutPath = __DIR__ . '/../Views/Controlador/base.php';
        } else {
            $layoutPath = __DIR__ . '/../Views/base.php';
        }

        // Carrega o layout correspondente
        require_once $layoutPath;
    }

    protected function validateCsrfToken($token)
    {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    /**
     * 
     * Define uma mensagem de erro e redireciona para a URL fornecida
     * 
     * $icone => success, error, warning, info, question
     * @param string $mensagem Mensagem de erro
     * @param string $redirectUrl URL para redirecionamento
     * @param string $titulo Título do erro (opcional)
     * @param string $icone Ícone do erro (opcional)
     * @return void
     * 
     *
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
     * 
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

    protected function checkSessionTimeout()
    {
        if (isset($_SESSION['last_activity'])) {
            if ((time() - $_SESSION['last_activity']) > SESSION_TIMEOUT) {
                // tempo expirado → destruir sessão
                $_SESSION['status'] = null;
                $_SESSION['name'] = null;
                $_SESSION['email'] = null;
                $_SESSION['role'] = null;
                session_unset();
                session_destroy();

                // redirecionar para login
                $this->setMensageAndRedirect(
                    "Sua sessão expirou por inatividade. Faça login novamente.",
                    "/login",
                    "Erro de Segurança"
                );
            }
        }

        if (!isset($_SESSION['role'])) {
            $_SESSION['status'] = null;
            $_SESSION['name'] = null;
            $_SESSION['email'] = null;
            $_SESSION['role'] = null;
            session_unset();
            session_destroy();
            $this->setMensageAndRedirect(
                "Requisição inválida. Visitante enviado para Home do Site.",
                "/",
                "Erro de Segurança"
            );
        }

        // atualizar timestamp
        $_SESSION['last_activity'] = time();
    }
}
