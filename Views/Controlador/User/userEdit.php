<section role="main" class="container-md mb-3">
    <div class="d-flex align-items-center p-3 text-white-50 gradient-bg rounded box-shadow">
        <img class="mr-5" src="/Public/Images/logo.png" alt="AS Logo" width="50" height="50">
        <div class="lh-100 ms-5">
            <h6 class="mb-3 text-white lh-100 CormorantInfant fs-5">EDIÇÃO</h6>
            <p>Use o formuláio abaixo para Editar [<?= htmlspecialchars($user[0]['nome']); ?>]</p>
        </div>
    </div>
</section>

<section class="container-md mb-3" id="Formulario">
    <form action="/Usuario/Edit/<?= fldCrip($user[0]['id'], 0); ?>" method="POST" class="form" enctype="multipart/form-data">
        <?= token(); ?>

        <div class="row mt-3">
            <div class="col-6">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?= $user[0]['nome']; ?>">
            </div>
            <div class="col-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $user[0]['email']; ?>">
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-4">
                <label for="status" class="form-label">Status</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="status1" value="active" <?= $user[0]['status'] == 'active' ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="status1">
                        Ativo
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="status2" value="inactive" <?= $user[0]['status'] == 'inactive' ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="status2">
                        Inativo
                    </label>
                </div>
            </div>
            <div class="col-4">
                <label for="role" class="form-label">Regra</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="role" id="role1" value="admin" <?= $user[0]['role'] == 'admin' ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="role1">
                        Admin
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="role" id="role2" value="user" <?= $user[0]['role'] == 'user' ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="role2">
                        Usuário
                    </label>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-outline-primary">Salvar</button>
    </form>
</section>