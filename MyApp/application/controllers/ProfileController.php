<?php

class ProfileController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        
    	$auth = Zend_Auth::getInstance();    	
    	$this->view->identity = $auth->getIdentity ();    	 
   	 
    	$guid = $this->_request->getParam('guid');
    	
    	if (empty($guid)) {
    	    if ($auth->hasIdentity()) {
    	    	$guid = $auth->getIdentity()->GUID;    	
        	}
     	}	
     	
     	$this->view->guid = $guid;     	
     	
        if (!null == $guid) {
        	$profile = new Application_Model_Profile($guid);
        	$this->view->firstName = $profile->getFirstName();
        	$this->view->lastName = $profile->getLastName();
        	$this->view->xml = $profile->getXML();
        }
        

    }


}

