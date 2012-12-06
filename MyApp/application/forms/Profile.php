<?php

class Application_Form_Profile extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
   		$verb = new ZendX_JQuery_Form_Element_SimpleTag(
   				"VERBID", array('label' => 'Class:',
   						     'required' => true)
   		);
   		
   		$verb->setJQueryParams(array(
   				'source' => 'http://localhost/MyApp/public/Wordlist/index',
   				'theme' => 'facebook',
   				'queryParam' => 'verb',
   				'method' => 'GET',
   				'jsonp' => 'jsonp_callback',
   				'tokenLimit'  => '2'
   		));
   		
   		$this->addElement($verb);   
   		
   		$class = new ZendX_JQuery_Form_Element_SimpleTag(
   				"CLASSID", array('label' => 'Class:',
   						'required' => true)
   		);
   		 
   		$class->setJQueryParams(array(
   				'source' => 'http://localhost/MyApp/public/Classname/index',
   				'theme' => 'facebook',
   				'queryParam' => 'classname',
   				'method' => 'GET',
   				'jsonp' => 'jsonp_callback',
   				'tokenLimit'  => '2'
   		));
   		 
   		$this->addElement($class);
   		    		
   		$this->addElement('submit', 'submit', array(
   				'ignore'   => true,
   				'label'    => 'Submit',
   		));
   		 

    }


}

