<?php

class StatusController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    	$guid = $this->getRequest()->getParam('guid'); 
    	$display = $this->getRequest()->getParam('display');

    	$options = array('CLASSID' => $this->getRequest()->getParam('classid'),
    			'VERBID' => $this->getRequest()->getParam('verbid'));
    	 
    	$statusMapper = new Application_Model_StatusMapper();    	 
    	$stream = $statusMapper->getByUser($guid, $options);   

    	if ( 'thing' == $display) {
    		$this->view->list  = $statusMapper->getClass($guid, null);
    	}    	
    	else if ( 'action' == $display) {
    		$this->view->list  = $statusMapper->getAction($guid, null);
    	}
    	
    	$this->view->display =$display;
    	$this->view->stream = $stream;
    }

    public function listAction()
    {
        // action body
    }

    public function createAction()
    {
        // action body
    	$auth = Zend_Auth::getInstance();   	 
    	
    	if ($auth->hasIdentity()) {
    	    $userID = $auth->getIdentity()->GUID;
    	    $form = new Application_Form_Action;
    	    $this->view->form = $form;
    	    if ($this->getRequest()->isPost())
    	    {
    	    	if ($form->isValid($this->getRequest()->getPost())) {    	        	   
    	               $status = new Application_Model_Status($form->getValues());
    	               Zend_Debug::dump($form->getValues());
    	               $status->setSubjectID($userID);
    	               $statusMapper = new Application_Model_StatusMapper();
    	               $statusMapper->save($status);
    	               //return $this->_redirect('/index');    	               
    	    	}

    	    }
    	}    	  

    	else echo 'Please Login first!';
    }


}









