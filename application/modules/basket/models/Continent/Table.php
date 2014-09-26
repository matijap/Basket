<?php

require_once 'Zend/Db/Table/Abstract.php';

class Continent_Table extends Zend_Db_Table_Abstract {

protected $_name         = 'continent';
protected $_primary      = array('id');
protected $_rowClass     = 'Continent';

protected $_referenceMap = array(
                    );

}