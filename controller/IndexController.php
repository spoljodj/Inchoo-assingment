<?php

class IndexController extends Controller
{
    public function index()
    {
        $this->view->render('index');
    }

    public function login()
    {
        $this->view->render('login',[
            'msg'=>'Enter your log in info',
            'email'=>''
        ]);
    }

    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
        $this->index();
    }
}