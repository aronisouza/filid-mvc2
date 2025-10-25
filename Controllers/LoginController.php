<?php

class LoginController extends Controller
{
    public function index()
    {
        $this->render('Controlador/Login');
    }

    public function login()
    {
        if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->setErrorAndRedirect(
                "Requisição inválida. Token inválido.",
                "/login",
                "Erro de Segurança"
            );
        }
        $r = new LoginModel();
        $user = $r->login($_POST['email'], $_POST['senha_hash']);
        if (empty($user)) :
            $this->setErrorAndRedirect(
                "Login ou Senha Errados.",
                "/login",
                "Erro de autenticação",
                "error"
            );
        else:
            $_SESSION['status'] = $user[0]['status'];
            $_SESSION['name'] = $user[0]['nome'];
            $_SESSION['role'] = $user[0]['role'];
            $_SESSION['email'] = $user[0]['email'];
            $_SESSION['data_inicio'] = (new DateTime('first day of this month'))->format('Y-m-d');
            $_SESSION['data_final'] = (new DateTime('first day of next month'))->format('Y-m-d');
            $_SESSION['created'] = fldCrip($user[0]['id'], 0);
            $_SESSION['last_activity'] = time();
            $_SESSION['base-view'] = 'Controlador';
            $this->setSuccessAndRedirect(
                "Logado com sucesso!",
                "/Controle",
                "LOGIN"
            );
        endif;
    }

    public function logout()
    {
        $_SESSION['status'] = null;
        $_SESSION['name'] = null;
        $_SESSION['role'] = null;
        $_SESSION['email'] = null;
        $_SESSION['data_inicio'] = null;
        $_SESSION['data_final'] = null;
        $_SESSION['created'] = null;
        $_SESSION['last_activity'] = null;
        $_SESSION['base-view'] = 'Site';
        session_destroy();
        $this->render('Controlador/Login');
    }
}
