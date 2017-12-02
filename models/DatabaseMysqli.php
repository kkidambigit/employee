<?php

/**
 * Description of MysqliStatement
 *
 * @author K kiran
 */

require_once('models/DBConnection.php');

class DatabaseMysqli {
    
    private $connect;
    
    private $stmt;
    
    private $params = [];
    
    public function __construct() {
        $this->connect = DBConnection::getInstance()->getConnection();
    }
    
    public function setParams(array $params) {
        $paramType = '';
        if(count($params) > 0){
            for($i=1; $i<=count($params); $i++) {
                $paramType .= 's';
            }
            array_push($this->params, $paramType);
            foreach($params as $val) {
                array_push($this->params, $val);
            }
        }
    }
    
    public function execute($sql, $params) {
        echo '<pre>';
        echo $sql;
        //print_r($params);
        $rows = [];
        $this->setParams($params);
        $this->stmt = $this->connect->prepare($sql);
        if(count($this->params) > 0) {
            call_user_func_array(array($this->stmt, 'bind_param'), $this->refValues($this->params));
        }
        $this->stmt->execute();
        $res = $this->stmt->get_result();        
        while($row = $res->fetch_array(MYSQLI_ASSOC)) {
            array_push($rows, $row);
        }
        
        $this->params = null;    
        
        return $rows;       
    }
    
    private function refValues($arr){
        $result = [];
        //if (strnatcmp(phpversion(),'5.3') >= 0) { //Reference is required for PHP 5.3+   
        if(count($arr) > 0) {   //$refs = array();
            foreach($arr as $key => $value) {
                $result[$key] = &$arr[$key];//$value keeps on changing hence, can't be used for reference.
            }
        }   
        
        return $result;
    }
}