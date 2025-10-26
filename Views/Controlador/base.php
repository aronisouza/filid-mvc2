<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= getenv('SITE_TITLE'); ?></title>
    <link rel="icon" href="<?= fld_url('Public/Images/logo.png') ?>" sizes="32x32">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= fld_url('Public/Css/bootstrap.css') ?>">
    <link rel="stylesheet" href="<?= fld_url('Public/Css/fldcontrol.css') ?>">
    <link rel="stylesheet" href="<?= fld_url('Public/Css/animacoes.css') ?>">

    <style>
        @media(min-width: 720px) {
            body {
                min-height: 100dvh;
                color: var(--text-clr);
                display: grid;
                grid-template-columns: auto 1fr;
            }
        }

        @media(max-width: 680px) {
            body {
                grid-template-columns: auto 0;
            }
        }
    </style>

    <script src="<?= fld_url('Public/Js/jquery-3.6.4.min.js') ?>"></script>
    <script src="<?= fld_url('Public/Js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= fld_url('Public/Js/sweetalert2.js') ?>"></script>
    <script src="<?= fld_url('Public/Js/Chartjs-v4.4.7.js') ?>"></script>
    <script src="<?= fld_url('Public/Js/alertas.js') ?>"></script>
    <script type="text/javascript" src="<?= fld_url('Public/Js/fldcontrol.js') ?>" defer></script>
</head>

<body>
    <?php fldPopupMessage();
    fldTostMessage(); ?>

    <nav id="sidebar">
        <ul>
            <li class="mt-3">
                <?= fldIco("taunt", 50, "text-white"); ?><span class="logo">FLD Control</span>
                <button onclick=toggleSidebar() id="toggle-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                        <path d="m313-480 155 156q11 11 11.5 27.5T468-268q-11 11-28 11t-28-11L228-452q-6-6-8.5-13t-2.5-15q0-8 2.5-15t8.5-13l184-184q11-11 27.5-11.5T468-692q11 11 11 28t-11 28L313-480Zm264 0 155 156q11 11 11.5 27.5T732-268q-11 11-28 11t-28-11L492-452q-6-6-8.5-13t-2.5-15q0-8 2.5-15t8.5-13l184-184q11-11 27.5-11.5T732-692q11 11 11 28t-11 28L577-480Z" />
                    </svg>
                </button>
            </li>

            <li class="seting-section <?= $pagina == 'Controle' ? 'active' : '' ?>">
                <a href="/Controle">
                    <?= fldIco("dashboard", 30); ?>
                    <span class="hide-on-collapse">Dashboard</span>
                </a>
            </li>

            <li class="<?= $pagina == 'Site' ? 'active' : '' ?>">
                <a href="/">
                    <?= fldIco("home", 30); ?>
                    <span class="hide-on-collapse">Site</span>
                </a>
            </li>

            <?php
            //- Menu para Admin
            if ($_SESSION['role'] == "admin"): ?>
                <li class="seting-section <?= $pagina == 'Usuario' ? 'active' : '' ?>">
                    <span class="hide-on-collapse ms-5 text-info">ADMIN</span>
                    <a href="/Controle/Usuario">
                        <?= fldIco("user_attributes", 27); ?>
                        <span class="hide-on-collapse">Usuáios</span>
                    </a>
                </li>
            <?php endif; ?>
            
            <li class="seting-section ">
                <a href="/Logout">
                    <?= fldIco("power_off", 27, "fld-red"); ?>
                    <span class="hide-on-collapse CormorantInfant">SAIR</span>
                </a>
            </li>

        </ul>
    </nav>

    <main class="container pb-5">
        <?php require_once $content; ?>
    </main>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.form-excluir').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Confirmar exclusão',
                        text: "Tem certeza que deseja excluir? Ao clicar em SIM não poderá retornar!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33000',
                        cancelButtonColor: '#30d670ff',
                        confirmButtonText: 'SIM',
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
</body>

</html>