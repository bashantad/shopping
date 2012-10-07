<?php

class Admin_Model_Comment {

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
            $this->setDbTable('Admin_Model_DbTable_Comment');
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
        $select->from(array("co" => "eshop_comments"), array("ur.*"))
               ->joinLeft(array("us" => "eshop_users", "co.user_id=us.user_id", array("user.name as user_name")))
               ->where("co.del='N'");
        $results = $db->fetchAll($select);
        return $results;
    }

    public function getKeysAndValues() {
        $results = $this->getDbTable()->fetchAll("del='N'");
        $options = array('' => '--Select--');
        foreach ($results as $result) {
            $options[$result['comment_id']] = $result['name'];
        }
        return $options;
    }

    public function getDetailById($id) {
        $row = $this->getDbTable()->fetchRow("comment_id='$id'");

        if (!$row) {
            throw new Exception("Couldn't fetch such data");
        }
        return $row->toArray();
    }

    public function updatecomment($formData, $id) {
        $this->getDbTable()->update($formData, "comment_id='$id'");
    }

    public function deletecomment($id) {
        $data["del"] = "Y";
        try {
            $this->getDbTable()->update($data, "comment_id='$id'");
        } catch (Exception $e) {
            var_dump($e->getMessage());
            exit;
        }
    }

}

