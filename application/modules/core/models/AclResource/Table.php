<?php

require_once 'Zend/Db/Table/Abstract.php';

class AclResource_Table extends Zend_Db_Table_Abstract {

protected $_name         = 'acl_resource';
protected $_primary      = array('id');
protected $_rowClass     = 'AclResource';

protected $_referenceMap = array(
                    );

}