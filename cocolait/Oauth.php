<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/9
 * Time: 15:33
 */
namespace cocolait;
class Oauth{
    public function __construct()
    {
        echo 1;
    }

    public static  function getInstance($type, $token = null) {
        echo 1;die;
        $name = ucfirst(strtolower($type)) . 'SDK';
        require_once "sdk/{$name}.php";
        p(class_exists($name));die;
        if (class_exists($name)) {
            return new $name($token);
        } else {
            header('content-type:text/html;charset=utf-8');
            throw new \Exception($name);
        }
    }
}