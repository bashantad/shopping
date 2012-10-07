<?php

class Admin_Form_ShopForm extends Zend_Form {

    public function init() {
        $this->setMethod('post');
        //$this->setAction('add');
        $shopId = new Zend_Form_Element_Hidden('shop_id');
        
        $phone = new Zend_Form_Element_Text('phone');
        $phone->setLabel('phone: ')
                ->setAttribs(array('size'=>30,'class'=>'form-text'))
                ->addValidator('StringLength', false, array(0, 10))
                ->setRequired(true);
        
        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Name: ')
                ->setAttribs(array('size'=>30,'class'=>'form-text'))
                ->setRequired(true);

        $address = new Zend_Form_Element_Text('address');
        $address->setLabel('Address: ')
                ->setAttribs(array('size'=>30,'class'=>'form-text'))
                ->setRequired(true);
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel("Add")
                ->setIgnore(true)
                ->setAttribs(array('size'=>30,'class'=>'form-text'));

        $this->addElements(array($shopId, $name, $address,  $phone, $submit));
    }

}

