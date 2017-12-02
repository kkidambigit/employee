<?php

/**
 * Description of Department
 *
 * @author K kiran
 */
class Department extends Model {
    
    private $deptId;
    
    private $deptName;
    
    public function __construct(array $data = []) {
        foreach($data as $key => $value) {
            $this->$key = $value;
        }
    }
    
    public function getId() {
        return $this->deptId;
    }
    
    public function getName() {
        return $this->deptName;
    }
}