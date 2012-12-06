<?php

class Application_Form_Triplet extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    	$auth = Zend_Auth::getInstance();
    	$subject = $this->addElement('text', 'key', array(
    			'filters' => array('StringTrim'),
    			'value'   => $auth->getIdentity()->GUID,
    			'required'   => true,
    			'label'      => 'I',
    			'disabled'   => 'disabled'    			
    		));
    	
    	$action = new ZendX_JQuery_Form_Element_SimpleTag(
    			"actionID", array('label' => 'Action:',
    					'required' => true)
    	);    	 
    	
    	$action->setJQueryParams(array(
    			'source' => 'http://localhost/MyApp/public/Wordlist/index',
    			'queryParam' => 'verb',
    			'theme' => 'facebook',
    			'method' => 'GET',
    			'jsonp' => 'jsonp_callback',
    			'tokenLimit'  => '1'
    	));
    	 
    	$this->addElement($action);  

    	$entity = new ZendX_JQuery_Form_Element_SimpleTag(
    			"classID", array('label' => 'Entity:',
    					'required' => true)
    	);
    	 
    	$entity->setJQueryParams(array(
    			'source' => 'http://localhost/MyApp/public/Classname/index',
    			'queryParam' => 'classname',
    			'theme' => 'facebook',
    			'method' => 'GET',
    			'jsonp' => 'jsonp_callback',
    			'tokenLimit'  => '20'
    	));
    	
    	$this->addElement($entity);
    	 
   	 
    	 
    }


}

