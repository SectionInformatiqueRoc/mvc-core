<?php

namespace MVC;

class AclRole {

    private $_name;
    private $_allow;
    private $_extends;

    function __construct($name, $extends = array()) {
        $this->_name = $name;
        $this->_extends = $extends;
        $this->_allow = array();
    }

    function addExtend($extend) {
        if (!is_array($extend)) {
            $extend = array($extend);
        }
        $this->_extends = array_merge($this->_extends, $extend);
        return $this;
    }

    public function getName() {
        return $this->_name;
    }

    public function allow($c = null, $a = null, $value = false) {
        if (!isset($this->_allow[$c])) {
            $this->_allow[$c] = array();
        }
        foreach ($a as $a_i) {
            if (!isset($this->_allow[$c][$a_i])) {
                $this->_allow[$c][$a_i] = array();
            }
            $this->_allow[$c][$a_i] = true;
        }
    }

    function deny($c = null, $a = null) {
        return $this->allow($c, $a, false);
    }

    function isAllowed($c = null, $a = null) {
        if (isset($this->_allow[$c][$a])) {
            return $this->_allow[$c][$a];
        }
        foreach ($this->_extends as $extend) {
            if (!is_null($extend)) {
                if (!is_null($result = $this->isAllowed($extend, $c, $a))) {
                    return $result;
                }
            }
        }
        return null;
    }

}
