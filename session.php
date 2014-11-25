<?php

namespace MVC;

class Session {

    static $data = array();
    static $self = null;

    private function __construct() {
        
    }

    public function __get($name) {
        return self::$data[$name];
    }

    public function __set($name, $value) {
        if (substr($name, 0, 1) == '_') {
            $_SESSION[$name] = $value;
        } else {
            $_SESSION[$name] = serialize($value);
        }
        return self::$data[$name] = $value;
    }

    public function __isset($name) {
        return isset(self::$data[$name]);
    }

    static function init() {
        foreach ($_SESSION as $key => $value) {
            if (substr($key, 0, 1) == '_') {
                self::$data[$key] = $value;
            } else {
                self::$data[$key] = unserialize($value);
            }
        }
    }

    static function get() {
        if (is_null(self::$self)) {
            self::$self = new Session();
        }
        return self::$self;
    }
    static function destroy(){
        self::$data=array();
    }
}
