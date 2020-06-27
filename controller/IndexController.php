<?php

class IndexController extends Controller
{
    private $viewDir='private' . DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render('index',['javascript'=>'<script src="' . APP::config('url') . 
        'public/js/picnumber.js"></script>']);
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

    public function authorization()
    {
        if(!isset($_POST['email']) || !isset($_POST['password'])){
            $this->view->render('login',[
                'msg'=>'Please put your login info',
                'email'=>''
            ]);
            return;
        }

        if(trim($_POST['email'])==='' || trim($_POST['password'])===''){
            $this->view->render('login',[
                'msg'=>'Login info required',
                'email'=>$_POST['email']
            ]);
        }

        $connection=DB::getInstance();
        $value=$connection->prepare('select * from user where email=:email');
        $value->execute(['email'=>$_POST['email']]);
        $result=$value->fetch();
            if($result==null){
                $this->view->render('login',[
                    'msg'=>'User doesnt exist',
                    'email'=>$_POST['email']
                ]);
                return;
            }
            if(!password_verify($_POST['password'],$result->user_password)){
                $this->view->render('login',[
                    'msg'=>'Wrong email and password combination',
                    'email'=>$_POST['email']
                ]);
                return;
            }
            unset($result->user_password);
            $_SESSION['user']=$result;
            $nac= new AccountController();
            $nac->index();            
    }

    public function register()
    {
        $this->view->render('registration');
    }

    public function registernew()
    {
        User::registernew();
        $this->view->render('index');
    }

    public function account()
    {
        $this->view->render($this->viewDir . 'account' , [
            'user'=>User::read($_GET['user_id'])
        ]);
    }

    public function change()
    {
        
        $user=User::read($_GET['user_id']);
        if(!$user){
            $this->index();
            exit;
        }
        
        $this->view->render($this->viewDir . 'change', [
            'user'=>$user,
            'msg'=>'Change your account info'
        ]);
    }

    public function update()
    {
        User::update();
        header('location: /index');
        session_reset();
    }

    public function delete()
    {
        User::delete();
        unset($_SESSION['user']);
        session_destroy();
        $this->index();
    }

    public function test()
    {
        $this->view->render('test');
    }

    public function count()
    {
       header('Content-Type: application/json');
       echo json_encode(User::countpic());
    }
    
}