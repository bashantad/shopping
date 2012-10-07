<?php

class Admin_Form_UserForm extends Zend_Form
{

    public function init()
    {
       $this->setMethod('Post');
       
       $user = new Zend_Form_Element_Hidden('user_id');
       
       $name = new Zend_Form_Element_Text('name');
       $name->setLabel('Name:')
            ->setAttribs(array('size'=>'30', 'class'=>'form-text' ))
            ->setRequired(true);
       
       $email = new Zend_Form_Element_Text('email');
       $email->setLabel('Email:')
             ->setAttribs(array('size'=>'30', 'class'=>'form-text'))
             ->setRequired(true);
       
       $password = new Zend_Form_Element_Password('password');
       $password->setLabel("Password:")
                ->setAttribs(array('size'=>'30', 'class'=>'form-text'))
                ->setRequired(true);
       
       $phone = new Zend_Form_Element_Text('phone');
       $phone->setLabel("Phone:")
             ->setAttribs(array('size'=>'30', 'class'=>'form-text'))
             ->setRequired(true);
       
       $address = new Zend_Form_ELement_Text('address');
       $address->setLabel("Address:")
               ->setAttribs(array('size'=>'30', 'class'=>'form-text'))
               ->setRequired(true);
       
       $option = array (
           'Admin' => 'Admin',
           'Shopowner' => 'Shopowner',
           'Customer' => 'Customer',
           'General' => 'General'
         );
    
       $usertype = new Zend_Form_Element_Select('usertype');
       $usertype->setLabel( "User Type:")
                ->addMultiOptions($option);
    
       $submit = new Zend_Form_Element_Submit('submit');
       $submit->setLabel("Submit");
       
       $this->addElements(array(
                    $user,
                    $name,
                    $email,
                    $password,
                    $phone,
                    $address,
                    $usertype,
                    $submit
       ));
    }


}

