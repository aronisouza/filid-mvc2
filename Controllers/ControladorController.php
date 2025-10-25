<?php

class ControladorController extends Controller
{
    public function __construct()
    {
        $this->checkSessionTimeout();
    }

    public function index()
    {
        $_SESSION['base-view'] = 'Controlador';
        $this->render('Controlador/home', ["pagina" => "Controle"]);
    }
}
