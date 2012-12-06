<?php

class Application_Form_Search extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    	$this->setMethod('post');
    	 
    	$this->addElement('text', 'search', array(
    			'label'      => 'Enter search terms (eg. who likes starbucks):',
    			'required'   => true,
    			'filters'    => array('StringTrim')
    	));  	
    	     	
    	$this->addElement('submit', 'submit', array(
    			'ignore'   => true,
    			'label'    => 'Submit'
    	));
    	 
    }


}

