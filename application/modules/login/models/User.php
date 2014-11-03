<?php

require_once 'User/Row.php';

class User extends User_Row {
    public static function login($email, $password, $encrypt = true) 
    {
        $values  = array("email" => $email, "password" => $password, 'encrypt' => $encrypt);
        $adapter = self::getAuthAdapter($values); 
        $auth    = Zend_Auth::getInstance();
        $result  = $auth->authenticate($adapter);
        //$user    = self::getUserByEmail($email);
        //if ($user->is_activated){
            if ($result->isValid()) {
                fb('jeste auth');
                $storage = $auth->getStorage();
                $storage->write($adapter->getResultRowObject(array('email', 'password')));
                return true;
            } else {
                fb('nije auth');
                return false;
            }
        //}
    }
    public static function getAuthAdapter(array $params) {
        require_once APPLICATION_PATH . '/../library/Zend/Auth.php';
        require_once APPLICATION_PATH . '/../library/Zend/Auth/Adapter/DbTable.php';
        
        $auth        = Zend_Auth::getInstance();
        $dbAdapter   = Zend_Registry::getInstance()->dbAdapter;

        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
        $authAdapter->setTableName('user')
                ->setIdentityColumn('email')
                ->setCredentialColumn('password');

        // Set the input credential values
        $uname = $params['email'];
        $paswd = $params['encrypt'] ?
                 md5($params['password']) :
                 $params['password'];

        $authAdapter->setIdentity($uname);
        $authAdapter->setCredential($paswd);


        $res = $auth->authenticate($authAdapter);

        if (isset($_POST['rememberme']) && $_POST['rememberme'] == "on") {
            Zend_Session::rememberMe();
        }

        return $authAdapter;
    }
}