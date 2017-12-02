<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DatabaseAdapter {
    
    private $databaseInterface;
    
    private $fromTable;
    
    public function __construct(DatabaseInterface $databaseInterface) {
        $this->databaseInterface = $databaseInterface;
    }
    
    public function setFromTable($fromTable) {
        $this->fromTable = $fromTable;
    }
    
    public function findById($id) {
        $this->databaseInterface->setFromTable($this->fromTable);  
        
        return $this->databaseInterface->select(['id' => $id]);
    }
}