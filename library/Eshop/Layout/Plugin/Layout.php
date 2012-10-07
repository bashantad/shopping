<?php

class Eshop_Layout_Plugin_Layout extends Zend_Controller_Plugin_Abstract {

    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $module = $request->getModuleName();

        $options = array(
            'layoutPath' => APPLICATION_PATH . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . $module,
        );
        Zend_Layout::startMvc()->setLayoutPath($options);
    }

}