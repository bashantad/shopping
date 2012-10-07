<?php

class Admin_BookController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('index', 'index');
        }
    }

    public function indexAction() {
        $bookModel = new Admin_Model_Book();
        $this->view->result = $bookModel->getAll();
    }

    public function addAction() {
        $form = new Admin_Form_BookForm();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                unset($formData['submit']);
                unset($formData["book_id"]);
                try {
                    $bookModel = new Admin_Model_Book();
                    $bookModel->add($formData);
                    $this->_helper->redirector('index');
                } catch (Exception $e) {
                    $this->view->message = $e->getMessage();
                }
            }
        }
    }

    public function editAction() {

        $form = new Admin_Form_BookForm();
        $form->submit->setLabel("Save");
        $bookModel = new Admin_Model_Book();
        $id = $this->_getParam('id', 0);
        $data = $bookModel->getDetailById($id);
        $form->populate($data);
        $this->view->form = $form;
        try {
            if ($this->getRequest()->isPost()) {
                if ($form->Valid($this->getRequest()->getPost())) {
                    $formData = $this->getRequest()->getPost();

                    $id = $formData['book_id'];
                    unset($formData['book_id']);
                    unset($formData['submit']);

                    $bookModel->updatebook($formData, $id);
                    $this->_helper->redirector('index');
                }
            }
        } catch (Exception $e) {
            $this->view->message = $e->getMessage();
        }
    }

    public function deleteAction() {
        $id = $this->_getParam('id', 0);
        $bookModel = new Admin_Model_Book();
        $this->view->id = $id;
        if ($this->getRequest()->isPost()) {
            try {
                $delete = $this->_getParam('delete');
                if ('Yes' == $delete) {
                    $bookModel->deletebook($id);
                }$this->_helper->redirector("index");
            } catch (Exception $e) {
                $this->view->message = $e->getMessage();
            }
        }
    }

}

