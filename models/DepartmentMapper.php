<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'DataMapper.php';

class DepartmentMapper extends DataMapper {
    
    const ID = 'DeptId';
    
    const NAME = 'DeptName';
    
    public function __construct() {
        $this->tableName = 'departments';
        $this->tableAlias = 'dept';      
        $this->model = 'Department';
        $this->fields = [
            self::ID => $this->tableAlias . '.id', 
            self::NAME => $this->tableAlias . '.name'
            ];
        $this->relations = ['EmployeeMapper' => $this->fields[self::ID]];
        parent::__construct();
    }
}

