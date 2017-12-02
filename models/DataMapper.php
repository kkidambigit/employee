<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DataMapper {

    protected $query;
    
    protected $tablename;
    
    protected $tableAlias;
    
    protected $selectColumns;
    
    protected $fields;
    
    protected $relations;
      
    protected $model;
    
    protected $relationMappers = [];
    
    protected $relationType = [];
    
    protected $combinedFields = [];
    
    public function __construct() {
        $this->query = new MysqliQueryBuilder();
        $this->query->setFromTable($this->tableName . ' ' . $this->tableAlias);
        $this->combinedFields[] = $this->fields;
    }
    
    protected function getQueryBuilder() {
        return $this->query;
    }
    
    public function with(array $relMappers) {
        $this->setRelationMappers($relMappers, 'InnerJoin');
    }
    
    public function withLeft(array $relMappers) {
        $this->setRelationMappers($relMappers, 'LeftJoin');
    }
    
    protected function setRelationMappers(array $relMappers, $joinName) {
        $join = [];
        $class = get_class($this);
        foreach($relMappers as $alias => $relMapper) {
            $relationMapper = new $relMapper($alias);
            $relationMapperClass = get_class($relationMapper);
            if(is_string($alias)) { //Refactor , check if mapDynamicFields is necessary
                $relationMapper->tableAlias = $alias;
                $this->mapDynamicFields($relationMapper);
            }
            $this->relationMappers[] = $relationMapper;
            if(!array_key_exists($joinName, $this->relationType)) {
                $this->relationType[$joinName] = [];
            }
            $this->relationType[$joinName][] = $relationMapper;
            $this->combinedFields[] = $relationMapper->fields;
            $joinTable = $relationMapper->tableName . ' ' . $relationMapper->tableAlias;
            if($class === $relationMapperClass) {
                $joinCondition = $this->relations[$relationMapperClass] . ' = ' 
                    . $relationMapper->tableAlias . '.' . 'id';
            } else {
                $joinCondition = $this->relations[$relationMapperClass] . ' = ' . $relationMapper->relations[$class];
            }
            $join[$joinTable] = $joinCondition;
            $joinType = 'set' . $joinName;
            $this->query->$joinType($join);
        }
    }        
    
    protected function mapDynamicFields(DataMapper $mapper) {
        $newFieldAlias = [];
        foreach($mapper->fields as $oldAliasName => $colName) {
            $colNameArray = explode('.', $colName);
            $newFieldAlias[ucfirst($mapper->tableAlias) . $oldAliasName] = $mapper->tableAlias . '.' . $colNameArray[1];
        }        
        $mapper->fields = $newFieldAlias;
    }
    
    public function group($fieldName) {           
        $group = $this->getFieldAlias($fieldName); 
        $this->query->setGroup($group);
    }
    
    public function fieldsWithMapper(array $mappers) {
        foreach($mappers as $alias => $mapper) {
            if($mapper instanceof DataMapper) {
                $subQuery = '(' . $mapper->query->buildSelect() . ') ' . $alias;
            }
            $this->relationMappers[] = $mapper;
        }
        $select = $this->query->getSelect();
        $select .= ', ' . $subQuery;
        $this->query->setSelect($select);
    }
    
    public function fields(array $selectedFields) {
        $select = '';
        foreach ($selectedFields as $selectedFieldName) {
            $columnName = $this->getFieldAlias($selectedFieldName) . ' ' . $selectedFieldName;
            $select = ($select == '' ? $columnName : $select . ', ' . $columnName);
        }
        $this->query->setSelect($select);
    }
    
    public function equals($fieldName, $fieldValue) {
        $condition = [];
        $condition[$this->getFieldAlias($fieldName) . ' = '] = $fieldValue;
        
        return $condition;
    }
    
    public function greaterThan($fieldName, $fieldValue) {
        $condition = [];
        $condition[$this->getFieldAlias($fieldName) . ' > '] = $fieldValue;
        
        return $condition;
    }
    
    public function lessThan($fieldName, $fieldValue) {
        $condition = [];
        if($fieldValue instanceof DataMapper) {
            $condition[$this->getFieldAlias($fieldName) . ' < '] = $fieldValue->getQueryBuilder();
        } else {
            $condition[$this->getFieldAlias($fieldName) . ' < '] = $fieldValue;
        }
        return $condition;
    }
    
    private function getFieldAlias($fieldName) {
        $fieldAlias = null;
        foreach($this->combinedFields as $key => $fields) {
            if (array_key_exists($fieldName, $fields)) {
                $fieldAlias = $fields[$fieldName];
                break;
            }
        } 
        if($fieldAlias === null) {
            $fieldAlias = $fieldName;
        }
        
        return $fieldAlias;        
    }
    
    public function equalsRelation($relationMapperName) {
        $result = $this->getRelationFieldAliases($relationMapperName); //throw exception if field not found.
        $this->query->setDontParameterise($result['relationFieldAlias']);
        
        return $this->equals($result['fieldAlias'], $result['relationFieldAlias']);
    }
    
    public function getRelationFieldAliases($relationMapperName) {
        $result['fieldAlias'] = $this->relations[$relationMapperName];
        $relationMapper = new $relationMapperName();
        $result['relationFieldAlias'] = $relationMapper->relations[get_class($this)];
  
        return $result;
    }
    
    public function andCondition(array $andCondition) {
        $condition = [];
        foreach($andCondition as $key => $val) {
            foreach($val as $fieldCondition => $conditionValue) {
                $condition[$fieldCondition] = $conditionValue;
            }
        }
        $this->query->setAndCondition($condition);
    }

    /*public function findById($id) {
        $condition = [$this->tableAlias . '.id' => $id];
        $sql = $this->buildSelect($condition);
        $db = new DatabaseMysqli();
        $row = $db->find($sql, $params);

        return $this->mapRow($row);
    }*/

    public function findAll() {
        $sql = $this->query->buildSelect();
        $db = new DatabaseMysqli();
        $rows = $db->execute($sql, $this->query->getParams());

        return $this->mapRows($rows);
    }

    /*protected function mapRow($rows) {
        $result = '';
        $mapperModel = $this->model;
        foreach ($rows as $key => $row) {
            $model = new $mapperModel($row);
            $result = $model;
        }

        return $result;
    }*/

    protected function mapRows($rows) {
        $result = [];
        foreach ($rows as $key => $row) {
            $model = $this->populateModel($row, $this);
            foreach($this->relationMappers as $key => $relationMapper) {                
                $class = get_class($this);
                $relationClass = get_class($relationMapper);
                $key = ($class === $relationClass?$relationMapper->tableAlias:lcfirst($relationMapper->model));
                $dynamic = ($class === $relationClass?true:false);
                $relationModel = $this->populateModel($row, $relationMapper, $dynamic);
                $model->storeData($key, $relationModel);
            }
            $result[] = $model;            
        }
        
        return $result;
    }

    protected function populateModel($row, $mapper, $dynamic = false) {        
        $model = null;
        $modelData = [];
        $modelName = $mapper->model;
        $rowFieldNames = array_keys($row);
        foreach ($rowFieldNames as $rowFieldName)  {
            if (array_key_exists($rowFieldName, $mapper->fields)) {
                $modelFieldName = $rowFieldName;
                if($dynamic === true) {
                    $modelFieldName = $this->deriveDynamicField($rowFieldName);
                }  
                $modelData[lcfirst($modelFieldName)] = $row[$rowFieldName];
            }            
        } 
        if(count($modelData) > 0) {
            $model = new $modelName($modelData);
        }
        
        return $model;
    }
    
    protected function deriveDynamicField($dynamicField) {        
        foreach($this->fields as $fieldName => $columnName) {
            if(stristr($dynamicField, $fieldName) !== false) {
                return $fieldName;
            }
        }
    }
}