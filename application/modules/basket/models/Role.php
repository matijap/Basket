<?php

require_once 'Role/Row.php';

class Role extends Role_Row
{
    public static function getRolesId() 
    {
        $roles = Core::getBasicSelect()
                 ->from('role', 'id')
                 ->query()
                 ->fetchAll(Zend_Db::FETCH_COLUMN, 0);
        return $roles;
    }
    
    public static function getRootRole()
    {
        return Core::getBasicSelect()
               ->from('role')
               ->where('is_root = ?', 1)
               ->query()->fetch();
    }
}