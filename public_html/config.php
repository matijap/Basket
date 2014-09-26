<?php 
    error_reporting(E_ALL);
    // Define path to application directory
    
    if (!defined('APPLICATION_PATH')){
        define("APPLICATION_PATH","/home/matija/Desktop/Basket/application");
    }
    
    if (!defined('WEB_ROOT_PATH')){
        define("WEB_ROOT_PATH","/home/matija/Desktop/Basket/public_html"); 
    }

    if (!defined('ROOT_PATH')) {
        define("ROOT_PATH", "/home/matija/Desktop/Basket/");
    }

    if(!defined('FB_APP_ID')) {
        define("FB_APP_ID", "126363994137616");
    }

    if(!defined('FB_APP_SECRET')) {
        define("FB_APP_SECRET", "39d5d2bca4e62f7afd084a20d8c919af");
    }
    if (!defined('APP_URL')){
        define("APP_URL","http://local.basket/public_html"); 
    }
    defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));?>