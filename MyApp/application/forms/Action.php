<?php

class Application_Form_Action extends Zend_Form
{

    public function init()
    {
    	ZendX_JQuery::enableForm($this);    	 
        /* Form Elements & Other Definitions Here ... */
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
    	

    	/*$entity = new ZendX_JQuery_Form_Element_SimpleTag(
    			"entityID", array('label' => 'Object:')
    	);
    	 
    	$entity->setJQueryParams(array(
    			'source' => 'http://localhost/MyApp/public/Title/index',   
    			'queryParam' => 'title',			
    			'theme' => 'facebook',
    			'method' => 'GET',
    			'jsonp' => 'jsonp_callback',
    			'tokenLimit'  => '1'
    	));
    	 
    	$this->addElement($entity);*/

    	
    	$this->addElement('submit', 'submit', array(
    			'ignore'   => true,
    			'label'    => 'Submit',
    	));
    	 
    	/*$this->addElement('hash', 'csrf', array(
    			'ignore' => true,
    	));*/
    }


}

