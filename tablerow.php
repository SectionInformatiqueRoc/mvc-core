<?php

namespace MVC;

class TableRow {

    private $_table;

    
    public function __destruct() {
        $attributs = get_object_vars($this);
        $keys = array_keys($attributs);
        foreach ($keys as $cle) {
            unset($this->$cle);
        }
    }

    public function __tostring(){
        $values=  get_object_vars($this);
        return implode(';',array_values($values));
    }
    public function setTable($table) {
        $this->_table = $table;
    }

    /**
     * 
     * @param String $table
     * @param PDO $pdo
     * @return \MVC\TableRow
     * @throws \Exception
     */
    public function store($table = null, $pdo = null) {
        if (is_null($pdo)) {
            $pdo = Connexion::get();
        }
        if (is_null($table)) {
            $table = $this->_table;
        }
        $attributs = get_object_vars($this);
        //suppression des attributs de la classe TableRow
        $keys = array_keys($attributs);
        foreach ($keys as $cle) {
            if (substr($cle, 0, 1) == '_') {
                unset($attributs[$cle]);
            }
        }
        $values = array_values($attributs);

        if (isset($this->id) and is_numeric($this->id)) {
            $query = 'update `' . $table . '` set `';
            $query.=implode('`=?,`', array_keys($attributs)) . '`=?';
            $query.=' where id=?';
            $values[] = $this->id;
        } else {
            $query = 'insert into `'
                    . $table
                    . '`(`' . implode('`,`', array_keys($attributs)) . '`) values ('
                    . substr(str_repeat('?,', sizeof($attributs)), 0, -1) . ')';
        }

        $queryPrepare = Connexion::prepare($query);
        if (!$queryPrepare->execute($values)) {
            $error = $queryPrepare->errorInfo();
            var_dump($query);
            throw new \Exception("\nQuery:".Connexion::$last_query."\nPDO::errorInfo():\n" . $error[2]);
        }
        if (!is_numeric($this->id)) {
            $this->id = $pdo->lastInsertId();
        }
        return $this;
    }

    public function delete($table = null, $pdo = null) {
        if (is_null($pdo)) {
            $pdo = Connexion::get();
        }
        if (is_null($table)) {
            $table = $this->_table;
        }
        if (isset($this->id) and !is_null($this->id)) {
            $query = 'delete from `' . $table;
            $query.='` where id=?';
            $queryPrepare = Connexion::prepare($query);
            $ex = $queryPrepare->execute(array($this->id));
        } else {
            $ex = null;
        }
        unset($this);
        return $ex;
    }

    public function populate($params) {        
        $cles = get_object_vars($this);
        $keys = array_keys($cles);
        foreach ($keys as $cle) {
            if (substr($cle, 0, 1) != '_' and isset($params[$cle]) and $cle!='id') {
                $this->$cle = $params[$cle];
            }
        }
        return $this;
    }

    /*
      public function __call($name) {

      if (substr($name, 0, 3) == 'get') {
      $nom = ucfirst(substr($name, 3, -1));
      $class = '\\APPLI\\M\\' . $nom;

      $classThis = strtolower(substr(get_class($this), 0, -3));
      $pos = strrpos($classThis, '\\');
      $classThis = substr($classThis, $pos + 1);

      return $class::getInstance()->where($classThis . '_id=?', array($this->id));
      }
      }
     */

}
