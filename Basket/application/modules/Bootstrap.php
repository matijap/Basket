<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap 
{
    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }
    
    protected function _initDb()
    {
        $db = $this->getPluginResource('db')->getDbAdapter();
        $db->query('SET NAMES utf8;');
        $profiler = new Zend_Db_Profiler_Firebug('All DB Queries');
        $profiler->setEnabled(true);
        // Attach the profiler to your db adapter
        $db->setProfiler($profiler);
        Zend_Db_Table_Abstract::setDefaultAdapter($db);
        Zend_Registry::set('dbAdapter', $db);
    }
    
    protected function _initAutoloader()
    {
        // Require the autoloader class file
        require_once 'Zend/Loader/Autoloader.php';
        
        // Fetch the Singleton instance of Zend_Loader_Autoloader
        $autoloader = Zend_Loader_Autoloader::getInstance();

        // Set the autoloader as a fallback autoloader (loads all namespaces by default)
        $autoloader->setFallbackAutoloader(true);
        $path = APPLICATION_PATH . '/modules/basket/models';
        set_include_path(get_include_path() . PATH_SEPARATOR . $path);
        $path = APPLICATION_PATH . '/modules/login/models';
        set_include_path(get_include_path() . PATH_SEPARATOR . $path);
        
        // Return the autoloader
        return $autoloader;
    }
    
    
    protected function _initLogging()
    {
        $logger = new Zend_Log();
        $writer = new Zend_Log_Writer_Stream('php://stderr');
        $logger->addWriter($writer);
        Zend_Registry::set('logger',$logger);
        return $logger;
    }
    
    protected function _initAcl()
    {
        require_once 'Basket/Acl.php'; 
   //     $cache = Zend_Registry::get('cache');
//        if(!$cache->test(Platforma_Acl::PLATFORMA_ACL_CACHE_KEY)) {
//            $acl = new Platforma_Acl();
//            $cache->save($acl, Platforma_Acl::PLATFORMA_ACL_CACHE_KEY);
//        } else {
//            $acl = $cache->load(Platforma_Acl::PLATFORMA_ACL_CACHE_KEY);
//        }
        
        $acl = new Basket_Acl();
        Zend_Registry::set('acl', $acl);
    }
    
    protected function _initConfig() {
      $configPath = APPLICATION_PATH . '/configs';

      $config = new Zend_Config_Xml("$configPath/application.xml", APPLICATION_ENV,true);
      $configs = array('common','routes', 'production', 'secrets');
      if (substr(APPLICATION_ENV,0,10)!='production') {
        $configs[] = "development";
        if (APPLICATION_ENV != "development") {
          $configs[] = APPLICATION_ENV;
        }
      }
      $configs[] = 'custom';
      foreach ($configs as $c) {
        $section = $c=='routes' ? 'application' : $c;
        $configFile = "$configPath/{$c}.xml";
        if (file_exists($configFile)) {
          $config->merge(new Zend_Config_Xml($configFile,$section,true));
        }
      }

      $config->setReadOnly();
      $this->setOptions($config->toArray());

      Zend_Registry::set('config', $config);
      return $config;
    }
       

//    protected function _initTranslate() {
//        // We use the Swedish locale as an example
//        $locale = new Zend_Locale('en_US');
//        Zend_Registry::set('Zend_Locale', $locale);
//
//        $session = new Zend_Session_Namespace(APP_URL);
//        $langLocale = isset($session->lang) ? $session->lang : $locale;
//
//        $translate = new Zend_Translate('gettext', APPLICATION_PATH . '/languages/en/en.mo', $langLocale,array('disableNotices' => true));
//        $translate->setLocale($langLocale);
//        Zend_Registry::set('Zend_Translate', $translate);
//    }
    
    
}