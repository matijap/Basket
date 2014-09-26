<?php

class Basket_Acl extends Zend_Acl {

    public function __construct() {
        $roles = Role::getRolesId();
        foreach ($roles as $role) {
            $this->addRole(new Zend_Acl_Role($role));
        }
        $resources = AclResource::getResources();
        foreach ($resources as $resource) {
            $this->add(new Zend_Acl_Resource($resource));
        }
        
        foreach ($roles as $role) {
            foreach ($resources as $resource) {
                $this->allow($role, $resource);
            }
        }        
    }
}