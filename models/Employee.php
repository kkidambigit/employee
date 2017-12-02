<?php

/**
 * Description of Department
 *
 * @author K kiran
 */
class Employee extends Model {
    
    private $empId;
    
    private $firstName;
    
    private $lastName;
        
    private $deptId;
    
    private $mgrId;
    
    private $employeesCount;
    
    private $managersCount;
    
    public function __construct(array $data = []) {        
        foreach($data as $key => $value) { 
            $this->$key = $value;
        }
    }
    
    public function getId() {
        return $this->empId;
    }
    
    public function getFirstName() {
        return $this->firstName;
    }
    
    public function getLastName() {
        return $this->lastName;
    }
    
    public function getDeptId() {
        return $this->deptId;
    }
    
    public function getManagerId() {
        return $this->mgrId;
    }
    
    public function getCount() {
        return $this->employeesCount;
    }
    
    public function getManagerCount() {
        return $this->managersCount;
    }
}