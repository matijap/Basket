<?php

class LoginController extends Zend_Controller_Action
{
    public function init() {
        parent::init();
    }
    public function indexAction()
    {
        $this->view->form = $form = new LoginForm();
        $request          = $this->getRequest();
        $values           = $request->getParams();
        if ($request->isPost()) {
            $isValid = $form->isValid($values);
            if ($isValid) {
                User::login($values['email'], $values['password']);
                $this->_redirect(APP_URL . '/basket');
//                $result = User::login($values['email'], $values['password']);
//                if ($result) {
//                    $redirect    = new Zend_Session_Namespace(Platforma_Utilities::SESSION_REDIRECT);
//                    $redirectUrl = isset($redirect->redirect_url) ? $redirect->redirect_url : '/billing/index';
//                    CurrencyRates::insertRateForDate();
//                    $this->_redirect($redirectUrl);
//                } else {
//                    $this->view->showError = true;
//                }
            } else {
                fb('nije');
            }
        }
    }
    
    public function logoutAction() 
    {
        Zend_Auth::getInstance()->clearIdentity();
        Zend_Session::forgetMe();
        Zend_Session::destroy();
        $this->_redirect('/login/login');
    }
    
    public function registerAction()
    {
        $this->view->form = $form = new RegisterForm();
        $request          = $this->getRequest();
        $values           = $request->getParams();
        if ($request->isPost()) {
            $isValid = $form->isValid($values);
            if ($isValid) {
                $userRole          = Role::getRootRole();
                $values['role_id'] = $userRole['id'];
                $user              = User::create($values);
                $user              = $user->setToken();
                $user->sendRegistrationMail();
            } else {
                
            }
        }
    }
}