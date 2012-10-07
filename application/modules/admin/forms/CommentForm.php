<?php

class Admin_Form_CommentForm extends Zend_Form
{

    public function init()
    {
        $this->setMethod('Post');
        
        $comment = new Zend_Form_Element_Hidden('comment_id');
        
        $productmodel = new Admin_Model_Product();
        $option = $productmodel->getKeysAndValues();


        $product = new Zend_Form_Element_Select("product_id");
        $product->setLabel("Product:")
                ->addMultiOptions($option)
                ->setAttribs(array('class' => 'form-select'))
                ->setRequired(true);
        
         
        $userModel = new Admin_Model_User;
        $option = $userModel->getKeysAndValues();
        
        $user = new Zend_Form_Element_Select("user_id");
        $user->setLabel("User:")
               ->addMultiOptions($option)
               ->setAttribs(array('class'=> 'form-select'))
               ->setRequired(true);
        
        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('Title:')
              ->setAttribs(array('size'=>'30', 'class'=>'form-select'))
              ->setRequired(true);
        
        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Name:')
             ->setAttribs(array('size'=>'30', 'class'=>'form-select'))
             ->setRequired(true);
        
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email:')
              ->setAttribs(array('size'=>'30', 'class'=>'form-select'))
              ->setRequired(true);
        
        $description = new Zend_Form_Element_Textarea('description');
        $description->setLabel('Description:')
                    ->setAttribs(array('size'=>'30', 'class'=>'form-select'))
                    ->setRequired(true);
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel("Submit");
        
        $this->addElements(array(
                    
                    $comment,
                    $user,
                    $title,
                    $name,
                    $email,
                    $description,
                    $submit
                    
        ));


    }


}

