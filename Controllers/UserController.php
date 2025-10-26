<?php

class UserController extends Controller
{
    public function __construct()
    {
        $this->checkSessionTimeout();
    }

    public function index()
    {
        $userModel = new UserModel();
        $users = $userModel->getAllUsers();
        $this->render('Controlador/User/usuarios', ['users' => $users, "pagina" => "Usuario"]);
    }

    public function create()
    {
        if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->setMensageAndRedirect(
                "Requisição inválida. Token CSRF inválido.",
                "/Controle/Usuario",
                "Erro de Segurança",
                "error"
            );
        }

        if (empty($_POST['nome']) || empty($_POST['email']) || empty($_POST['senha_hash'])) {
            $this->setMensageAndRedirect(
                "Nome, email e Senha são obrigatórios.",
                "/Controle/Usuario",
                "Erro de Validação",
                "warning"
            );
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $this->setMensageAndRedirect(
                "Email inválido. Por favor, informe um email válido.",
                "/Controle/Usuario",
                "Erro de Validação",
                "warning"
            );
        }

        // Remove o campo csrf_token dos dados
        unset($_POST['csrf_token']);

        $_POST['senha_hash'] = fldCrip($_POST['senha_hash'], 0);
        $data = $_POST;

        $userModel = new UserModel();
        if ($userModel->createUser($data)) {
            $this->setTostAndRedirect(
                "Usuário criado com sucesso!",
                "/Controle/Usuario"
            );
        }
        $this->setMensageAndRedirect(
            "Erro ao criar usuário. Por favor, tente novamente.",
            "/Controle/Usuario",
            "Erro no Sistema",
            "error"
        );
    }

    public function edit($idg)
    {
        $id = fldCrip($idg, 1);
        $userModel = new UserModel();
        $user = $userModel->getUserById($id);
        if (!$user) {
            http_response_code(404);
            $this->setMensageAndRedirect(
                "Usuário não encontrado.",
                "/Controle/Usuario",
                "Erro de Validação",
                "error"
            );
        }
        // Passa o usuário para a view
        $this->render('Controlador/User/userEdit', ['user' => $user, "pagina" => "Usuario"]);
    }

    public function update($idg)
    {
        if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            http_response_code(403);
            $this->setMensageAndRedirect(
                "Requisição inválida. Token CSRF inválido.",
                "/Controle/Usuario",
                "Erro de Segurança",
                "error"
            );
        }
        if (empty($_POST['nome']) || empty($_POST['email'])) {
            http_response_code(400);
            $this->setMensageAndRedirect(
                "Todos os campos são obrigatórios.",
                "/Controle/Usuario",
                "Erro de Validação",
                "error"
            );
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            $this->setMensageAndRedirect(
                "Email inválido.",
                "/Controle/Usuario",
                "Erro de Validação",
                "error"
            );
        }
        // Remove o campo csrf_token dos dados
        unset($_POST['csrf_token']);
        $id = fldCrip($idg, 1);
        // Atualiza um usuário no banco de dados
        $data = $_POST;
        $userModel = new UserModel();
        if ($userModel->updateUser($id, $data)) {
            $this->setTostAndRedirect(
                "Usuário atualizado com sucesso!",
                "/Controle/Usuario"
            );
        }
        $this->setMensageAndRedirect(
            "Erro ao atualizar usuário. Por favor, tente novamente.",
            "/Controle/Usuario",
            "Erro no Sistema",
            "error"
        );
    }

    public function delete($idg)
    {
        $id = fldCrip($idg, 1);
        $userModel = new UserModel();
        if ($userModel->deleteUser($id)) {
            $this->setTostAndRedirect(
                "Usuário excluído com sucesso!",
                "/Controle/Usuario"
            );
        }
        $this->setMensageAndRedirect(
            "Erro ao excluir usuário. Por favor, tente novamente.",
            "/Controle/Usuario",
            "Erro no Sistema",
            "error"
        );
    }
}
