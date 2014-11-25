<?php
namespace MVC;

class Vue{
    /**
     *
     * @var String
     */
    private $_fichier; 
    /**
     *
     * @var array
     */
    private $_data;
    public function __construct($c,$a) {
        $this->_fichier= \Install\Chemins::VUE.strtolower($c.'/'.$a).'.php';        
        $this->_data=array();
    }
    public function display(){
        if(file_exists(\Install\Chemins::VUE.'header.php')){
            include \Install\Chemins::VUE.'header.php';
        }
        include $this->_fichier;
    }
    public function setFichier($fichier){
        if(substr($fichier, -4)!='.php'){
            $fichier.='.php';
        }
        $this->_fichier= \Install\Chemins::VUE.$fichier;        
    }
    public function __set($cle,$valeur){
        return $this->_data[$cle]=$valeur;
    }
    public function __get($cle){
        return $this->_data[$cle];
    }
    public function getAllData(){
        return $this->_data;
    }
    static function lien($c,$a,$texte,$params=array()){
        $lien='<a href=".?c='.$c.'&a='.$a;
        foreach ($params as $cle=>$valeur) {
            $lien.='&'.$cle.'='.$valeur;            
        }
        $lien.='">'.$texte.'</a>';
        return $lien;
    }
    static function url($c,$a,$params=array()){
        $url=$c.'/'.$a.'/';
        foreach ($params as $cle=>$valeur) {
            $url.=''.$cle.'='.$valeur.'&';
        }
        return substr($url,0,-1);        
    }
    static function popoverhelp($text,$direction='right'){
        return '<span class="fa-stack fa-lg"  data-toggle="popover" data-placement="'.$direction.'" data-content="'._($text).'" onclick="ga(\'send\',\'pageview\',{\'page\':\'/help/\'+$(this).parent().text()});">  <i class="fa fa-circle fa-stack-2x"></i>'
        . '<i class="pointer fa fa-question fa-stack-1x fa-inverse"></i>'
        . '</span>';
    }
}