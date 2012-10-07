<?php

class Admin_Form_CategoryForm extends Zend_Form {

    public function init() {
        $this->setMethod('post');

        $category = new Zend_Form_Element_Hidden("category_id");

        $name = new Zend_Form_Element_Text("name");
        $name->setLabel("Add Name")
                ->setAttribs(array('class' => 'form-text', 'size' => '50'))
                ->setRequired(true);


        $shopmodel = new Admin_Model_Shop();
        $option = $shopmodel->getKeysAndValues();


        $shop = new Zend_Form_Element_Select("shop_id");
        $shop->setLabel("Shop:")
                ->addMultiOptions($option)
                ->setAttribs(array('class' => 'form-select'));


        $categoryModel = new Admin_Model_Category();
        $option1 = $categoryModel->getKeysAndValues();

        $parent = new Zend_Form_Element_Select("parent_id");
        $parent->setLabel("Parent Category:")
                ->addMultiOptions($option1);


        $submit = new Zend_Form_Element_Submit("submit");
        $submit->setLabel("Submit");

        $this->addElements(array($category, $name, $parent, $shop, $submit));
    }

}

