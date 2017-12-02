<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'DataMapper.php';

class EmployeeMapper extends DataMapper {
    
    const ID = 'EmpId';
    
    const FIRST_NAME = 'FirstName';
    
    const LAST_NAME = 'LastName';
    
    const DEPT_ID = 'DeptId';
    
    const MGR_ID = 'MgrId';
    
    const EMPLOYEES_COUNT = 'EmployeesCount';
    
    const MANAGERS_COUNT = 'ManagersCount';
    
    public function __construct() {
        $this->tableName = 'employees';
        $this->tableAlias = 'emp';
        $this->model = 'Employee';
        $this->fields = [
            self::ID => $this->tableAlias . '.id', 
            self::FIRST_NAME => $this->tableAlias . '.first_name', 
            self::LAST_NAME => $this->tableAlias . '.last_name',
            self::DEPT_ID => $this->tableAlias . '.dept_id', 
            self::MGR_ID => $this->tableAlias . '.manager_id',
            self::EMPLOYEES_COUNT => 'count(' . $this->tableAlias . '.id)', 
            self::MANAGERS_COUNT => 'count(distinct ' . $this->tableAlias . '.manager_id)'
            ];
        //$this->relations = ['EmployeeMapper' => 'manager_id', 'DepartmentMapper' => 'dept_id'];
        $this->relations = [
            'EmployeeMapper' => $this->fields[self::MGR_ID], 
            'DepartmentMapper' => $this->fields[self::DEPT_ID]
            ];
        parent::__construct();
    }
}