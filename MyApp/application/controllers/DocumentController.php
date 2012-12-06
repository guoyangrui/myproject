<?php

class DocumentController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    	$guid = $this->getRequest()->getParam('guid');  
    	if (null == $guid) {
    		$auth = Zend_Auth::getInstance();
    		$guid = $auth->getIdentity()->GUID;
    	}
    	$action = $this->getRequest()->getParam('action');
    	$docid = $this->getRequest()->getParam('docid');
    	
    	$documentMapper = new Application_Model_DocumentMapper();
    	   	
    	if ( 'browse' == $action) {
    		$this->view->list = $documentMapper->getClass($guid);  
    	}
    	
    	if (null != $docid) {
    		$this->view->document = $documentMapper->getDocumentByID($docid);
    	}

    	$this->view->action = $action;
    	$this->view->docid = $docid;
    	
    }

    public function createAction()
    {
        // action body        
    	$auth = Zend_Auth::getInstance();
    	if ($auth->hasIdentity()) 
    	{
    	    $authorID = $auth->getIdentity()->GUID;
    	    $form = new Application_Form_Document();
    	    $request = $this->getRequest();    	 
    	    $this->view->form = $form;
    	 
    	    if ($request->isPost()) {
    		    if ($form->isValid($request->getPost())) {    			 
    	            $document = new Application_Model_Document($form->getValues());
    	            $document->setAuthorID($authorID);
    	            $documentMapper = new Application_Model_DocumentMapper();
    	            $documentMapper->save($document);
    	            //return $this->_forward('index', 'user');
    	        }
    	    }
    	 }    
    	
    }

    public function viewAction()
    {
    	// action body
    }

    public function editAction()
    {
        // action body
    }


}







