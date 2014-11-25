<?php

namespace MVC;

abstract class Controleur {

    /**
     * vue associee au controleur
     * @var \MVC\Vue
     */
    static private $_vue;
    
    /**
     * 
     * @param String $a action demandee sur le controleur
     * @param array $params paramètres envoyes au controleur
     * @return boolean retourne vrai si l'action est autorisee, faux sinon
     */
    static public function acl($a,$params){
        return false;
    }
    
    public function aclVerif($a){
        $c=explode('\\',get_called_class());
        unset($c[0]);
        unset($c[1]);
        $c=implode('\\',$c);
        if(is_null(\Install\App::$utilisateur)){
            $role='anonymous';
        }else{
            $role= \APPLI\M\TypeUtilisateur::getInstance()->get(\Install\App::$utilisateur->typeUtilisateur_id)->code;
        }
        return \Install\App::$acl->isAllowed($role,$c,$a);
    }

    /**
     * redirige le controleur actuel vers un nouveau controleur
     * @param String $c controleur
     * @param String $a action
     * @param array $params paramètres
     */
    static public function redirect($c, $a, $params = array()) {
        self::$_vue = new Vue($c, $a);
        $nomControleur = '\APPLI\\C\\' . $c;
        $nomControleur::$a($params);
    }

    /**
     * affecte la vue du controleur
     * @param \MVC\Vue $vue 
     * @return type
     */
    static public function setVue($vue) {
        return self::$_vue = $vue;
    }

    /**
     * return the view
     * @return \MVC\Vue
     */
    public static function getVue() {
        return self::$_vue;
    }

}
