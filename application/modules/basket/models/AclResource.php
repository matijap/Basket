<?php

require_once 'AclResource/Row.php';

class AclResource extends AclResource_Row
{
    public static function getResources() {
        $resources = Core::getBasicSelect()
                     ->from('acl_resource', 'resource')
                     ->query()
                     ->fetchAll(Zend_Db::FETCH_COLUMN, 0);
        return $resources;
    }
}