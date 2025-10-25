<style>
    body {
        font-family: Arial, sans-serif;
        display: flex;
        /* Para centralizar o conteúdo */
        justify-content: center;
        /* Centraliza horizontalmente */
        align-items: center;
        /* Centraliza verticalmente */
        min-height: 100vh;
        /* Ocupa a altura total da viewport */
        margin: 0;
        background-color: #f0f2f5;
        /* Um fundo suave */
    }

    .login-container {
        background-color: #fff;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
        /* Largura máxima para o formulário */
        text-align: center;
    }

    h2 {
        margin-bottom: 25px;
        color: #333;
    }

    .input-group {
        margin-bottom: 20px;
        text-align: left;
    }

    .input-group label {
        display: block;
        margin-bottom: 8px;
        color: #555;
        font-weight: bold;
    }

    .input-group input[type="text"],
    .input-group input[type="password"] {
        width: calc(100% - 20px);
        /* Ajusta para padding */
        padding: 12px 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
    }

    button[type="submit"] {
        width: 100%;
        padding: 12px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 18px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 15px;
    }

    button[type="submit"]:hover {
        background-color: #0056b3;
    }

    .forgot-password,
    .signup-link {
        margin-top: 20px;
        font-size: 14px;
    }

    .forgot-password a,
    .signup-link a {
        color: #007bff;
        text-decoration: none;
    }

    .forgot-password a:hover,
    .signup-link a:hover {
        text-decoration: underline;
    }
</style>

<div class="login-container">
    <h2>Login</h2>
    <form class="login-form" action="/login/post" method="POST">
        <?= token(); ?>
        <div class="input-group">
            <label for="email">Email address</label>
            <input type="text" id="email" name="email" required>
        </div>
        <div class="input-group">
            <label for="senha_hash">Senha</label>
            <input type="password" id="senha_hash" name="senha_hash" required>
        </div>
        <button type="submit">Entrar</button>
    </form>
</div>