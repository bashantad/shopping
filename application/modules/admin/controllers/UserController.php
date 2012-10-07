<?php

class Admin_UserController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('index', 'index');
        }
    }

    public function indexAction() {
        $userModel = new Admin_Model_User();
        $this->view->result = $userModel->getAll();
    }

    public function addAction() {
        $form = new Admin_Form_UserForm();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                unset($formData['submit']);
                unset($formData["user_id"]);
                try {
                    $userModel = new Admin_Model_User();
                    $userModel->add($formData);
                    $this->_helper->redirector('index');
                } catch (Exception $e) {
                    $this->view->message = $e->getMessage();
                }
            }
        }
    }
    
    public function editAction() {
        
        $form = new Admin_Form_UserForm();
        $form->submit->setLabel("Save");
        $userModel = new Admin_Model_User();
        $id = $this->_getParam('id', 0);
        $data = $userModel->getDetailById($id);
        $form->populate($data);
        $this->view->form = $form;
        try {
            if ($this->getRequest()->isPost()) {
                if ($form->Valid($this->getRequest()->getPost())) {
                    $formData = $this->getRequest()->getPost();

                    $id = $formData['user_id'];
                    unset($formData['user_id']);
                    unset($formData['submit']);

                    $userModel->updateuser($formData, $id);
                    $this->_helper->redirector('index');
                }
            }
        } catch (Exception $e) {
            $this->view->message = $e->getMessage();
        }
    }
    
    public function deleteAction() {
        $id = $this->_getParam('id', 0);
        $userModel = new Admin_Model_User();
        $this->view->id = $id;
        if ($this->getRequest()->isPost()) {
            try {
                $delete = $this->_getParam('delete');
                if ('Yes' == $delete) {
                    $userModel->deleteuser($id);
                }$this->_helper->redirector("index");
            } catch (Exception $e) {
                $this->view->message = $e->getMessage();
            }
        }
    }


}

