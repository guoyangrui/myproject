<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body    	
    	$auth = Zend_Auth::getInstance();
    	
    	if ($auth->hasIdentity()) {
    		$this->view->identity = $auth->getIdentity();
    	}    	 
    }

    public function bugReportAction()
    {
        // action body
    }

    public function listAction()
    {
        // action body
    }

    public function viewAction()
    {
        // action body
    }


}







