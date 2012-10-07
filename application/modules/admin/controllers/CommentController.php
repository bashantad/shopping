<?php

class Admin_CommentController extends Zend_Controller_Action {

    public function indexAction() {
        $commentModel = new Admin_Model_Comment();
        $this->view->result = $commentModel->getAll();
    }

    public function addAction() {
        $form = new Admin_Form_CommentForm();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                unset($formData['submit']);
                unset($formData["comment_id"]);
                try {
                    $commentModel = new Admin_Model_Comment();
                    $commentModel->add($formData);
                    $this->_helper->redirector('index');
                } catch (Exception $e) {
                    $this->view->message = $e->getMessage();
                }
            }
        }
    }

    public function editAction() {

        $form = new Admin_Form_CommentForm();
        $form->submit->setLabel("Save");
        $commentModel = new Admin_Model_Comment();
        $id = $this->_getParam('id', 0);
        $data = $commentModel->getDetailById($id);
        $form->populate($data);
        $this->view->form = $form;
        try {
            if ($this->getRequest()->isPost()) {
                if ($form->Valid($this->getRequest()->getPost())) {
                    $formData = $this->getRequest()->getPost();

                    $id = $formData['comment_id'];
                    unset($formData['comment_id']);
                    unset($formData['submit']);

                    $commentModel->updatecomment($formData, $id);
                    $this->_helper->redirector('index');
                }
            }
        } catch (Exception $e) {
            $this->view->message = $e->getMessage();
        }
    }

    public function deleteAction() {
        $id = $this->_getParam('id', 0);
        $commentModel = new Admin_Model_Comment();
        $this->view->id = $id;
        if ($this->getRequest()->isPost()) {
            try {
                $delete = $this->_getParam('delete');
                if ('Yes' == $delete) {
                    $commentModel->deletecomment($id);
                }$this->_helper->redirector("index");
            } catch (Exception $e) {
                $this->view->message = $e->getMessage();
            }
        }
    }

}

