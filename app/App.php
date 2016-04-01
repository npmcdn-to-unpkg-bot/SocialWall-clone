<?php

use App\Database\Database;

class App{

    private $db_instance;
    private static $_instance;

    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new App();
        }
        return self::$_instance;
    }

    public static function load(){
        session_start();
        require dirname(__DIR__).'/app/Autoloader.php';
        App\Autoloader::register();
    }

}