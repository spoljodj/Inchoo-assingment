<?php

class AccountController extends AuthorizationController
{

    private $viewDir='private' . DIRECTORY_SEPARATOR;

    function index()
    {
        $this->view->render($this->viewDir . 'account');
    }

    public function updateprofile()
    {
        User::updateprofile();
        $this->index();
    }
}