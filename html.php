<?php

namespace MVC;

class HTML {

    private $_tag;
    private $_attributs;
    private $_content;

    public function __construct($tag, $attributs = array(), $content = array()) {
        $this->_tag = $tag;
        $this->_attributs = $attributs;
        $this->_content = $content;
    }

    public function __toString() {
        $html = '<' . $this->_tag;
        foreach ($this->_attributs as $key => $value) {
            $html.=' ' . $key.='="' . $value . '"';
        }
        if (sizeof($this->_content) == 0) {
            $html.=' />';
        } else {
            $html.='>';
            foreach ($this->_content as $child) {
                $html.=$child;
            }
            $html.='</' . $this->_tag . '>';
        }
        return $html;
    }
    
    public function __set($key,$value){
        return $this->_attributs[$key]=$value;
    }
    
    public function add(HTML $child){
        $this->_content[]=$child;
    }
}
