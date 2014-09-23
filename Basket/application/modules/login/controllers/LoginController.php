<?php

class Login_LoginController extends Zend_Controller_Action
{
    
    public function indexAction()
    {
        $this->view->form = $form = new LoginForm();
    }
}