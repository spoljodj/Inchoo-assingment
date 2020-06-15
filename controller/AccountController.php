<?php

class AccountController extends AuthorizationController
{

    private $viewDir='private' . DIRECTORY_SEPARATOR;

    function index()
    {
        $this->view->render($this->viewDir . 'dashboard');
    }

    public function updateprofile()
    {
        User::updateprofile();
        $this->index();
    }
}