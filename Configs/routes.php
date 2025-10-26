<?php

// Arquivo de configuração de rotas
return [
    // Rotas básicas do site
    ['GET', '/', 'HomeController'],

    //--- rotas de login
    ['GET', '/login', 'LoginController'],
    ['POST', '/login/post', 'LoginController', 'login'],
    ['GET', '/Logout', 'LoginController', 'logout'],

    //--- ROTAS DE USUÁRIO
    //--- rotas de controle carregam view
    ['GET', '/Controle', 'ControladorController'],
    ['GET', '/Controle/Usuario', 'UserController'],
    ['GET', '/Controle/Usuario/Edit/{id}', 'UserController', 'edit'],
    //--- rotas de ação não carrega view
    ['POST', '/Usuario/create', 'UserController', 'create'],
    ['POST', '/Usuario/Edit/{id}', 'UserController', 'update'],
    ['POST', '/Usuario/Delete/{id}', 'UserController', 'delete'],
];
