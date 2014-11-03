<?php
class Basket_Controller_Action extends Zend_Controller_Action {
    
    public function init() {
       //$this->translate = Zend_Registry::getInstance()->Zend_Translate;
       //$translate = $this->translate;

//        if (!Zend_Auth::getInstance()->hasIdentity()) {
//            return $this->_redirect('/login/login/index');
//        } else {
//           $identity = Zend_Auth::getInstance()->getIdentity();
//        }
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            fb('nema login');
            return $this->_redirect('/login/login');
        } else {
            fb('ima login');
        }
    }
}