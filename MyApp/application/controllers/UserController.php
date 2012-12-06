<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body   	
    	 
    }

    public function registerAction()
    {
        // action body
        $request = $this->getRequest();
        $form = new Application_Form_Register(); 
        $this->view->form = $form;        
        
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
            	         	
        		$user = new Application_Model_User($form->getValues());
        		$userMapper = new Application_Model_UserMapper();
        		$userMapper->save($user);	
        		
        		//return $this->_redirect('/index'); 
            }     		
        }                
    }

    public function listAction()
    {
        // action body
    	$userMapper = new Application_Model_UserMapper();
    	$this->view->user = $userMapper->listUsers();
    }

    public function loginAction()
    {
        // action body
        
    	$status = Zend_Auth::getInstance();
    	$this->view->identity = $status->getIdentity();
    	
        $request = $this->getRequest();
        $loginForm = new Application_Form_Register;
        $loginForm->setAction($this->getRequest()->getBaseUrl() . '/user/login');
        $loginForm->removeElement('firstName');
        $loginForm->removeElement('lastName');        
        
        if ($request->isPost()) {
            if ($loginForm->isValid($request->getPost())) {
               	$data = $loginForm->getValues();         	            	
            	$db = Zend_Db_Table::getDefaultAdapter();
        	    $authAdapter = new Zend_Auth_Adapter_DbTable(
            			$db, 
            			'SQUSER',
            			'EMAIL',
            			'PASSWORD'
            	);            	            	           	
            	$authAdapter->setIdentity($data['email']);
        	    $authAdapter->setCredential(md5($data['password']));
        	    $result = $authAdapter->authenticate();

        	    if ($result->isValid()) {
        		    $auth = Zend_Auth::getInstance();
        		    $storage = $auth->getStorage();
        		    $userInfo = $authAdapter->getResultRowObject(array(
        		    		'GUID', 
        		    		'EMAIL', 
        		    		'FIRSTNAME', 
        		    		'LASTNAME',
        		    		'TIMECREATED')
        		    );
        		    $storage->write($userInfo);
        		    return $this->_redirect('/user/view');        		
        	    }
        	    else {
        		    $this->view->loginMessage = 'Incorrect credentials, please try again.';
        	    }
            }
        }
        $this->view->form = $loginForm;        
    }

    public function logoutAction()
    {
        // action body
        $authAdapter = Zend_Auth::getInstance();
        $authAdapter->clearIdentity();
        return $this->_redirect('/index');        
    }

    public function viewAction()
    {
        // action body
    	$auth = Zend_Auth::getInstance();
    	$this->view->identity = $auth->getIdentity();
    	
    	$guid = $this->_request->getParam('guid');
    	$tabName = $this->_request->getParam('tab');
    	$uri = $this->getRequest()->getRequestUri();    	
    	
    	if (empty($guid)) {
    		if ($auth->hasIdentity()) {
    			$guid = $auth->getIdentity()->GUID;
    		}
    	}
    	
    	$this->view->guid = $guid;
    	$this->view->relationship = NULL;
    	$this->view->tabName = $tabName;
    	
    	$relationshipMapper = new Application_Model_RelationshipMapper();
    	if ($auth->hasIdentity()) {
    		if ($auth->getIdentity()->GUID != $guid) {
    			$row = $relationshipMapper->getRelationship($auth->getIdentity()->GUID, $guid);
    			$this->view->relationship = 2;
    			if (count($row) > 0 ) {
    				$this->view->relationship = $row->APPROVED;
    			}
    		}
    	}
    	
    	if (!null == $guid) {
    		$user= new Application_Model_UserMapper();
    		$this->view->firstName = $user->getProfile($guid)->FIRSTNAME;
    		$this->view->lastName = $user->getProfile($guid)->LASTNAME;
    	}
    	
    	$relationshipMapper = new Application_Model_RelationshipMapper();
    	 
    	$network = $relationshipMapper->getNetwork($guid);
    	
    	$options = array('CLASSID' => $this->getRequest()->getParam('classid'), 
    			'VERBID' => $this->getRequest()->getParam('verbid'));
    	        	
    	$statusMapper = new Application_Model_StatusMapper();    	
   	
    	$stream = $statusMapper->getStream($guid, $relationshipMapper->getIDs($network), $options);    		
    	 
    	$this->view->stream = $stream;
    	     	
    }


}













