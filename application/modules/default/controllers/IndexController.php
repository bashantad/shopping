<?php

class Default_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $categoryModel = new Admin_Model_Category();
        $this->view->categories = $categoryModel->fetchHierarchy();
    }

    public function indexAction()
    {
        
    }


}

