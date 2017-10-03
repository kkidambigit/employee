<?php

/**
 * Description of MysqliStatement
 *
 * @author K kiran
 */

require_once('models/DBConnection.php');

class MysqliStatement {
    
    private $connect;
    
    private $stmt;
    
    private $params = [];
    
    public function __construct() {
        $this->connect = DBConnection::getInstance()->getConnection();
    }
    
    public function setParams(array $params) {
        $paramType = '';
        for($i = 1; $i<=count($params); $i++) {
            $paramType .= 's';
        }
        array_push($this->params, $paramType);
        foreach($params as $val) {
            array_push($this->params,$val);
        }
    }
    
    public function execute(string $sql) {
        $rows = [];
        
        $this->stmt = $this->mysqli->prepare($sql);
        if(count($this->params) > 0) {
            call_user_func_array(array($this->stmt,'bind_param'), $this->refValues($this->params));
        }
        $this->stmt->execute();
        $res = $this->stmt->get_result();        
        while($row = $res->fetch_array(MYSQLI_ASSOC)) {
            array_push($rows, $row);
        }
            
        return $rows;       
    }
    
    private function refValues($arr){
        $result = [];
        if (strnatcmp(phpversion(),'5.3') >= 0) { //Reference is required for PHP 5.3+        
            $refs = array();
            foreach($arr as $key => $value) {
                $refs[$key] = &$arr[$key];//$value keeps on changing hence, can't be used for reference.
            }
            $result = $refs;
        } else {
            $result = $refs;
        }
        
        return $result;
    }
}