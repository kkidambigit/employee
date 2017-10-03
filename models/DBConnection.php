<?php

//namespace emp_model;

/**
 * Description of DBConnection
 *
 * @author K kiran
 */
final class DBConnection {
    
    const HOST_NAME = 'localhost';
    
    const USER_NAME = 'root';
    
    const PASSWORD = '';
    
    const DATABASE = 'employee_db';
    
    private static $instance;
        
    private $connect;
    
    private function __construct() {
        $this->connect = mysqli_connect(self::HOST_NAME, self::USER_NAME, self::PASSWORD, self::DATABASE);
    }
    
    public static function getInstance(){
        if(empty(self::$instance)) {
            self::$instance = new DBConnection();            
        } 
        
        return self::$instance;
    }

    public function getConnection() {
        
        return $this->connect;
    }
}    
