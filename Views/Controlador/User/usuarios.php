<section role="main" class="container-md mb-3">
    <div class="d-flex align-items-center p-3 text-white-50 gradient-bg rounded box-shadow">
        <img class="mr-5" src="/Public/Images/logo.png" alt="AS Logo" width="50" height="50">
        <div class="lh-100 ms-5">
            <h6 class="mb-3 text-white lh-100 CormorantInfant fs-5">Usuários</h6>
            <p>Use o formuláio abaixo para cadastrar um novo usuário</p>
        </div>
    </div>
</section>

<section class="container-md mb-3" id="Formulario">
    <form action="/Usuario/create" method="POST" class="" enctype="multipart/form-data">
        <?= token(); ?>
        <div class="row mt-3">
            <div class="col-12 col-md-4">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome">
            </div>
            <div class="col-12 col-md-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>

            <div class="col-12 col-md-4">
                <label for="senha_hash" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha_hash" name="senha_hash">
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-6">
                <label for="status" class="form-label">Status</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="status1" value="active" checked>
                    <label class="form-check-label" for="status1">
                        Ativo
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="status2" value="inactive">
                    <label class="form-check-label" for="status2">
                        Inativo
                    </label>
                </div>
            </div>
            <div class="col-6">
                <label for="role" class="form-label">Regra</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="role" id="role1" value="admin" checked>
                    <label class="form-check-label" for="role1">
                        Admin
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="role" id="role2" value="user">
                    <label class="form-check-label" for="role2">
                        Usuário
                    </label>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-outline-primary">Salvar</button>
    </form>
</section>

<section id="Tabela" class="container-md mb-5">
    <?php foreach ($users as $user): ?>
        <div class="container-md mb-1">
            <div class="row border-success rounded bg-light p-3">
                <div class="col d-flex justify-content-start">
                    <?= htmlspecialchars($user['nome']); ?>
                </div>
                <div class="col d-flex justify-content-end">
                    <?= htmlspecialchars($user['email']); ?>
                </div>
                <div class="col d-flex justify-content-end <?= $user['status'] == 'active' ? 'text-success' : 'text-danger'; ?>">
                    <?= htmlspecialchars($user['status']); ?>
                </div>
                <div class="col d-flex justify-content-end">
                    <?= htmlspecialchars($user['role']); ?>
                </div>
                <div class="col d-flex justify-content-end gap-2">
                    <form class="form-excluir" action="/Usuario/Delete/<?= fldCrip($user['id'], 0); ?>" method="POST">
                        <?= token(); ?>
                        <button type="submit" class="btn btn-danger btn-sm"><?= fldIco('delete_forever', 20) ?></button>
                    </form>
                    <a class="btn btn-info btn-sm d-inline-flex align-items-center justify-content-center gap-2" href="/Controle/Usuario/Edit/<?= fldCrip($user['id'], 0); ?>" role="button" id="edit"><?= fldIco('edit_arrow_up', 20) ?></a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</section>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.form-excluir').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Confirmar exclusão',
                    text: "Tem certeza que deseja excluir este usuário?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sim, excluir!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Remove o event listener temporariamente para evitar loop
                        form.removeEventListener('submit', arguments.callee);
                        form.submit();
                    }
                });
            });
        });
    });
</script>
