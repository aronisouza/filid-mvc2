<?php

class HomeController extends Controller
{
    public function index()
    {
        $_SESSION['base-view'] = 'Site';
        $this->render('home');
    }
}
