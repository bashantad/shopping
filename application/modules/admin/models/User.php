<?php

class Admin_Model_User {

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
            $this->setDbTable('Admin_Model_DbTable_User');
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
        $results = $this->getDbTable()->fetchAll("del='N'");
        return $results->toArray();
    }

    public function getKeysAndValues() {
        $results = $this->getDbTable()->fetchAll("del='N'");
        $options = array('' => '--Select--');
        foreach ($results as $result) {
            $options[$result['user_id']] = $result['name'];
        }
        return $options;
    }

    public function getDetailById($id) {
        $row = $this->getDbTable()->fetchRow("user_id='$id'");

        if (!$row) {
            throw new Exception("Couldn't fetch such data");
        }
        return $row->toArray();
    }

    public function updateuser($formData, $id) {
        $this->getDbTable()->update($formData, "user_id='$id'");
    }

    public function deleteuser($id) {
        $data["del"] = "Y";
        try {
            $this->getDbTable()->update($data, "user_id='$id'");
        } catch (Exception $e) {
            var_dump($e->getMessage());
            exit;
        }
    }

}

