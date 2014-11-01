<?php   
      //Including configuration php file, with all defined variables
      include("config.php");
      // Adding library directory to the include path
        /**
         * @todo all this can be done in the config file
         */
        set_include_path(implode(PATH_SEPARATOR, array(
            realpath(APPLICATION_PATH . '/modules'),
            realpath(APPLICATION_PATH . '/modules/basket/models'),
            realpath(APPLICATION_PATH . '/modules/login/models'),
            realpath(APPLICATION_PATH . '/modules/login/views/forms'),
            realpath( '/home/matija/Desktop/Basket/library/'),
            realpath( '/home/matija/Desktop/Basket/library/Basket'),
            get_include_path(),
        )));
        
error_log('dbc');
      /** Zend_Application */
      require_once 'Zend/Application.php';
      // Create application, bootstrap, and run     
      $application = new Zend_Application(
          APPLICATION_ENV,
          APPLICATION_PATH . '/configs/application.xml'
      );
      error_log('aaa');
    require_once 'Basket/Acl.php';
    error_log('bbb');
    /**
    * define a simple logging function
    * @todo why is this code here?
    */
    function fb($msg, $label=null) {
      if ($label != null) {
        $msg = array($label,$msg);
      }
      $logger = Zend_Registry::get('logger');
      $msg = print_r($msg,true);
      $logger->info($msg);
      error_log($msg);
    }
    error_log('qqq');
    $application->getBootstrap()->bootstrap('db');
    $application->bootstrap();
    error_log('zzz');
    if(!defined('APP_RUN')) {
        error_log('opa');
        $application->run();
    }
    error_log('qqqaa');