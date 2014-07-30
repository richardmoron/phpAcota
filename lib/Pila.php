<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pila
 *
 * @author z1174697
 */
class Pila {
    
    private $pila;
    private $index = 0;
    private $length = 0;
    public function __construct() {
        $this->pila = new ArrayObject();
        $this->index = 0;
        $this->length = 0;
    }

    function set($elem){
        $this->index++;
        $this->length++;
        $this->pila->offsetSet($this->index, $elem);
    }

    function get() {
        if($this->index > 0){
            $value = $this->pila->offsetGet($this->index);
            $this->pila->offsetUnset($this->index);
            $this->index--;
            $this->length--;

            return $value;
        }
        return null;
    }

    function exists($elem){
        $i = 1;
        while($i<=$this->index) {
            $value = $this->pila->offsetGet($i);
            if($elem == $value )
                return true;
            $i++;
        }
        return false;
    }

    function lenght(){
        return $this->length;
    }
}
?>
