<?php

class Admin_ShopController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('index', 'index');
        }
    }

    public function indexAction() {
        $shopModel = new Admin_Model_Shop();
        $this->view->result = $shopModel->getAll();
    }

    public function addAction() {
        $form = new Admin_Form_ShopForm();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                unset($formData['submit']);
                unset($formData["shop_id"]);
                try {
                    $shopModel = new Admin_Model_Shop();
                    $shopModel->add($formData);
                    $this->_helper->redirector('index');
                } catch (Exception $e) {
                    $this->view->message = $e->getMessage();
                }
            }
        }
    }

    public function editAction() {
        $form = new Admin_Form_ShopForm();
        $form->submit->setLabel('Save');
        $shopModel = new Admin_Model_Shop();
        $id = $this->_getParam('id', 0);
        $data = $shopModel->getDetailById($id);
        $form->populate($data);
        $this->view->form = $form;

        try {
            if ($this->getRequest()->isPost()) {
                if ($form->isValid($this->getRequest()->getPost())) {
                    $formData = $this->getRequest()->getPost();

                    $id = $formData['shop_id'];
                    unset($formData['shop_id']);
                    unset($formData['submit']);

                    $shopModel->updateshop($formData, $id);
                    $this->_helper->redirector('index');
                }
            }
        } catch (Exception $e) {
            $this->view->message = $e->getMessage();
        }
    }

    public function deleteAction() {
        $id = $this->_getParam('id', 0);
        $shopModel = new Admin_Model_Shop();
        $this->view->id = $id;
        if ($this->getRequest()->isPost()) {
            try {
                 $delete = $this->_getParam('delete');
                 if('Yes' == $delete){
                $shopModel->deleteshop($id);
                 }
                $this->_helper->redirector('index');
            } catch (Exception $e) {
                $this->view->message = $e->getMessage();
            }
        }
    }

}

