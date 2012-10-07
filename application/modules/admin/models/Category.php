<?php

class Admin_Model_Category {

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
            $this->setDbTable('Admin_Model_DbTable_Category');
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
        $select->from(array("ur" => "eshop_category"), array("ur.*"))
                ->joinLeft(array("p" => "eshop_category"), "ur.category_id=p.parent_id", array("p.name as parent_category"))
                ->joinLeft(array("us" => "eshop_shop"), "ur.shop_id=us.shop_id", array("us.name as shop_name"))
                ->where("ur.del='N'");
        $results = $db->fetchAll($select);
        return $results;
    }

    public function getKeysAndValues() {
        $results = $this->getDbTable()->fetchAll("del='N'");
        $options = array('' => '--Select--');
        foreach ($results as $result) {
            $options[$result['category_id']] = $result['name'];
        }
        return $options;
    }

    public function getDetailById($id) {
        $row = $this->getDbTable()->fetchRow("category_id='$id'");

        if (!$row) {
            throw new Exception("Couldn't fetch such data");
        }
        return $row->toArray();
    }

    public function updatecategory($formData, $id) {
        $this->getDbTable()->update($formData, "category_id='$id'");
    }

    public function deletecategory($id) {
        $data["del"] = "Y";
        try {
            $this->getDbTable()->update($data, "category_id='$id'");
        } catch (Exception $e) {
            var_dump($e->getMessage());
            exit;
        }
    }
    public function fetchHierarchy() {
        $refs = array();
        $list = array();

        $db = Zend_Db_Table::getDefaultAdapter();
        $select = $db->select()
                ->from(array("c" => "eshop_category"), array("c.category_id", "c.name", "c.parent_id"))
                ->where("c.del='N'");
        $results = $db->fetchAll($select);
        foreach ($results as $data) {
            $thisref = &$refs[$data['category_id']];

            $thisref['parent_id'] = $data['parent_id'];
            $thisref['name'] = $data['name'];
            if ($data['parent_id'] == 0) {
                $list[$data['category_id']] = &$thisref;
            } else {
                $refs[$data['parent_id']]['children'][$data['category_id']] = &$thisref;
            }
        }
        return substr($this->listToUl($list), 20, -7);
    }

    public function listToUl($arr) {
        $html = '<ul class="listTab">' . PHP_EOL;
        foreach ($arr as $v) {
            $url = "#";
            $url = Zend_Controller_Front::getInstance()->getBaseUrl().$url;
            $html .= "<li><a href=\"$url\">" . $v['name'] . "</a>";
            if (array_key_exists('children', $v)) {
                $html .= $this->listToUl($v['children']);
            }
            $html .= '</li>' . PHP_EOL;
        }
        $html .= '</ul>' . PHP_EOL;

        return $html;
    }

}
