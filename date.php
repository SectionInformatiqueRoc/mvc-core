<?php
namespace MVC;

class Date extends \DateTime{
    
    function firstDayOfWeek(){
        $timestamp=$this->getTimestamp();
        if($timestamp>0){
            $day=date('N',$timestamp);
                        
            $lundi=  $timestamp-$day*86400;
            $d=new Date(date('Y-m-d 00:00:00',$lundi));
        }else{
            $d=$this;
        }
        return $d->getTimestamp();        
    }
    function firstDayOfMonth(){
         $d=new Date(date('Y-m-01 00:00:00',$this->getTimestamp()));
         return $d->getTimestamp();
    }
    function lastDayOfMonth(){
        $d=new Date(date('Y-m-t 00:00:00',$this->getTimestamp()));
        return $d->getTimestamp();
    }
    
}