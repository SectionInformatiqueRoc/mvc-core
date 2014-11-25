<?php
namespace MVC;

class Acl{
    private $_roles;
    
    function addRole(AclRole $aclRole,$extends=null){
        if(!is_array($extends)){
            $extends=array($extends);
        }
        $aclRole->addExtend($extends);
        $this->_roles[$aclRole->getName()]=$aclRole;
    }
    function allow($role,$c=null,$a=null){
        //role doit être une chaine, conversion si objet recu
        if(!is_object($role)){
            $role=$this->_roles[$role];
        }
        //$a doit etre un tableau
        if(!is_array($a)){
            $a=array($a);
        }
        $role->allow($c,$a);
    }
    function isAllowed($role,$c=null,$a=null){
        //role doit être une chaine, conversion si objet recu
        if(!is_object($role)){
            $role=$this->_roles[$role];
        }
        return $role->isAllowed($c,$a);        
    }
}