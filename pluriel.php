<?php
namespace MVC;

class Pluriel {
    static function pluriel($nb,$mot,$motPluriel=null,$displayNb=true){
        if($nb>1 or $nb<-1){
            if(is_null($motPluriel)){
                $motPluriel=$mot.'s';
            }
            
            $return = $motPluriel;
        }else{
            $return = $mot;
        }
        if($displayNb){
            $return=$nb.' '.$return;
        }
        return $return;
    }
}