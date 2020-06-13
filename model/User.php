<?php

class User
{
    public static function registernew()
    {
        $connection= DB::getInstance();
        $value=$connection->prepare('insert into user (email,user_password,user_name,sessionid)
        values (:email,:password,:username,:sessionid)');
        unset($_POST['passwordagain']);
        $_POST['password']= password_hash($_POST['password'],PASSWORD_BCRYPT);
        $_POST['sessionid']=session_id();
        $value->execute($_POST);
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
        $connection= DB::getInstance();
        $value=$connection->prepare('delete from user where user_id=:user_id');
        $value->execute($_GET);
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
        return true;
    }
}