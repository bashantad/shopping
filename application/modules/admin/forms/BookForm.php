<?php

class Admin_Form_BookForm extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        
        $book = new Zend_Form_Element_Hidden("book_id");
        
        
        $userModel = new Admin_Model_User;
        $option = $userModel->getKeysAndValues();
        
        $user = new Zend_Form_Element_Select("user_id");
        $user->setLabel("User:")
               ->addMultiOptions($option)
               ->setAttribs(array('class'=> 'form-select'))
               ->setRequired(true);
//        
//        $productModel = new Admin_Form_ProductForm();
//        $option1 = $productModel->getKeysAndValues();
//        
//        $product = new Zend_Form_Element_Select("product_id");
//        $product->setLabel("Product")
//                ->addMultiOptions($option1)
//                ->setAttribs(array('class'=>'form-select'))
//                ->setRequired(true);
//        
       $submit = new Zend_Form_ELement_Submit("submit");
       $submit->setLabel("Submit");
       
       $this->addElements(array($book,$user,$submit));
    }


}

