<?php

class DebugController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    	//$couch = new SQ_CouchDBAdapter('template');   
    	//$form = new Application_Form_Document();
    	//$this->view->form = $form;
    	
    	$name= 'profile';
    	$tag = '<'.$name.'>';
    	$tag.= '</'.$name.'>';   	
    	$xml = new SimpleXMLElement($tag);
    	$element = array(
    			
    	);   	
    	   	 

    	$form = new Application_Form_Triplet();
    	
    	$this->view->form = $form;
    	
    	$request = $this->getRequest();
    	
    	if ($request->isPost()) {
    		if ($form->isValid($request->getPost())) {
    			Zend_Debug::dump($form->getValues());
    		}
    	}
   	   	
    }

}

