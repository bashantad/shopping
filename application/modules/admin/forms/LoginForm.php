<?php

class Admin_Form_LoginForm extends Zend_Form {

    public function init() {
        $this->setName("login");
        $this->setMethod('post');

        $this->addElement('text', 'email', array(
            'filters' => array('StringTrim', 'StringToLower'),
            'validators' => array(
                array('StringLength', false, array(0, 150)),
            ),
            'required' => true,
            'label' => 'Email:',
        ));

        $this->addElement('password', 'password', array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 32)),
            ),
            'required' => true,
            'label' => 'Password:',
        ));

        $this->addElement('submit', 'login', array(
            'required' => false,
            'ignore' => true,
            'label' => 'Login',
        ));
    }

}

