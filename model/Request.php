<?php

class Request
{
    public static function getRoute()
    {
        $route='';
        if(isset($_SERVER['REDIRECT_PATH_INFO'])){
            $route=$_SERVER['REDIRECT_PATH_INFO'];
        }else if(isset($_SERVER['PATH_INFO'])){
            $route=$_SERVER['PATH_INFO'];
        }else{
            $route='/';
        }
        return $route;
    }
}