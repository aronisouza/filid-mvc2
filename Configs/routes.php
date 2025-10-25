<?php

// Arquivo de configuração de rotas
return [
    // Rotas básicas do site
    ['GET', '/', 'HomeController', 'index'],
    ['GET', '/Sobre', 'SobreController', 'index'],

    //--- ROTAS DE CONTROLE
    //--- LISTA DE COMPRA
    ['GET', '/listas', 'ListaController', 'index'],
    ['POST', '/listas-entredatas', 'ListaController', 'entredatas'],
    ['GET', '/listas/produtos/{id}', 'ListaController', 'produtos'],
    ['GET', '/listas/usar/{id}', 'ListaController', 'usarLista'],

    //--- COMPARTILHAR
    ['POST', '/compartilhar', 'CompartilhamentosListaController', 'add'],

    ['POST', '/listas/add', 'ListaController', 'add'],
    ['POST', '/listas/addPoduto/{id}', 'ListaController', 'addPoduto'],
    ['POST', '/produto-remove/{id}/{id_lista}', 'ListaController', 'removeProduto'],
    ['POST', '/lista-remove/{id}', 'ListaController', 'removeLista'],
    ['POST', '/lista-alterar-onoff/{id}/{lista}', 'ListaController', 'alterarProduto'],
    ['POST', '/lista-alterar-estabelecimento/{lista}', 'ListaController', 'alterarEstabelecimento'],
    ['POST', '/lista-alterar-valores/{lista}', 'ListaController', 'alterarValores'],
    

    //--- LISTA DE AMIZADES
    ['GET', '/amizades', 'AmizadeController', 'index'],
    ['POST', '/amizade/addAmigo', 'AmizadeController', 'add'],
    ['POST', '/amigo-remove/{id}', 'AmizadeController', 'remove'],
    ['GET', '/aceitar-amizade/{id}', 'AmizadeController', 'aceitarAmizade'],

    //--- Estabelecimentos
    ['GET', '/estabelecimentos', 'EstabelecimentosController', 'index'],
    ['POST', '/estabelecimentos/add', 'EstabelecimentosController', 'add'],
    ['POST', '/estabelecimento-remove/{id}', 'EstabelecimentosController', 'remove'],

    //---- rotas de ajax
    ['POST', '/produto-add', 'ProdutoController', 'add'],
    ['GET', '/produto-buscar', 'ProdutoController', 'buscarProdutos'],

    ['GET', '/buscar_mensagens/{id_item_lista}', 'AnotacoesController', 'ajaxTodasPorProduto'],
    ['POST', '/excluir_mensagem/{id}', 'AnotacoesController', 'deleteAnotacoes'],
    ['POST', '/salvar_mensagem/{id_item_lista}', 'AnotacoesController', 'createAnotacoes'],

    //--- rotas de login
    ['GET', '/login', 'LoginController', 'index'],
    ['POST', '/login/post', 'LoginController', 'login'],
    ['GET', '/Logout', 'LoginController', 'logout'],

    //----------------------------------------------------------------

    //--- ROTAS DE USUÁRIO
    //--- rotas de controle carregam view
    ['GET', '/Controle', 'ControladorController', 'index'],
    ['GET', '/Controle/Usuario', 'UserController', 'index'],
    ['GET', '/Controle/Usuario/Edit/{id}', 'UserController', 'edit'],
    //--- rotas de ação não carrega view
    ['POST', '/Usuario/create', 'UserController', 'create'],
    ['POST', '/Usuario/Edit/{id}', 'UserController', 'update'],
    ['POST', '/Usuario/Delete/{id}', 'UserController', 'delete'],
];
