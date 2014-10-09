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
        $this->setOptions(array('class' => 'm-t-20'));
        
        $this->clearDecorators()->setDecorators(array('FormElements', 'Form'));
        
        $email = $this->createElement('text', 'email', array(
            'label'                 => 'Email',
            'class'                 => 'form-control input-lg',
            'data-parsley-required' => 'true',
            'data-parsley-type'     => 'email',
            'placeholder'           => 'Email'
        ));        
        
        $decorator = array(
                            'ViewHelper',
                            array('Description', array('class' => '')),
                            array('Errors', array('class'      => '')),
                            array('HtmlTag', array('tag'     => 'div', 'class' => 'form-group')),
                    );
        $email->clearDecorators()->setDecorators($decorator);
        
        $password = $this->createElement('password', 'password', array(
            'label'                 => 'Password',
            'class'                 => 'form-control input-lg',
            'data-parsley-required' => 'true',
            'placeholder'           => 'Password'
        ));
        $decorator = array(
                      'ViewHelper',
                      array('Description', array('class' => '')),
                      array('Errors', array('class'      => '')),
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