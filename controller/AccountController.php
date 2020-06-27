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

    public function picupload()
    {
        $this->view->render($this->viewDir . 'picupload',['msg'=>'Upload your picture']);
    }

    public function upload()
    {
        if(isset($_FILES['picture'])){
        User::upload();
        $this->index();
        }else{
            $this->view->render($this->viewDir . 'picupload',['msg'=>'You have not selected a picture to upload']);
        }
    }
}