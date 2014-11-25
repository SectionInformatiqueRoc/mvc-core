<?php

namespace MVC;

class Connexion {

    private static $_pdo;

    private static $_query=array();
    
    public static $last_query;

    private function __construct() {
        $dsn = 'mysql:dbname='
                . \Install\Bdd::NAME
                . ';host='
                . \Install\Bdd::HOST;
        self::$_pdo=new \PDO(
                $dsn, \Install\Bdd::USER, \Install\Bdd::PWD, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }

    static public function get() {
        if (!isset(self::$_pdo)) {
            new Connexion();
        }
        return self::$_pdo;
    }

    /**
     * 
     * @param String $statement
     * @return PDOStatement
     */
    static public function query($statement){     
        self::$last_query=$statement;
        return self::get()->query($statement);
    }
    static function prepare($statement, $driver_options = array()) {
        self::$last_query=$statement;
        if(!isset(self::$_query[$md5=md5($statement)])){
            self::$_query[$md5]=self::get()->prepare($statement, $driver_options);
        }
        return self::$_query[$md5];
    }
    static function table($statement,$params){
        $queryPrepare=self::get()->prepare($statement);
        if($queryPrepare->execute($params)){
            return $queryPrepare->fetchAll();
        }else{
            return false;
        }
    }
    
}
