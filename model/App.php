<?php

class App
{
    public static function start()
    {
        $route=Request::getroute();

        $parts= explode('/',$route);

        $class='';
        if(!isset($parts[1]) || $parts[1]===''){
            $class='Index';
        }else{
            $class=ucfirst($parts[1]);
        }

        $class.='Controller';

        $function='';
        if(!isset($parts[2]) || $parts[2]===''){
            $function='index';
        }else{
            $function=$parts[2];
        }

        if(class_exists($class) && method_exists($class,$function)){
            $instance=new $class();
            $instance->$function();
        }else{
            header('HTTP/1.0 404 Not Found');
        }

    }

    public static function config($key)
    {
        $configuration = include BP . 'configuration.php';
        return $configuration[$key];
    }

}