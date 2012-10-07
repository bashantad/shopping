<?php

class Admin_ProductController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('index', 'index');
        }
    }

    public function indexAction() {
        $productModel = new Admin_Model_Product();
        $this->view->results = $productModel->getAll();
    }

    public function addAction() {
        $form = new Admin_Form_ProductForm();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
//            if ($form->image->receive()) {
//                var_dump("file uploaded");
//            }
            //var_dump($formData); exit;
            if ($form->isValid($formData)) {

               $image = $formData["image"] = $form->image->getFileName();
                $exp = explode(DIRECTORY_SEPARATOR, $image);
                $formData['image'] = $exp[sizeof($exp)-1];
                unset($formData['submit']);
                unset($formData["product_id"]);
                unset($formData["MAX_FILE_SIZE"]);
//                var_dump($formData);
//                exit;
                try {
                    $productModel = new Admin_Model_Product();
                    $productModel->add($formData);
                    // $this->_helper->redirector('index');
                } catch (Exception $e) {
                    $this->view->message = $e->getMessage();
                }
            }
        }
    }

    public function editAction() {

        $form = new Admin_Form_ProductForm();
        $form->submit->setLabel("Save");
        $productModel = new Admin_Model_Product();
        $id = $this->_getParam('id', 0);
        $data = $productModel->getDetailById($id);
        $form->populate($data);
        $this->view->form = $form;
        try {
            if ($this->getRequest()->isPost()) {
                if ($form->Valid($this->getRequest()->getPost())) {
                    $formData = $this->getRequest()->getPost();

                    $id = $formData['product_id'];
                    unset($formData['product_id']);
                    unset($formData['submit']);

                    $productModel->updateproduct($formData, $id);
                    $this->_helper->redirector('index');
                }
            }
        } catch (Exception $e) {
            $this->view->message = $e->getMessage();
        }
    }

    public function deleteAction() {
        $id = $this->_getParam('id', 0);
        $productModel = new Admin_Model_Product();
        $this->view->id = $id;
        if ($this->getRequest()->isPost()) {
            try {
                $delete = $this->_getParam('delete');
                if ('Yes' == $delete) {
                    $productModel->deleteproduct($id);
                }$this->_helper->redirector("index");
            } catch (Exception $e) {
                $this->view->message = $e->getMessage();
            }
        }
    }

}

?>
