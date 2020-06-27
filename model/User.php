<?php

class User
{

    function recurseRmdir($dir) {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
          (is_dir("$dir/$file")) ? recurseRmdir("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
      }

    public static function registernew()
    {
        $connection= DB::getInstance();
        $value=$connection->prepare('insert into user (email,user_password,user_name,sessionid)
        values (:email,:password,:username,:sessionid)');
        unset($_POST['passwordagain']);
        $_POST['password']= password_hash($_POST['password'],PASSWORD_BCRYPT);
        $_POST['sessionid']=session_id();
        $value->execute($_POST);
        $path= BP . 'public' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . $_POST['username'] ;
        if(!file_exists($path)){
            mkdir($path);
        }
    }

    public static function read($user_id)
    {
        $connection= DB::getInstance();
        $value=$connection->prepare('select * from user where user_id=:user_id');
        $value->execute(['user_id'=>$_GET['user_id']]);
        return $value->fetch();
    }

    public static function update()
    {
        $connection= DB::getInstance();
        $value=$connection->prepare('update user set email=:email, user_password=:password, user_name=:user_name
         where user_id=:user_id');
        $_POST['password']= password_hash($_POST['password'],PASSWORD_BCRYPT);
        unset($_POST['passwordagain']);
        $value->execute($_POST);
    }

    public static function delete()
    {
        try{
            $dir=BP . 'public' . DIRECTORY_SEPARATOR
            . 'img' . DIRECTORY_SEPARATOR . 
            $_SESSION['user']->user_name;
        $connection= DB::getInstance();
        $connection->beginTransaction();
        $value=$connection->prepare('delete from album where posting_user=:user_id');
        $value->execute($_GET);
        $value=$connection->prepare('delete from user where user_id=:user_id');
        $value->execute($_GET);        
        $connection->commit();
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );
        
        foreach ($files as $fileinfo) {
            $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
            $todo($fileinfo->getRealPath());
        }
        
        rmdir($dir);
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
        return true;
    }

    public static function upload()
    {
        $connection= DB::getInstance();
        $value=$connection->prepare('insert into album(posting_user,picture_name) values (:user_id, :picture_name)');
        $value->execute([
            'user_id'=>$_POST['user_id'],
            'picture_name'=>$_POST['picture_name']
        ]);
        if(isset($_FILES['picture'])){
            $path = BP . 'public' . DIRECTORY_SEPARATOR
            . 'img' . DIRECTORY_SEPARATOR . 
            $_SESSION['user']->user_name . DIRECTORY_SEPARATOR 
            . $_POST['picture_name'] . '.jpg';
            move_uploaded_file($_FILES['picture']['tmp_name'], $path);
        }
    }

    public static function countpic()
    {
        $connection= DB::getInstance();
        $value=$connection->prepare('select count(*) from album');
        $value->execute();
        $number=$value->fetchColumn();
        return $number;
    }
}