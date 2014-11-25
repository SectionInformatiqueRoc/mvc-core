<?php
namespace MVC;

class Duration{
    
    private $_duration;
    private $_format='%d:%02d';
    
    function __construct($duration){
        $this->_duration=$duration;
    }
    
    public function setFormat($format) {
        return $this->_format = $format;
    }

        
    public function getHours(){
        return floor($this->_duration/3600);
    }
    public function getMinutes(){
        return floor(($this->_duration-self::getHours($this->_duration)*3600)/60);
    }
    public function __toString(){
        return sprintf($this->_format,$this->getHours(),$this->getMinutes());
    }
    static function getHoursMinutes($duration,$format=null){
        $duration=new Duration($duration);
        if(!is_null($format)){
            $duration->setFormat($format);
        }
        return $duration->__toString();
    }
}