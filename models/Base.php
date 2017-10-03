<?php

/**
 * Description of Base
 *
 * @author K kiran
 */
class Base {
    
    private $mysqliStatement;
    
    public function __construct() {
        $this->mysqliStatement = new MysqliStatement();
    }
    
    public function get() {
        $sql = "select * from ";
    }
    
    public function getAll() {
        
    }
}
