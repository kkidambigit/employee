<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class Model {
    
    private $data = [];
    
    public function storeData($name, $value) {
        $this->data[$name] = $value;
    }
    
    public function __call($name, $arg) {  
        return $this->data[$name];
    }
}