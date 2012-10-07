<?php

class Admin_Model_Product {

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
            $this->setDbTable('Admin_Model_DbTable_Product');
        }
        return $this->_dbTable;
    }

    public function add($formData) {
        $formData['created_on'] = date("Y-m-d");
        $lastId = $this->getDbTable()->insert($formData);
        if (!$lastId) {
            throw new Exception("Couldn't insert data into database");
        }
        return $lastId;
    }

    public function getAll() {
        $db = Zend_Db_Table::getDefaultAdapter();
        $select = $db->select();
        $select->from(array("pro" => "eshop_products"), array("pro.*"))
                ->joinLeft(array("ca" => "eshop_category"), "pro.category_id=ca.category_id", array("ca.name as category_name"))
                ->where("pro.del='N'");
        $results = $db->fetchAll($select);
        return $results;
    }

    public function getKeysAndValues() {
        $results = $this->getDbTable()->fetchAll("del='N'");
        $options = array('' => '--Select--');
        foreach ($results as $result) {
            $options[$result['product_id']] = $result['name'];
        }
        return $options;
    }

    public function getDetailById($id) {
        $row = $this->getDbTable()->fetchRow("product_id='$id'");

        if (!$row) {
            throw new Exception("Couldn't fetch such data");
        }
        return $row->toArray();
    }

    public function updateproduct($formData, $id) {
        $this->getDbTable()->update($formData, "product_id='$id'");
    }

    public function deleteproduct($id) {
        $data["del"] = "Y";
        try {
            $this->getDbTable()->update($data, "product_id='$id'");
        } catch (Exception $e) {
            var_dump($e->getMessage());
            exit;
        }
    }

}
