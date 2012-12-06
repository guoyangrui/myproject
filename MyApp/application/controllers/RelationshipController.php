<?php

class RelationshipController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    	$guid = $this->_request->getParam('guid');
    	
    	$relationshipMapper = new Application_Model_RelationshipMapper();
    	
    	$friends = $relationshipMapper->getNetwork($guid);

    	$this->view->friends = $friends;   	 

    	
    }

    public function pendingAction($guid)
    {
        // action body
    	$auth = Zend_Auth::getInstance();
    	if ($auth->hasIdentity()) {
    		$relationship = new Application_Model_Relationship();
    		$pending = $relationship->getRelationship($guid);    	    
    	}   	 
        
    }

    public function requestAction()
    {
        // action body
        $auth = Zend_Auth::getInstance();        
        $guid = $this->getRequest()->getParam('guid');       
                
        if ($auth->hasIdentity()) {
        	if ($guid != $auth->getIdentity()->GUID && null != $guid) {
            	$relationship = new Application_Model_Relationship;
            	$mapper = new Application_Model_RelationshipMapper;
            	$relationship->setRequester($auth->getIdentity()->GUID)
        	             ->setRequested($guid);
            	$mapper->save($relationship);
        	}
        }
        
        else {
        	throw new Zend_Exception('Please login first!');
        }
    }

    public function rejectAction()
    {
        // action body
    	$auth = Zend_Auth::getInstance();
    	if ($auth->hasIdentity()) {
    		$userIdA = $auth->getIdentity()->id;
    		$relationship = new Application_Model_Relationship();
    	}
    	 
    }


}









