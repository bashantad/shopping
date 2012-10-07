<?php

class Admin_Model_Book {

    protected $_dbTable;

    public function setDbTable($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable() {
        if (null === $this->_dbTable) {
            $this->setDbTable('Admin_Model_DbTable_Book');
        }
        return $this->_dbTable;
    }

    public function add($formData) {
        $formData['created_on'] = date("Y-m-d");
        $lastId = $this->getDbTable()->insert($formData);
        var_dump($formData);
        if (!$lastId) {
            throw new Exception("Couldn't insert data into database");
        }
        return $lastId;
    }

    public function getAll() {
        $db = Zend_Db_Table::getDefaultAdapter();
        $select = $db->select();
        $select->from(array("bo" => "eshop_book"), array("bo.*"))
                ->joinLeft(array("us" => "eshop_users"), "bo.user_id=us.user_id", array("us.name as user_name"))
                ->where("bo.del='N'");
        $results = $db->fetchAll($select);
        return $results;
    }

    public function getDetailById($id) {
        $row = $this->getDbTable()->fetchRow("book_id='$id'");

        if (!$row) {
            throw new Exception("Couldn't fetch such data");
        }
        return $row->toArray();
    }
    
    
    public function updatecategory($formData, $id) {
        $this->getDbTable()->update($formData, "book_id='$id'");
    }

    public function deletecategory($id) {
        $data["del"] = "Y";
        try {
            $this->getDbTable()->update($data, "book_id='$id'");
        } catch (Exception $e) {
            var_dump($e->getMessage());
            exit;
        }
    }


  

}

