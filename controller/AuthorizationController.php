<?php

class AuthorizationController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        if(!isset($_SESSION['user'])){
            $this->view->render('login',[
                'msg'=>'You need to login',
                'email'=>''
            ]);
            exit;
        }
    }
}