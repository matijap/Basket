<?php

class LoginForm extends Zend_Form
{
    public function __construct($options = null) {
        
        parent::__construct($options);
    }
    
    public function init() {
        parent::init();
        $this->redecorate();
    }
    
    public function redecorate()
    {
        $this->setAction(APP_URL . '/login/login/');
        $this->setAttrib('id', 'login-form');
        
        $this->clearDecorators()->setDecorators(array('FormElements', 'Form'));
        
        $email = $this->createElement('text', 'email', array(
            'label' => 'Email',
            'class' => 'form-control',
            'data-parsley-required' => 'true',
            'data-parsley-type' => 'email'
        ));        
        
        $decorator = array(
                            'ViewHelper',
                            array('Description', array('class' => '')),
                            array('Errors', array('class'      => '')),
                            array('Label', array('class'       => 'white-color', 'for' => 'email')),
                            array('HtmlTag', array('tag'     => 'div', 'class' => 'form-group')),
                    );
        $email->clearDecorators()->setDecorators($decorator);
        
        $password = $this->createElement('password', 'password', array(
            'label'                 => 'Password',
            'class'                 => 'form-control',
            'data-parsley-required' => 'true',
        ));
        $decorator = array(
                      'ViewHelper',
                      array('Description', array('class' => '')),
                      array('Errors', array('class'      => '')),
                      array('Label', array('class'       => 'white-color', 'for' => 'password')),
                      array('HtmlTag', array('tag'     => 'div', 'class' => 'form-group')),
              );
        $password->clearDecorators()->setDecorators($decorator);
              
        $submit  = $this->createElement('submit', 'submit', array(
            'class' => 'btn btn-primary width-100-percent',
            'label' => 'Submit'
        ));
        $submit->clearDecorators()->setDecorators(array('ViewHelper'));
        $this->addElement($email);
        $this->addElement($password);
        $this->addElement($submit);
    }
}