<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initViewHelpers() {
    	$this->bootstrap('view');
    	$this->bootstrap('layout');
    	$layout = $this->getResource('layout');
    	$view = $layout->getView();    	

    	$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
    	$viewRenderer->setView($view);
    	Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);    	
    }
}