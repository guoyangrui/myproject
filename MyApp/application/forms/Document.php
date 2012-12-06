<?php

class Application_Form_Document extends Zend_Form
{

    public function init()
    {
    	
    	ZendX_JQuery::enableForm($this);
        /* Form Elements & Other Definitions Here ... */
   		$this->setMethod('post');   		
   		
   		$actionInput = new ZendX_JQuery_Form_Element_SimpleTag(
   				"actionID", array('label' => 'Action:',
   						'required' => true)
   		);
   		 
   		$actionInput->setJQueryParams(array(
   				'source' => 'http://localhost/MyApp/public/Wordlist/index',
   				'theme' => 'facebook',
   				'queryParam' => 'v',
   				'method' => 'GET',
   				'jsonp' => 'jsonp_callback',
   				'tokenLimit'  => '1'
   		));
   		 
   		$this->addElement($actionInput);
   		 
   	
   		$this->addElement('text', 'title', array(
   				'label'      => 'Title:',
   				'required'   => true,
   				'filters'    => array('StringTrim')
   		));
   		
   		$classInput = new ZendX_JQuery_Form_Element_SimpleTag(
   				"classID", array('label' => 'Class:',
   						     'required' => true)
   		);
   		
   		$classInput->setJQueryParams(array(
   				'source' => 'http://localhost/MyApp/public/Classname/index',
   				'theme' => 'facebook',
   				'queryParam' => 'classname',
   				'method' => 'GET',
   				'jsonp' => 'jsonp_callback',
   				'tokenLimit'  => '1'
   		));
   		
   		$this->addElement($classInput);    		 
    	
   		$this->addElement('textarea', 'content', array(
   				'label'      => 'Content:',
   				'required'   => true,
   				'filters'    => array('StringTrim')
   		));  

        $this->addElement('submit', 'submit', array(
   				'ignore'   => true,
   				'label'    => 'Submit',
   		));
    	
   		$this->addElement('hash', 'csrf', array(
  				'ignore' => true,
   		));
    	
    	}
    	 
}

