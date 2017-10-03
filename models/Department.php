<?php

/**
 * Description of Department
 *
 * @author K kiran
 */
class Department {
    
    private $tableName = 'departments';
    
    private $id;
    
    private $name;
    
    public function __construct(array $data = []) {
        foreach($data as $key => $value) {
            $this->$key = $value;
        }
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getName() {
        return $this->name;
    }
}