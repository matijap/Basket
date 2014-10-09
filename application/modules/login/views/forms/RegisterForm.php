<?php

class RegisterForm extends Zend_Form
{
    
    const PASSWORD_MIN_LENGTH = 6;
    
    public function __construct($options = null) {
        
        parent::__construct($options);
    }
    
    public function init() {
        parent::init();
        $this->redecorate();
    }
    
    public function redecorate()
    {
        $this->setAction(APP_URL . '/login/login/register/');
        $this->setAttrib('id', 'login-form');
        $this->setOptions(array('class' => 'm-t-20'));
        
        $this->clearDecorators()->setDecorators(array('FormElements', 'Form'));
        
        $email = $this->createElement('text', 'email', array(
            'label'                  => 'Email',
            'class'                  => 'form-control input-lg',
            'data-parsley-required'  => 'true',
            'data-parsley-type'      => 'email',
            'placeholder'            => 'Email',
            'data-parsley-trigger'   => 'change',
            'data-parsley-type'      => 'email'
        ));
        $email->addValidator('EmailAddress', false)
                ->getValidator('EmailAddress')
                ->setMessage('Invalid email address format',
                        Zend_Validate_EmailAddress::INVALID_FORMAT);
        $email->setRequired(true)
              ->addValidator('Db_NoRecordExists', true,
                array(
                    'table'    => 'user',
                    'field'    => 'email',
                    'messages' => 'User with this email already exist'
                    ));
        
        $decorator = array(
                        'ViewHelper',
                        array('Description', array('class' => '')),
                        array('Errors', array('class'      => 'zend-error-style')),
                        array('HtmlTag', array('tag'     => 'div', 'class' => 'form-group')),
                    );
        $email->clearDecorators()->setDecorators($decorator);
        
        $password = $this->createElement('password', 'password', array(
            'label'                  => 'Password',
            'class'                  => 'form-control input-lg',
            'data-parsley-required'  => 'true',
            'placeholder'            => 'Password',
            'data-parsley-minlength' => self::PASSWORD_MIN_LENGTH
        ));
        $validator = new Zend_Validate_StringLength();
        $validator->setMin(self::PASSWORD_MIN_LENGTH);
        $password->setRequired(true);
        $password->addValidator($validator);
        $repeatPassword = $this->createElement('password', 'repeat_password', array(
            'label'                  => 'Password',
            'class'                  => 'form-control input-lg',
            'data-parsley-required'  => 'true',
            'placeholder'            => 'Repeat Password',
            'data-parsley-minlength' => self::PASSWORD_MIN_LENGTH,
            'data-parsley-equalto'   => "#password"
        ));
        $repeatPassword->setRequired(true)
                       ->addValidator('Identical', true,
                         array('token' => 'password', 'messages' => 'Passwords provided are not same'));
        $decorator = array(
                      'ViewHelper',
                      array('Description', array('class' => '')),
                      array('Errors', array('class'      => 'zend-error-style')),
                      array('HtmlTag', array('tag'     => 'div', 'class' => 'form-group')),
              );
        $password->clearDecorators()->setDecorators($decorator);
        $repeatPassword->clearDecorators()->setDecorators($decorator);
              
        $submit  = $this->createElement('submit', 'submit', array(
            'class' => 'btn btn-primary width-100-percent',
            'label' => 'Submit'
        ));
        $submit->clearDecorators()->setDecorators(array('ViewHelper'));
        $this->addElement($email);
        $this->addElement($password);
        $this->addElement($repeatPassword);
        $this->addElement($submit);
    }
}