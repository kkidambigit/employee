<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MysqliQueryBuilder {
    
    private $fromTable;
    
    private $innerJoin;
    
    private $leftJoin;
    
    private $groupBy;
    
    private $andCondition;
    
    private $selectColumns = '*';
    
    private $where = null;
    
    private $params = [];
    
    private $dontParameterise = [];
    
    public function __construct() {
    }
    
    public function setFromTable($fromTable) {
        $this->fromTable = $fromTable;        
    }
    
    public function setSelect($columns) {
        $this->selectColumns = $columns;        
    }
    
    public function setInnerJoin(array $innerJoin) {        
        $this->innerJoin = $innerJoin;
    }
    
    public function setLeftJoin(array $leftJoin) {        
        $this->leftJoin = $leftJoin;
    }
    
    public function setGroup($groupBy) {        
        $this->groupBy = $groupBy;
    }
    
    public function setAndCondition($andCondition) {
        $this->andCondition = $andCondition;
    }
    
    public function setDontParameterise($param) {        
        array_push($this->dontParameterise, $param);
    }
    
    public function getSelect() {
        return $this->selectColumns;
    }
    
    public function getParams() {
        return $this->params;
    }
    
    public function buildSelect() {
        $sql = "SELECT " . $this->selectColumns . " FROM " . $this->fromTable;
        if(count($this->innerJoin) > 0) {
            foreach($this->innerJoin as $joinTable => $joinCondition) {
                $sql .= " INNER JOIN " . $joinTable . " ON " . $joinCondition;
            }
        }
        if(count($this->leftJoin) > 0) {
            foreach($this->leftJoin as $joinTable => $joinCondition) {
                $sql .= " LEFT JOIN " . $joinTable . " ON " . $joinCondition;
            }
        }
        if(count($this->andCondition) > 0) {
            $this->buildAndCondition();
        }
        
        if(!empty($this->where)) {
            $sql .= " WHERE " . $this->where;
        }
        if(!empty($this->groupBy)) {
            $sql .= " GROUP BY " . $this->groupBy;
        }

        return $sql;
    }
    
    private function buildAndCondition() {
        foreach($this->andCondition as $key => $value) {
            if(!empty($this->where)) {
                $this->where .= ' AND ';
            }
            if($value instanceof MysqliQueryBuilder) {
                $this->where .= $key . '(' . $value->buildSelect() . ')';
                array_merge($this->params, $value->params);
            } else if(in_array($value, $this->dontParameterise)) {
                $this->where .= $key . ' ' . $value;
            } else {
                $this->where .= $key . ' ? ';
                array_push($this->params, $value);
            }            
        }        
    }
}
