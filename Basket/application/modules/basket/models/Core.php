<?php

class Core {
    
    protected static $loadedObjects = array();
    
    public static function createNewObject($objectName, $objData = array()) {
        //Include object table class if not included
        $objectTable    = self::includeObjectTable($objectName);
        //Get all columns for object
        $objectColumns  = $objectTable->info(Zend_Db_Table_Abstract::COLS);

        $dataToInsert   = array_intersect_key($objData, array_fill_keys($objectColumns,1));
        self::includeObject($objectName);
        return $objectTable->createRow($objectName::getDefaultValues($dataToInsert));
    }
    
    public static function includeObject($objectName) {
        if (!class_exists($objectName)) {
        require_once "$objectName.php";
        }
    }
  
    public static function includeObjectTable($object) {
        //If we do not have object in tables array, we will add it and then return it, if there is already we will return it right away
        return array_key_exists($object,self::$loadedObjects) ? self::$loadedObjects[$object] : self::setObjectInTable($object);
    }
  
    public static function setObjectInTable($object) {
        //First we need to require object table class if not included
        $objectTable = $object . "_Table";
        if (!class_exists($objectTable)) {
        require_once "$object/Table.php";
        }
        //Add object table into tables array
        self::$loadedObjects[$object] = new $objectTable();
        //Return object table
        return self::$loadedObjects[$object];
    }
  
    public static function getObjectSelect($object) {
        $objectTable = self::includeObjectTable($object);
        return $objectTable->select();
    }
  
    public static function getBasicSelect() {
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        return $dbAdapter->select();
    }
  
    public static function execQuery($querySql, $params = array()) {
        $dbAdapter  = Zend_Db_Table::getDefaultAdapter();
        $query      = $dbAdapter->query($querySql, $params);
        $query->closeCursor();
        return $query;
    }
  
    public static function getRowCount($select) {
        $dbAdapter  = Zend_Db_Table::getDefaultAdapter();
        $rowColumns = array('COUNT(*) as numberOfItems');

        $select->columns($rowColumns);
        $result = $dbAdapter->query($select)->fetchAll();
        $count = 0;
        foreach ($result as $row) {
          $count += $row['numberOfItems'];
        }
        return $count;
    }
  
    public static function getObjects($objectName, $additionalSelect = null) {
        $objectTable = self::includeObjectTable($objectName);
        return $objectTable->fetchAll($additionalSelect);
    }
  
    //moja funkcija
    public static function getObjectRow($objectName, $objectSelect = null) {
        $objectTable = self::includeObjectTable($objectName);
        return $objectTable->fetchRow($objectSelect);
    }
  
    //moja funkcija
    public static function buildObject($object, $objectID) {
        $objectTable = self::includeObjectTable($object);
        return $objectTable->find($objectID)->current();
    }
}