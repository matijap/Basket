<?php

require_once 'Zend/Db/Table.php';


class Core_Row extends Zend_Db_Table_Row_Abstract {

  protected $constraintObjects = array();
  
  public function __get($key) {
    if ($this->_isForeignKeyColumn($key)) {
      //If coulmn is object, we will return object
      if (!array_key_exists($key, $this->constraintObjects)) {
        $this->constraintObjects[$key] = $this->_getConstraintObjectForCoulmn($key);
      }
      return $this->constraintObjects[$key];
    } else {
      //If not, just return column value
      return parent::__get($key);
    }
  }


  public function __set($key, $value) {
    if ($this->_isForeignKeyColumn($key)) {
      $this->_setConstraintObjectForCoulmn($key,$value);
    } else {
      if (($fkAttr = $this->_getConstraintObjectAttribute($key)) && $value != $this->_data[$key]) {
        $this->_setConstraintObjectForCoulmn($fkAttr,null);
      }
      if ($this->_data[$key] != $value) {
        parent::__set($key,$value);  
      }      
    }
  }

  //moja funkcija nasledjena
  public function __isset($key) {
    return $this->_isForeignKeyColumn($key) ? isset($this->constraintObjects[$key]) : parent::__isset($key);
  }
  
  //moja funkcija
  public function __unset($key) {
    if ($this->_isForeignKeyColumn($key)) {
      unset($this->constraintObjects[$key]);
      return $this;
    } else {
      return parent::__unset($key);
    }
  }

  //moja funkcija
  protected function _isForeignKeyColumn($column) {
    return array_key_exists($column,$this->_getReferenceMapForTable());
  }
  
  //moja funkcija
  protected function _getReferenceMapForTable() {
    $referenceMap = $this->getTable()->info(Zend_Db_Table::REFERENCE_MAP);
    return $referenceMap ? $referenceMap : array();
  }
  
  //moja funkcija
  protected function _getReferenceMapForColumn($column) {
    $referenceMap = $this->getTable()->info(Zend_Db_Table::REFERENCE_MAP);
    return $referenceMap[$column] ? $referenceMap[$column] : null;
  }

  //moja funkcija
  protected function _getConstraintObjectAttribute($column) {
    foreach ($this->_getReferenceMapForTable() as $constraintKey => $constraintInfo) {
      if (in_array($column,(array) $constraintInfo[Zend_Db_Table::COLUMNS])) {
        return $constraintKey;
      }
    }
    return null;
  }
  
  //moj funkcija
  protected function _getConstraintObjectForCoulmn($column) {
    $objectInfo = $this->_getReferenceMapForColumn($column);
    return isset($objectInfo) ? $this->findParentRow($objectInfo['refTableClass'], $column) : null;
  }

  protected function _setConstraintObjectForCoulmn($column,$object) {
    //If object is null we will unset it.
    if (is_null($object)) {
      unset($this->constraintObjects[$column]);
    } else {
      //If object is not saved in DB, we will throw error
      if (empty($object->_cleanData)) {
        $translate = Zend_Registry::getInstance()->Zend_Translate;
        throw new Exception($translate->_("If you want to save object for foreign key object table must exist in DB first."));
      }
      else {
        //First set object columns, then set object ref columns
        $this->constraintObjects[$column] = $object;
        $objectInfo       = $this->_getReferenceMapForColumn($column);
        $objectColumns    = (array) $objectInfo[Zend_Db_Table::COLUMNS];
        $objectRefColumns = (array) $objectInfo[Zend_Db_Table::REF_COLUMNS];
        for ($i = 0; $i < count($objectColumns); $i++) {
          $objectColumn         = $objectColumns[$i];
          $objectRefColumns     = $objectRefColumns[$i];
          $this->$objectColumn  = $object->$objectRefColumns;
        }
      }
    }
  }
  
  //moja funkcija
  public static function getDefaultValues($columns = array()) {
    return $columns;
  }
   
  //moja funkcija
  protected function _getListOfDepObjects($depClass, $refColumn = null, $select = null) {
    return $this->findDependentRowset($depClass . '_Table', $refColumn, $select);
  }
  
    public static function create($values, $tableName = false)
    {
        try {
            $tableName = $tableName ? $tableName : get_called_class();
            $object    = Core::createNewObject($tableName, $values);
            $object->save();
            return $object;
        } catch (Exception $e) {
            $translate = Zend_Registry::getInstance()->Zend_Translate;
            throw new Exception("Could not create new object instance.");
        }
    }

}
