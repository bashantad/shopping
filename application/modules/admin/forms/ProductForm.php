<?php

class Admin_Form_ProductForm extends Zend_Form {

    public function init() {

        //$this->setMethod('post');
        $this->setAttrib('enctype', 'multipart/form-data');
        //product id
        $productID = new Zend_Form_ELement_Hidden("product_id");
        
        $categorymodel = new Admin_Model_Category();
        $option = $categorymodel->getKeysAndValues();;

        $category = new Zend_Form_Element_Select("category_id");
        $category->setLabel("Category:")
                ->addMultiOptions($option)
                ->setAttribs(array('class' => 'form-select'))
                ->setRequired(true);

        $name = new Zend_Form_Element_Text('name');
        $name->setLabel("Name")
                ->setAttribs(array('class' => 'form-text', 'size' => '50'))
                ->setRequired(true);

        $image = new Zend_Form_Element_File('image');
        $image->setLabel('Image Upload:')
                ->setDestination(UPLOAD_PATH)
//                ->addValidator('Count',false,1)
//                ->addValidator('Size',false, 1024000)
//                ->addValidator('Extension',false,'jpg,jpeg,png,gif')
                ->setDescription('Click Browse and click on the image file you would like to upload');
      
        $description = new Zend_Form_Element_Textarea('description');
        $description->setLabel('Description:')
                ->setRequired(true)
                ->setAttribs(array('class' => 'form-text', 'rows' => '4', 'columns' => '50'));

        $price = new Zend_Form_Element_Text('price');
        $price->setLabel('Price:')
                ->setRequired(true)
                ->addValidator('digits');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Submit');

        $this->addElements(array($productID, $category, $name, $image, $description, $price, $submit));
    }

}

